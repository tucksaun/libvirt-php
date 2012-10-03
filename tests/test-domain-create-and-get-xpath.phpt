--TEST--
domain_create_and_get_xpath
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

	$info = libvirt_domain_xml_xpath($res, '/domain/name');
	if (!$info)
		die('Cannot get domain XML and/or xPath expression');

	if (!array_key_exists('num', $info))
		die('Num element is missing in the output array');

	for ($i = 0; $i < $info['num']; $i++)
		if (!array_key_exists($i, $info))
			die("Element $i doesn\'t exist in the output array");

	if (!libvirt_domain_destroy($res))
		die('Domain destroy failed with error: '.libvirt_get_last_error());

	unset($res);
	unset($conn);

	printf('!done');
?>
--EXPECT--
!done
