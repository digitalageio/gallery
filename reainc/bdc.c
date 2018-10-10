#include <iostream>
#include <vector>
#include <algorithm>
#include <string>

typedef unsigned char UINT8;

namespace
{
  static char BCD_to_ASCII(const UINT8& u)
  {
    return static_cast<char>(u + static_cast<UINT8>(0x30u));
  }
}

int main(int argc, char* argv[])
{
  // Declare the data which should be converted BCD.
  static const UINT8 bcd_data[] = { 1, 2, 3, 4, 5, 6, 7, 8 };

  // Put these data into a standard vector container.
  static const std::vector<UINT8> bcd(bcd_data, bcd_data + (sizeof(bcd_data) / sizeof(bcd_data[0])));

  // Declare an output string for the conversion and be sure that it is created with
  // enough storage space.
  std::string str(bcd.size(), static_cast<char>('\0'));

  // Use the standard function std::transform in combination with a unary function for
  // the conversion.
  std::transform(bcd.begin(), bcd.end(), str.begin(), ::BCD_to_ASCII);

  std::cout << str << std::endl;
}
