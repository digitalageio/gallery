#include<iostream>
#include<fstream>
#include<string>


unsigned int lulz(unsigned char const* nybbles, size_t length)
{
    unsigned int result(0);
    while (length--) {
        result = result * 100 + (*nybbles >> 4) * 10 + (*nybbles & 15);
        ++nybbles;
    }
    return result;
}

int main() {

size_t length = 6;

