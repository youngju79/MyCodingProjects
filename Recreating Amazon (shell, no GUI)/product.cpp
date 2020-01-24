#include <sstream>
#include <iomanip>
#include "product.h"

using namespace std;

Product::Product(const std::string category, const std::string name, double price, int qty) :
    name_(name),
    price_(price),
    qty_(qty),
    category_(category)
{

}

Product::~Product()
{
    for(int i=0; i<(signed int)rev.size(); i++){
        delete rev[i];
    }
}

double Product::getPrice() const
{
    return price_;
}

std::string Product::getName() const
{
    return name_;
}

void Product::subtractQty(int num)
{
    qty_ -= num;
}

int Product::getQty() const
{
    return qty_;
}

/**
 * default implementation...can be overriden in a future
 * assignment
 */
bool Product::isMatch(std::vector<std::string>& searchTerms) const
{
    return false;
}

void Product::dump(std::ostream& os) const
{
    os << category_ << "\n" << name_ << "\n" << price_ << "\n" << qty_ << endl;
}

double Product::getAvg_rev() const
{
    double final = 0;
    if((signed int)rev.size() == 0){
        return final;
    }
    double total = 0;
    double avg = 0;
    for(int i=0; i<(signed int)rev.size(); i++){
        avg++;
        total+=rev[i]->rating;
    }
    final = total/avg;
    return final;
}

std::vector<Review*> Product::getRev()
{
    return rev;
}

void Product::addRev(Review* a)
{
    rev.push_back(a);
}

int Product::getUser_rev(string user)
{
    //find user's rev
    for(int i=0; i<(signed int)rev.size(); i++){
        //found user
        if(rev[i]->username == user){
            return rev[i]->rating;
        }
    }
    return -1;
}