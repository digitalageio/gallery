/* dd -if inputfile.bin -of outputfile.bin conv=ascii */
#include<iostream>
#include<fstream>
#include<string.h>
#include<stdlib.h>
#include<stdio.h>
using namespace std;

ifstream::pos_type size;
int length = 675;
char * record;
int main() {

/*begin stream of bin file */
ifstream currec;
currec.open("testfile.bin", ios::in | ios::binary);
/* declare record size and seek start of file */
currec.seekg (0, ios::beg);
if (currec.is_open()) {
	/* seek beginning of next record */
	record = new char [length];
	/* get 675 characters of record */
	currec.read(record, length);
	/* determine record type from position 32-34 */
		/*copy c-string record to string*/
		string recordstring((const char*)record);
		/* create ffname with substr */
		string ffname = recordstring.substr(31,3);
		const char * cffname = ffname.c_str();
	/*convert ffname to int for comparisons*/
	int ffcode = atoi(cffname);
	/* write record to appropriate file */
	ofstream endrec("510", ios::app | ios::binary);
	endrec.write(record, length);
	/* skip characters to next record, if appropriate */
	switch (ffcode) {
		case 800: 
			currec.ignore(8, EOF);
			break;
		case 801:
			currec.ignore(10, EOF);
			break;
		case 802:
			currec.ignore(10, EOF);
			break;
		default:
			break;
		}
	/* clear record for next loop */
	
	}
return 0;
}
 

