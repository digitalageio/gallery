/* csvconv.c - main program
   reconv.h - function for reading fields.txt
   bcdconv.h - converter function of BCD fields
   fields.txt - reference file of field#, widths, BCD */
#include<iostream>
#include<fstream>
#include<stdio>
#include<stdlib>
#include<bcdconv.h>

unsigned int bcd2i(unsigned int bcd) {
    unsigned int decimalMultiplier = 1;
    unsigned int digit;
    unsigned int i = 0;
    while (bcd > 0) {
        digit = bcd & 0xF;
        i += digit * decimalMultiplier;
        decimalMultiplier *= 10;
        bcd >>= 4;
    }
    return i;


/* ri = record iterator
   fi = field iterator
   bi = bcd array iterator
   rtype - 3 number key determined by name of input file
   fnum - number of fields
   bnum - number of bcd fields */
int fi = 0;
int bi = 0;

int main (int argc) {

/* read in reference file to initialize the three arrays */
int rtype = argc;
int fnum = reconv(fnum);
int bnum = reconv(bnum);
string arrmain[fnum];
int arrref[fnum];
int arrbcd[bnum];
char * record;


/* read 675 bytes into array of strings */
fstream currec;
currec.open(rtype, ios::in | ios::binary | ios::out);
currec.seekg(0, ios::beg);
while(currec.is_open()) {
	record = new char [675];
	currec.read(record, length);
	string recordstring((const char*)record);
	string field = recordstring.substr(219,6);
	unsigned int bcd = field;
	unsigned int newfield = bcd2i(bcd);
	ofstream endrec("510csv", ios::app);
	currec.write(newfield);
}
}
/* use second array of field widths as reference for loop */ 
/* 3rd array is list of fields containing BCD */
/* perform conversion on fields with marked BCD variable */
/* separate with commas and write to new file */
/* loop back to start, repeat till EOF */
