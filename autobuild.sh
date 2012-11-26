#!/bin/sh

set -e
set -v

make distclean || :

phpize
./configure
make

rm -f *.tar.gz
make dist

if [ -n "$AUTOBUILD_COUNTER" ]; then
  EXTRA_RELEASE=".auto$AUTOBUILD_COUNTER"
else
  NOW=`date +"%s"`
  EXTRA_RELEASE=".$USER$NOW"
fi

if [ -x /usr/bin/rpmbuild ]
then
  rpmbuild --nodeps \
     --define "extra_release $EXTRA_RELEASE" \
     --define "_sourcedir `pwd`" \
     -ba --clean libvirt-php.spec
fi
