--TEST--
connect
--SKIPIF--
<?php
	require_once('skipif.inc');
?>
--FILE--
<?php
	$conn = libvirt_connect('test:///default');
	if (!is_resource($conn))
		die('Connection to default hypervisor failed');

	unset($conn);
	printf('!done')
?>
--EXPECT--
!done
