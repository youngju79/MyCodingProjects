#include <iostream>
#include <string>
#include "product.h"

class Clothing : public Product {
public:
	Clothing(const std::string category, const std::string name, double price, int qty,
		const std::string size, const std::string brand) : 
		Product(category, name, price, qty) 
	{
		size_ = size;
		brand_ = brand;
	}
	~Clothing();
	std::set<std::string> keywords() const;
	std::string displayString() const;
	void dump(std::ostream& os) const;
	std::string size_;
	std::string brand_;
};