--TEST--
domain_snapshot
--SKIPIF--
<?php
	require_once('skipif.inc');
	if(!libvirt_connect()) die("skip this test need an real hypervisor");
?>
--FILE--
<?php
	$conn = libvirt_connect(NULL, false);
	if (!is_resource($conn))
		die('Connection to default hypervisor failed');

	$xml = file_get_contents(__DIR__.'/data/example-qcow2-disk.xml');

	$res = libvirt_domain_create_xml($conn, $xml);
	if (!is_resource($res))
		die('Domain definition failed with error: '.libvirt_get_last_error());

	if (!($snapshot = libvirt_domain_has_current_snapshot($res)) && !is_null(libvirt_get_last_error()))
		die('An error occured while getting domain snapshot: '.libvirt_get_last_error());

	if (!is_resource($snapshot_res = libvirt_domain_snapshot_create($res)))
		die('Error on creating snapshot: '.libvirt_get_last_error());

	if (!($xml = libvirt_domain_snapshot_get_xml($snapshot_res)))
		die('Error on getting the snapshot XML description: '.libvirt_get_last_error());

	if (!$xml)
		die('Empty XML description string');

	if (!libvirt_domain_has_current_snapshot($res))
		die('Domain should be having current snapshot but it\'s not having it');

	if (!libvirt_domain_snapshot_revert($snapshot_res))
		die('Cannot revert to the domain snapshot taken now: '.libvirt_get_last_error());

	if (!($snapshots=libvirt_list_domain_snapshots($res)))
		die('Domain snapshots listing query failed: '.libvirt_get_last_error());

	for ($i = 0; $i < sizeof($snapshots); $i++) {
		$cur = libvirt_domain_snapshot_lookup_by_name($res, $snapshots[$i]);
		libvirt_domain_snapshot_delete($snapshot_res);
		unset($cur);
	}

	unset($snapshot_res);

	$snapshot_res = libvirt_domain_snapshot_create($res);
	if (!libvirt_domain_snapshot_delete($snapshot_res, VIR_SNAPSHOT_DELETE_CHILDREN))
		die('Cannot delete snapshot with children: '.libvirt_get_last_error());

	if (!libvirt_domain_destroy($res))
		die('Domain destroy failed with error: '.libvirt_get_last_error());

	unset($res);
	unset($conn);

	printf('!done');
?>
--EXPECT--
!done
