#ifndef LIBVIRT_SOCKETS_H
#define LIBVIRT_SOCKETS_H

#include "common.h"

int connect_socket(char *server, char *port, int keepalive, int nodelay, int allow_server_override);
int socket_has_data(int sfd, long maxtime, int ignoremsg);
void    socket_read(int sfd, long length);
int socket_read_and_save(int sfd, char *fn, long length);
#endif
