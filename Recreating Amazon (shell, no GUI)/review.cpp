#include <iostream>
#include "review.h"

using namespace std;

void Review::dump(std::ostream& os) const 
{
	os << rating << " " << username << " " << date << " " << reviewText << endl;
}