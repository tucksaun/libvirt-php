--TEST--
get_emulator
--SKIPIF--
<?php
	require_once('skipif.inc');
?>
--FILE--
<?php
	$logfile = '/tmp/test.log';
	unlink($logfile);
	if (!libvirt_logfile_set($logfile, 1))
		die('Cannot enable debug logging to test.log file');

	$conn = libvirt_connect('test:///default');
	if (!is_resource($conn))
		die('Connection to default hypervisor failed');

	$tmp = libvirt_connect_get_emulator($conn);
	if (!is_string($tmp))
		die('Cannot get default emulator');

	$tmp = libvirt_connect_get_emulator($conn, 'i686');
	if (!is_string($tmp))
		die('Cannot get emulator for i686 architecture');

	$tmp = libvirt_connect_get_emulator($conn, 'x86_64');
	if (!is_string($tmp))
		die('Cannot get emulator for x86_64 architecture');

	unset($tmp);
	unset($conn);

	printf('!done');
?>
--EXPECT--
!done
