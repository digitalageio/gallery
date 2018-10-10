#include<iostream>

char main(unsigned char src, char *dest) { 
    static const char outputs[] = "0123456789ABCDEF";
    *dest++ = outputs[src>>4];
    *dest++ = outputs[src&0xf];
    *dest = '\0';
}

