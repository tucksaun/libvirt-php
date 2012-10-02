dnl config.m4 for extension libvirt-php

PHP_ARG_WITH(libvirt, for libvirt support,
[  --with-libvirt[=DIR]       Include libvirt support])

PHP_ARG_WITH(libxml, for XML support,
[  --with-libxml[=DIR]        Include libvirt support])

if test "$PHP_LIBXML" != "no"; then
  if test -r $PHP_LIBXML/libxml/xmlstring.h; then
    LIBXML_DIR=$PHP_LIBXML
  else
    AC_MSG_CHECKING(for libxml in default path)
    for i in /usr/local /usr /usr/include; do
      if test -r $i/libxml2/libxml/xmlstring.h; then
        LIBXML_DIR=$i/libxml2
        AC_MSG_RESULT(found in $i)
      fi
    done
  fi

  if test -z "$LIBXML_DIR"; then
    AC_MSG_RESULT(not found)
    AC_MSG_ERROR(Please reinstall the libxml2 distribution - xmlstring.h should be in <libxml2-dir>/libxml)
  fi
  PHP_ADD_INCLUDE($LIBXML_DIR)

  PHP_SUBST(LIBXML_SHARED_LIBADD)
  PHP_ADD_LIBRARY_WITH_PATH(xml2, $LIBXML_DIR/lib, LIBXML_SHARED_LIBADD)

  if test -r $PHP_LIBVIRT/lib/libvirt.a; then
    LIBVIRT_DIR=$PHP_LIBVIRT
  else
    AC_MSG_CHECKING(for libvirt in default path)
    for i in /usr/local /usr; do
      if test -r $i/lib/libvirt.a; then
        LIBVIRT_DIR=$i
        AC_MSG_RESULT(found in $i)
      fi
    done
  fi

  if test -z "$LIBVIRT_DIR"; then
    AC_MSG_RESULT(not found)
    AC_MSG_ERROR(Please reinstall the libvirt distribution - libvirt.h should be in <libvirt-dir>/include and libvirt.h should be in <libvirt-dir>/lib)
  fi
  PHP_ADD_INCLUDE($LIBVIRT_DIR/include)

  PHP_SUBST(LIBVIRT_SHARED_LIBADD)
  PHP_ADD_LIBRARY_WITH_PATH(virt, $LIBVIRT_DIR/lib, LIBVIRT_SHARED_LIBADD)

  dnl AC_DEFINE(HAVE_LIBVIRT, 1, [Whether you want libvirt support])

  PHP_NEW_EXTENSION(libvirt, src/libvirt-php.c src/sockets.c src/vncfunc.c, $ext_shared)
fi

