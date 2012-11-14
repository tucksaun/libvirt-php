#ifndef LIBVIRT_COMMON_H
#define LIBVIRT_COMMON_H

#include <libvirt/libvirt.h>
#include <libvirt/virterror.h>
#include <libxml/parser.h>
#include <libxml/xpath.h>
#include <dirent.h>
#include <strings.h>
#include <fcntl.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <sys/wait.h>
#include <netdb.h>
#include <inttypes.h>

#ifdef __APPLE__
#include <netinet/tcp.h>
#else
#include <linux/tcp.h>
#endif

#include "php.h"
#undef PACKAGE_BUGREPORT
#undef PACKAGE_NAME
#undef PACKAGE_STRING
#undef PACKAGE_TARNAME
#undef PACKAGE_URL
#undef PACKAGE_VERSION
#include "php_ini.h"
#include "standard/info.h"

#ifdef HAVE_CONFIG_H
#include "../config.h"
#endif

#include "debug.h"
#include "arch.h"
#include "sockets.h"
#include "vncfunc.h"

#endif
