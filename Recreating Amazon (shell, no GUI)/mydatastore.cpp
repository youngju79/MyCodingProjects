#include <iostream>
#include <vector>
#include <map>
#include <cstdlib>
#include <cmath>
#include <set>
#include "mydatastore.h"
#include "util.h"
#include "heap.h"

using namespace std;

MyDataStore::~MyDataStore(){
	for(int i=0; i<(signed int)p_vec.size(); i++){
		delete p_vec[i];
	}
	for(int i=0; i<(signed int)u_vec.size(); i++){
		delete u_vec[i];
	}
}

void MyDataStore::addProduct(Product* p) 
{
	p_vec.push_back(p);
	set<string> temp = p->keywords();
	set<string>::iterator it;
	for(it=temp.begin(); it!=temp.end(); ++it){
		if(prod.find(*it)!=prod.end()){  //already in map
			set<Product*> set_p = prod[*it];
			set_p.insert(p);
			prod[*it] = set_p;
			set_p.clear();
		}  
		else{  //not in map
			set<Product*> set_p;
			set_p.insert(p);
			string temp_ = (*it);
			temp_ = convToLower(temp_);
			prod.insert(pair<string, set<Product*> >(temp_, set_p));
			set_p.clear();
		}
	}
}

void MyDataStore::addUser(User* u)
{
	u_vec.push_back(u);
}

std::vector<Product*> MyDataStore::search(std::vector<std::string>& terms, int type)
{
	vector<Product*> final;  
	set<Product*> hit;
	set<Product*> result;
	vector< set<Product*> > set_vec;
	bool check_a = true;
	
	for(int i=0; i<(signed int)terms.size(); i++){
		if(prod.find(terms[i])!=prod.end()){  //found key
			hit = prod[terms[i]];
			set_vec.push_back(hit);
			hit.clear();
		}
		else{
			check_a = false;
		}
	}
	if((set_vec.size()==1) && (check_a)){  // 1 term was given
		set<Product*>::iterator it;
		for(it=set_vec[0].begin(); it!=set_vec[0].end(); ++it){
			final.push_back(*it);
		}
		return final;
	}
	if(type==0){  //AND search
		if(check_a){
			for(int i=0; i<(signed int)(set_vec.size()-1); i++){
				result = setIntersection(set_vec[i], set_vec[i+1]);
				set_vec[i+1] = result;
			}
			set<Product*>::iterator it;
			for(it=result.begin(); it!=result.end(); ++it){
				final.push_back(*it);
			}
		}
		return final;
	}
	else if(type==1){  //OR search
		if(set_vec.size()==1){  //only one term
			result = set_vec[0];
		}
		for(int i=0; i<(signed int)(set_vec.size()-1); i++){
			result = setUnion(set_vec[i], set_vec[i+1]);
			set_vec[i+1] = result;
		}
		set<Product*>::iterator it;
		for(it=result.begin(); it!=result.end(); ++it){
			final.push_back(*it);
		}
		return final;
	}
	else{  //incorect type
		return final;
	}
}

void MyDataStore::dump(std::ostream& ofile) 
{
	ofile << "<products>" << endl;
	for(int i=0; i<(signed int)p_vec.size(); i++){
		p_vec[i]->dump(ofile);
	}
	ofile << "</products>" << endl;
	ofile << "<users>" << endl;
	for(int i=0; i<(signed int)u_vec.size(); i++){
		u_vec[i]->dump(ofile);
	}
	ofile << "</users>" << endl;
	ofile << "<reviews>" << endl;
	for(int i=0; i<(signed int)p_vec.size(); i++){
		vector<Review*> temp = p_vec[i]->getRev();
		for(int j=0; j<(signed int)temp.size(); j++){
			ofile << p_vec[i]->getName() << endl;
			temp[j]->dump(ofile);
		}
	}
	ofile << "</reviews>"; 
}

void MyDataStore::addReview(const std::string& prodName, int rating, const std::string& username,
	const std::string& date, const std::string& review_text)
{
	bool check_p = false;
	bool check_u = false;
	int prod_num = 0;
	int user_num = 0;
	for(int i=0; i<(signed int)p_vec.size(); i++){  //check for valid prod name
		if(p_vec[i]->getName() == prodName){
			check_p = true;
			prod_num = i;
		}
	}
	for(int i=0; i<(signed int)u_vec.size(); i++){  //check for valid user name
		if(u_vec[i]->getName() == username){
			check_u = true;
			user_num = i;
		}
	}
	if(!(check_p && check_u)){
		return;
	}
	Review* a = new Review(rating, username, date, review_text);
	p_vec[prod_num]->addRev(a);
	u_vec[user_num]->addProd_rev(p_vec[prod_num]);
}

