#ifndef LIBVIRT_VNCFUNC_H
#define LIBVIRT_VNCFUNC_H

/* Maximum number of authentication attempts */
#define VNC_MAX_AUTH_ATTEMPTS       10

#include "common.h"

#define UC(a)           (unsigned char)a
#define CALC_UINT32(a, b, c, d) (uint32_t)((a >> 24) + (b >> 16) + (c >> 8) + d)

typedef struct tServerFBParams {
    int width;
    int height;
    int bpp;
    int depth;
    int bigEndian;
    int trueColor;
    int maxRed;
    int maxGreen;
    int maxBlue;
    int shiftRed;
    int shiftGreen;
    int shiftBlue;
    int desktopNameLen;
    unsigned char *desktopName;
} tServerFBParams;

typedef struct tBMPFile {
    uint32_t filesz;
    uint16_t creator1;
    uint16_t creator2;
    uint32_t bmp_offset;

    uint32_t header_sz;
    int32_t height;
    int32_t width;
    uint16_t nplanes;
    uint16_t bitspp;
    uint32_t compress_type;
    uint32_t bmp_bytesz;
    int32_t hres;
    int32_t vres;
    uint32_t ncolors;
    uint32_t nimpcolors;
} tBMPFile;

int vnc_get_dimensions(char *server, char *port, int *width, int *height);
int vnc_get_bitmap(char *server, char *port, char *fn);
#endif
