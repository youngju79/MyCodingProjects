#include <iostream>
#include <string>
#include "product.h"

class Movie : public Product {
public:
	Movie(const std::string category, const std::string name, double price, int qty,
		const std::string genre, const std::string rating) :
		Product(category, name, price, qty)
	{
		genre_ = genre;
		rating_ = rating;
	}
	~Movie();
	std::set<std::string> keywords() const;
	std::string displayString() const;
	void dump(std::ostream& os) const;
	std::string genre_;
	std::string rating_;
};