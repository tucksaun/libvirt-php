--TEST--
domain_create_and_coredump
--SKIPIF--
<?php
	require_once('skipif.inc');
?>
--FILE--
<?php
	$conn = libvirt_connect('test:///default',  false);
	if (!is_resource($conn))
		die('Connection to default hypervisor failed');

	$xml = file_get_contents(__DIR__.'/data/example-no-disk-and-media.xml');

	$res = libvirt_domain_create_xml($conn, $xml);
	if (!is_resource($res))
		die('Domain definition failed with error: '.libvirt_get_last_error());

	$name = tempnam(sys_get_temp_dir(), 'guestdumptest');
	if (!libvirt_domain_core_dump($res, $name))
		die('Cannot dump core of the guest: '.libvirt_get_last_error());

	if (!libvirt_domain_destroy($res)) {
		unlink($name);
		die('Domain destroy failed with error: '.libvirt_get_last_error());
	}

	unset($res);
	unset($conn);
	unlink($name);

	printf('!done');
?>
--EXPECT--
!done
