#include<iostream>
#include<fstream>
#include<vector>
#include<cstring>
#include<string.h>
#include<stdlib.h>
#include<stdio.h>
using namespace std;

ifstream::pos_type size;
int length = 675;
char * record;
int a2e[256] = {0,1,2,3,55,45,46,47,22,5,37,11,12,13,14,15,16,17,
18,19,60,61,50,38,24,
25,63,39,28,29,30,31,
64,79,127,123,91,108,80,
125,77,93,92,78,107,96,75,97,240,241,242,243,244,245,246,
247,248,249,122,94,76,126,110,
111,124,193,194,195,
196,197,198,199,200,201,209,
210,211,212,213,214,215,216,
217,226,227,228,229,230,231,232,
233, 74,224, 90, 95,109,121,129,130,131,132,
133,134,135,136,137,145,146,147,
148,149,150,151,152,153,162,163,
164,165,166,167,168,169,192,106,
208,161,7,32,33,34,35,36,21,
6,23,40,41,42,43,44,9,10,27,
48,49,26,51,52,53,54,8,56,57,
58,59,4,20,62,225,65,66,67,68,
69,70,71,72,73,81,82,83,84,85,86,87,88,89,98,99,100,101,102,103,104,105,112,113,
114,115,116,117,118,119,120,128,138,
139,140,141,142,143,144,154,155,156,
157,158,159,160,170,171,172,173,174,
175,176,177,178,179,180,181,182,183,
184,185,186,187,188,189,190,191,202,
203,204,205,206,207,218,219,220,221,
222,223,234,235,236,237,238,239,250,
251,252,253,254,255};
int fftype;
const int numfields = 33;
vector<string> fieldlist;
int fieldpos[]={218,220,222,318,322,326,331,336,342,344,349,357,420,423,426,430,433,436,439,442,446,448,450,462,464,466,476,478,485,490,495,503,513};
int fieldlen[]={2,2,2,4,4,5,5,5,2,5,5,2,3,3,3,3,3,3,3,3,2,2,5,2,2,2,2,5,5,5,8,8,2};

int main() {


/* begin stream of bin file */
ifstream currec;
currec.open("510", ios::in | ios::binary);

/* switch to determine variables */

/* declare record size and seek start of file */
currec.seekg (0, ios::beg);

while (currec.is_open()) {
	/* seek beginning of next record */
	record = new char [length];
	/* get 675 characters of record */
	currec.read(record, length);

	/*copy c-string record to string*/
	string recordstring((const char*)record);

	/* create substring of field */
	int i=0;
	for (i = 0; i < numfields; i++){ 
		int y = fieldlen[i];
		int x = fieldpos[i];

		string field = recordstring.substr(fieldpos[i],fieldlen[i]);

	/* perform operations on individual chars, store in unpack[] */
		string unpack;
		int h=0;
		for (h = 0; h < x; h++) {
			int ord = field[h];
			int temp = a2e[ord];
			int high = temp >> 4;
			int low = temp & 0xF;
			unpack += high;
			unpack += low;
		 }
		
	/* copy unpack to string stored in fieldlist[] */
		fieldlist.push_back(unpack);
	}

	/* replace sections using offset to compensate for doubled length */
	recordstring.replace(fieldpos[0], fieldlen[0], fieldlist.at(0));
	int m=1;
	for(m = 1; m < numfields; m++) {
		int offset = offset + (fieldlen[m]);
		int position = fieldpos[m] + offset;
		recordstring.replace(position, fieldlen[m], fieldlist.at(m));
	}
	

	/* write record to file */
	ofstream endrec("cffname", ios::app | ios::binary);
	const char* newrecord = recordstring.c_str();
	endrec.write(newrecord, length);

	continue;
	}
return 0;
}
 


