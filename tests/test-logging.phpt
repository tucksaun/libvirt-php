--TEST--
logging
--SKIPIF--
<?php
	require_once('skipif.inc');
	if(!function_exists('libvirt_logfile_set')) print('please compile libvirt-php with debug support')
?>
--FILE--
<?php
	$logfile = 'test.log';

	@unlink($logfile);
	if (!libvirt_logfile_set($logfile, 1))
		die('Cannot enable debug logging to test.log file');

	$conn = libvirt_connect('test:///default');
	if (!is_resource($conn))
		die('Connection to default hypervisor failed');

	$res = libvirt_node_get_info($conn);
	if (!is_array($res))
		die('Node get info doesn\'t return an array');

	if (!is_numeric($res['memory']))
		die('Invalid memory size');
	if (!is_numeric($res['cpus']))
		die('Invalid CPU core count');
	unset($res);

	if (!libvirt_connect_get_uri($conn))
		die('Invalid URI value');

	if (!libvirt_connect_get_hostname($conn))
		die('Invalid hostname value');

	if (!($res = libvirt_domain_get_counts($conn)))
		die('Invalid domain count');

	if ($res['active'] != count( libvirt_list_active_domains($conn)))
		die('Numbers of active domains mismatch');

	if ($res['inactive'] != count( libvirt_list_inactive_domains($conn)))
		die('Numbers of inactive domains mismatch');
	unset($res);

	if (libvirt_connect_get_hypervisor($conn) == false)
		echo "Warning: Getting hypervisor information failed!\n";

	if (libvirt_connect_get_maxvcpus($conn) == false)
		echo "Warning: Cannot get the maximum number of VCPUs per VM!\n";

	if (libvirt_connect_get_capabilities($conn) == false)
		die('Invalid capabilities on the hypervisor connection');

	if (@libvirt_connect_get_information($conn) == false)
		die('No information on the connection are available');

	unset($conn);

	$fp = fopen($logfile, 'r');
	$log = fread($fp, filesize($logfile));
	fclose($fp);

	$ok = ((strpos($log, 'libvirt_connect: Connection')) &&
		(strpos($log, 'libvirt_connection_dtor: virConnectClose')));

	unlink($logfile);

	if (!$ok)
		die('Missing entries in the log file');

	printf('!done');
?>
--EXPECT--
!done
