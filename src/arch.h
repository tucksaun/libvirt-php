#ifndef LIBVIRT_ARCH_H
#define LIBVIRT_ARCH_H

#ifdef __BIG_ENDIAN
#define IS_BIGENDIAN  1
#else
#define IS_BIGENDIAN  0
#endif

#define SWAP2_BY_ENDIAN(le, v1, v2) (((le && IS_BIGENDIAN) || (!le && !IS_BIGENDIAN)) ? ((v2 << 8) + v1) : ((v1 << 8) + v2))
#define PUT2_BYTE_ENDIAN(le, val, v1, v2) { if ((le && IS_BIGENDIAN) || (!le && !IS_BIGENDIAN)) { v2 = val >> 8; v1 = val % 256; } else { v1 = val >> 8; v2 = val % 256; } }
#define SWAP2_BYTES_ENDIAN(le, a, b) { if ((le && IS_BIGENDIAN) || (!le && !IS_BIGENDIAN)) { uint8_t _tmpval; _tmpval = a; a = b; b = _tmpval; } }

#ifdef __i386__
typedef uint32_t arch_uint;
#define UINTx PRIx32
#else
typedef uint64_t arch_uint;
#define UINTx PRIx64
#endif

#define UINT32STR(var, val)     \
        var[0] = (val >> 24) & 0xff;    \
        var[1] = (val >> 16) & 0xff;    \
        var[2] = (val >>  8) & 0xff;    \
        var[3] = (val      ) & 0xff;

#define GETUINT32(var)  (uint32_t)(((uint32_t)var[0] << 24) + ((uint32_t)var[1] << 16) + ((uint32_t)var[2] << 8) + ((uint32_t)var[3]))

#endif