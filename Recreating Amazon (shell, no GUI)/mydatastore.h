#include <iostream>
#include <vector>
#include <map>
#include <set>
#include "datastore.h"
#include "util.h"
#include "review.h"

class MyDataStore : public DataStore {
public:
	void addProduct(Product* p);
	~MyDataStore();
	void addUser(User* u);
	std::vector<Product*> search(std::vector<std::string>& terms, int type);
	void dump(std::ostream& ofile);
	std::map<std::string, std::set<Product*> > prod;
	std::vector<Product*> p_vec;
	std::map<User*, std::vector<Product*> > cart;
	std::vector<User*> u_vec;
	void addReview(const std::string& prodName, int rating, 
		const std::string& username, const std::string& date, 
		const std::string& review_text);
	std::vector<std::pair<std::string, double> > 
	 makeSuggestion(std::string currentUser);
};