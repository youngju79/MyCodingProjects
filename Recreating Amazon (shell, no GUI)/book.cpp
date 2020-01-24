#include <iostream>
#include <set>
#include <string>
#include "book.h"
#include "util.h"
#include <sstream>
#include <iomanip>

using namespace std;

Book::~Book(){

}
std::set<std::string> Book::keywords() const 
{
	set<string> s = parseStringToWords(name_);
	s.insert(isbn_);
	set<string> temp = parseStringToWords(author_);
	set<string>::iterator it;
	for(it=temp.begin(); it!=temp.end(); ++it){
		s.insert(*it);
	}
	temp.clear();
	return s;
}

std::string Book::displayString() const 
{
	stringstream s;
	s << fixed << setprecision(2) << price_;
	string temp = name_;
	temp += "\n";
	temp += "Author: ";
	temp += author_;
	temp += " ";
	temp += "ISBN: ";
	temp += isbn_;
	temp += "\n";
	temp += s.str();
	temp += " ";
	temp += to_string(qty_);
	temp += " left.";
	return temp;
}

void Book::dump(std::ostream& os) const 
{
	os << category_ << "\n" << name_ << "\n" << price_ << "\n" << qty_ << endl;
	os << isbn_ << "\n" << author_ << endl;
}