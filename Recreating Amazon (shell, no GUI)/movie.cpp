#include <iostream>
#include <set>
#include <string>
#include "movie.h"
#include "util.h"
#include <iomanip>
#include <sstream>

using namespace std;

Movie::~Movie(){

}
std::set<std::string> Movie::keywords() const {
	set<string> s = parseStringToWords(name_);
	s.insert(genre_);
	return s;
}
std::string Movie::displayString() const {
	stringstream s;
	s << fixed << setprecision(2) << price_;
	string temp = name_;
	temp += '\n';
	temp += "Genre: ";
	temp += genre_;
	temp += " ";
	temp += "Rating: ";
	temp += rating_;
	temp += '\n';
	temp += s.str();
	temp += " ";
	temp += to_string(qty_);
	temp += " left.";
	return temp;
}
void Movie::dump(std::ostream& os) const {
	os << category_ << "\n" << name_ << "\n" << price_ << "\n" << qty_ << endl;
	os << genre_ << "\n" << rating_ << endl;
}