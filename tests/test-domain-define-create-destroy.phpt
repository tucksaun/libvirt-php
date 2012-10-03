--TEST--
domain_define_create_destroy
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

	$res = libvirt_domain_define_xml($conn, $xml);
	if (!is_resource($res))
		die('Domain definition failed with error: '.libvirt_get_last_error());

	if (!libvirt_domain_create($res))
		die('Domain creation failed with error: '.libvirt_get_last_error());

	$info = libvirt_domain_get_info($res);
	if (!$info)
		die('Getting domain information failed with error: '.libvirt_get_last_error());

	$cpuUsed = $info['cpuUsed'];

	sleep(5);

	$info = libvirt_domain_get_info($res);
	if (!$info)
		die('Getting domain information failed with error: '.libvirt_get_last_error());

	if ($cpuUsed == $info['cpuUsed'])
		die('No time difference between CPU times after 5 seconds');

	if (!libvirt_domain_destroy($res))
		die('Domain destroy failed with error: '.libvirt_get_last_error());

	if (!libvirt_domain_undefine($res))
		die('Domain undefinition failed with error: '.libvirt_get_last_error());

	unset($res);
	unset($conn);

	printf('!done');
?>
--EXPECT--
!done
