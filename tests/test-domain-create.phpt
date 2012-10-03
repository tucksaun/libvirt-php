--TEST--
domain_create
--SKIPIF--
<?php
	require_once('skipif.inc');
?>
--FILE--
<?php
	$conn = libvirt_connect('test:///default', false);
	if (!is_resource($conn))
		die('Connection to default hypervisor failed');

	$xml = file_get_contents(__DIR__.'/data/example-no-disk-and-media.xml');

	$res = libvirt_domain_create_xml($conn, $xml);
	if (!is_resource($res))
		die('Domain definition failed with error: '.libvirt_get_last_error());

	$info = libvirt_domain_get_info($res);
	if (!$info)
		die('Getting domain information failed with error: '.libvirt_get_last_error());

	if (!libvirt_domain_destroy($res))
		die('Domain destroy failed with error: '.libvirt_get_last_error());

	unset($res);
	unset($conn);

	printf('!done');
?>
--EXPECT--
!done
