#ifndef LIBVIRT_DEBUG_H
#define LIBVIRT_DEBUG_H

char *get_datetime(void);
int set_logfile(char *filename, long maxsize TSRMLS_DC);
#ifdef DEBUG_SUPPORT
extern int gdebug;
#define DEBUG_CORE
#define DEBUG_VNC
#define DEBUG_SOCKETS
#endif

#endif