std::vector<std::pair<std::string, double> > 
 MyDataStore::makeSuggestion(std::string currentUser)
{
	vector<pair<string, double> > final_vec;
	int u_n = 0;
	for(int i=0; i<(signed int)u_vec.size(); i++){  //find user num
        if(u_vec[i]->getName()==currentUser){            
            u_n = i;
        }
    }
    Heap<string> heap_;
    map<string, double> dist_map;
    //add all users into map & heap (basic similarities)
    for(int i=0; i<(signed int)u_vec.size(); i++){ 
        if(i==u_n){     
        	//set curr user similarity to 0 and add to heap   
            dist_map.insert(std::make_pair(u_vec[i]->getName(), 0));
            heap_.push(0, u_vec[i]->getName());
        }
        else{
        	//set basic similarities for other users and add to heap
    		set<Product*> curr_rev = u_vec[u_n]->getProd_rev();  //curr user rev
    		set<Product*> user_rev = u_vec[i]->getProd_rev();  //other user rev
    		//find same reviewed products
    		set<Product*> final = setIntersection(user_rev, curr_rev);
    		if(final.empty()){  //no common product reviews
    			dist_map.insert(std::make_pair(u_vec[i]->getName(), 1));
    			heap_.push(1, u_vec[i]->getName());
    		}
    		else{  //has common product reviews
    			set<Product*>::iterator it;
    			double rev_total = 0;
    			for(it=final.begin(); it!=final.end(); ++it){
    				double rev_prod = 0;
    				double rev_1 = (*it)->getUser_rev(u_vec[u_n]->getName());
    				double rev_2 = (*it)->getUser_rev(u_vec[i]->getName());
    				rev_prod = abs(rev_1 - rev_2);
    				rev_prod = (rev_prod/4);
    				//add to total reviews
    				rev_total+=rev_prod;
    			}
    			//calculate user similarity
    			rev_total = rev_total/final.size();
    			dist_map.insert(std::make_pair(u_vec[i]->getName(), rev_total));
    			heap_.push(rev_total, u_vec[i]->getName());
    		}
    	}
    }

    //dijkstra's algorithm (refined similarities)
    while(!heap_.empty()){
    	string curr_user = heap_.top();
    	heap_.pop();
    	int c_n;
    	for(int i=0; i<(signed int)u_vec.size(); i++){  //find curr user
        	if(u_vec[i]->getName()==curr_user){            
            	c_n = i;
        	}
    	}
    	//search through neighbors
    	for(int i=0; i<(signed int)u_vec.size(); i++){
    		//skip if curr user
    		if(i==c_n){
    			continue;
    		}
    		//find similarity btwn curr user and neighbor
    		set<Product*> curr_rev = u_vec[c_n]->getProd_rev();  //curr user rev
    		set<Product*> user_rev = u_vec[i]->getProd_rev();  //neighbor rev
    		//find same reviewed products
    		set<Product*> final = setIntersection(user_rev, curr_rev);
    		set<Product*>::iterator it;
    		double dist = 0;
    		for(it=final.begin(); it!=final.end(); ++it){
    			double rev_prod = 0;
    			double rev_1 = (*it)->getUser_rev(u_vec[c_n]->getName());
    			double rev_2 = (*it)->getUser_rev(u_vec[i]->getName());
    			rev_prod = abs(rev_1 - rev_2);
    			rev_prod = (rev_prod/4);
    			//add to total reviews
    			dist+=rev_prod;
    		}
    		dist = dist/final.size();
    		double new_dist = dist_map[curr_user] + dist;
    		//shorter path
    		if(new_dist < dist_map[u_vec[i]->getName()]){
    			heap_.decreaseKey(new_dist, u_vec[i]->getName());
    			dist_map[u_vec[i]->getName()] = new_dist;
    		}
    	}
    }

    //product ratings
    set<Product*> curr_rev = u_vec[u_n]->getProd_rev();  //curr user rev
    //all products in system

    for(int i=0; i<(signed int)p_vec.size(); i++){
    	set<Product*>::iterator it = curr_rev.find(p_vec[i]);
    	//not reviewed by the curr user and has previous reviews
    	if(it==curr_rev.end() && p_vec[i]->getRev().size()!=0){
    		vector<Review*> prod = p_vec[i]->getRev();
    		set<string> users; 
    		//find all users that reviewed the prod
    		for(int j=0; j<(signed int)prod.size(); j++){
    			users.insert(prod[j]->username);
    		}
    		double r_p = 0;
    		double w = 0;
    		set<string>::iterator it;
    		double temp;
    		for(it=users.begin(); it!=users.end(); ++it){
    			//calculate R(P) = sum of all (1-s(B,A))*r(B,P)
    			temp = p_vec[i]->getUser_rev(*it)*(1-dist_map[*it]);
    			r_p+=temp;
    			//calculate W = sum of all (1-s(B,A))
    			temp = (1-dist_map[*it]);
    			w+=temp;
    		}

    		//calculate total rating = R(P)/W
    		double total_r;
    		if(w==0){
    			total_r = 0;
    		}
    		else{
    			total_r = r_p/w;
    		}
    		final_vec.push_back(std::make_pair(p_vec[i]->getName(), total_r));
    		users.clear();
    	}
    }
    return final_vec;
}
