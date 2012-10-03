--TEST--
libvirt_version
--SKIPIF--
<?php
    require_once('skipif.inc');
?>
--FILE--
<?php
	if (!is_array( libvirt_version() ) )
		die("Libvirt version doesn't return an array");

	printf('!done');
?>
--EXPECT--
!done
