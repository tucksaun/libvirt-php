<?php
if (!extension_loaded('libvirt')) {
    if (!dl('../modules/libvirt.so'))
        print('skip Cannot load libvirt extension. Please install libvirt-php first (using `make install`)');
}
