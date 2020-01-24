#include <iostream>
#include <set>
#include <string>
#include "clothing.h"
#include "util.h"
#include <iomanip>
#include <sstream>

using namespace std;

Clothing::~Clothing(){
	
}
std::set<std::string> Clothing::keywords() const {
	set<string> s = parseStringToWords(name_);
	set<string> temp = parseStringToWords(brand_);
	set<string>::iterator it;
	for(it=temp.begin(); it!=temp.end(); ++it){
		s.insert(*it);
	}
	return s;
}
std::string Clothing::displayString() const {
	stringstream s;
	s << fixed << setprecision(2) << price_;
	string temp = name_;
	temp += "\n";
	temp += "Size: ";
	temp += size_;
	temp += " ";
	temp += "Brand: ";
	temp += brand_;
	temp += "\n";
	temp += s.str();
	temp += " ";
	temp += to_string(qty_);
	temp += " left.";
	return temp;
}
void Clothing::dump(std::ostream& os) const {
	os << category_ << "\n" << name_ << "\n" << price_ << "\n" << qty_ << endl;
	os << size_ << "\n" << brand_ << endl;
}