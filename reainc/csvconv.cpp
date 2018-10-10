/* csvconv.c - main program
   reconv.h - function for reading fields.txt
   bcdconv.h - converter function of BCD fields
   fields.txt - reference file of field#, widths, BCD */
#include<ios>
#include<iostream>
#include<fstream>
#include<sstream>
#include<cstdio>
#include<cstdlib>
using namespace std;
//record type (determined by argument filename)
char rtype = argv;

int main () {
//reference to initialize the three arrays

switch (rtype) {
	case 510:
	int bcdpos[12] = '218,318,342,357,420,433,445,462,474,478,485,513';
	int bcdlen[12] = '6,23,12,2,12,12,9,6,2,5,26,2';

	case 540:
	int bcdarr[2] = '44,58';
	int bcdlen[2] = '5,5';

	case 560:
	int bcdarr[3] = '54,83,97';
	int bcdlen[3] = '20,4,5';

	case 600:
	int bcdarr[33] = '37,46,53,87,96,103';
	int bcdlen = '6,6,21,6,6,18';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case 510:
	int bcdarr[33] = ' ';

	case default:
	int bcdarr[33] = ' ';


//int fnum = reconv(fnum);
//int bnum = reconv(bnum);
//string arrmain[fnum];
//int arrref[fnum];
//int arrbcd[bnum];
char * record;


/* read 675 bytes into array of strings */
ifstream currec;
currec.open("510", ifstream::in | ifstream::binary | ifstream::out);
currec.seekg(0, ifstream::beg);
while(currec.is_open()) {
	int length = 675;
	record = new char [675];
	currec.read(record, length);
	string recordstring((const char*)record);
	string field = recordstring.substr(219,6);
	const char * ffield = field.c_str();
	const char endfield = lulz(ffield);
	fstream endrec("510csv", ios::app | ios::binary);
	endrec.write(endfield, 6);
}
}
/* use second array of field widths as reference for loop */ 
/* 3rd array is list of fields containing BCD */
/* perform conversion on fields with marked BCD variable */
/* separate with commas and write to new file */
/* loop back to start, repeat till EOF */

void BCD_To_ASCII(unsigned char bcd_value, char * p_ascii_text)
{
  //--------------------------------------------------
  // BCD contains digits 0 .. 9 in the binary nibbles
  //--------------------------------------------------
  *p_ascii_text++ = (bcd_value >> 4)  + '0';
  *p_ascii_text++ = (bcd_value & 0x0f) + '0';
  *p_ascii_text = '\0';
  return;
}

