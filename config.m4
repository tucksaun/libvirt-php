dnl config.m4 for extension libvirt-php
AC_DEFUN([AC_INIT], [
  VERSION="$2"

  AC_DEFINE_UNQUOTED([PACKAGE], ["$1"], [Name of package])
  AC_DEFINE_UNQUOTED([VERSION], ["$2"], [Version number of package])

  AC_DEFINE_UNQUOTED([PACKAGE_NAME], ["$1"], [Define to the full name of this package])
  AC_DEFINE_UNQUOTED([PACKAGE_VERSION], ["$2"], [Define to the version of this package.])

  AC_DEFINE_UNQUOTED([PACKAGE_STRING], ["$1 $2"], [Define to the full name and version of this package.])

  AC_DEFINE_UNQUOTED([PACKAGE_URL], ["$3"], [Define to the home page for this package.])
  AC_DEFINE_UNQUOTED([PACKAGE_BUGREPORT], ["$3"], [Define to the address where bug reports for this package should be sent.])
])

AC_INIT([libvirt-php], [0.4.6], [http://libvirt.org/php.html])

dnl Get the version information at compile-time
VERSION_MAJOR=`echo $VERSION | awk -F. '{print $1}'`
VERSION_MINOR=`echo $VERSION | awk -F. '{print $2}'`
VERSION_MICRO=`echo $VERSION | awk -F. '{print $3}'`

AC_DEFINE_UNQUOTED(VERSION_MAJOR, $VERSION_MAJOR, [Major version number of package])
AC_DEFINE_UNQUOTED(VERSION_MINOR, $VERSION_MINOR, [Minor version number of package])
AC_DEFINE_UNQUOTED(VERSION_MICRO, $VERSION_MICRO, [Micro version number of package])

if test "$PHP_DEBUG" != "yes"; then
  PHP_ARG_ENABLE(debug, for debug support,
  [  --enable-debug          Enable debug support], no, no)
else
  PHP_DEBUG="yes"
fi

if test "$PHP_DEBUG" != "no"; then
  AC_DEFINE(DEBUG_SUPPORT, 1, [Enable debug support])
fi

PHP_ARG_WITH(libvirt, for libvirt support,
[  --with-libvirt[=DIR]      Include libvirt support])

PHP_ARG_WITH(libxml, for XML support,
[  --with-libxml[=DIR]       Include libvirt support])

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
fi


if test "$PHP_LIBVIRT" != "no"; then
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

fi

TOOLS_DIR="tools"
DOC_DIR="docs"
SUBDIRS="$TOOLS_DIR $DOC_DIR"
EXTRA_DIST="libvirt-php.spec.in"
PHP_SUBST(TOOLS_DIR)
PHP_SUBST(DOC_DIR)
PHP_SUBST(SUBDIRS)
PHP_SUBST(EXTRA_DIST)

PHP_NEW_EXTENSION(libvirt, src/libvirt-php.c src/sockets.c src/vncfunc.c, $ext_shared)

PHP_ADD_MAKEFILE_FRAGMENT
