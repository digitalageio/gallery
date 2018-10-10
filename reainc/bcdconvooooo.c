#include <iostream>
#include <sstream>
#include <fstream>
#include <string>
using namespace std;

typedef unsigned char UINT8;

bool BCD_to_ASCII(const UINT8* bcd, const int length, ::std::string& str_ascii)
{
  if(length)
  {
    ::std::stringstream ss;

    for(int i = 0; i < length; i++)
    {
      ss << static_cast<char>(bcd[i] + 0x30);
    }

    ss << ::std::endl;

    ss >> str_ascii;

    return true;
  }
  else
  {
    return false;
  }
}

int main(int argc, char* argv[])
{
  UINT8 bcd[] = { 1, 2, 3, 4, 5, 6, 7, 8 };
  ::std::string str;

  BCD_to_ASCII(bcd, sizeof(bcd)/ sizeof(bcd[0]), str);

  ::std::cout << str << ::std::endl;

  return 0;
}
