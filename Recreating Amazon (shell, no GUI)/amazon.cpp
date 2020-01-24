#include <iostream>
#include <fstream>
#include <set>
#include <sstream>
#include <vector>
#include <iomanip>
#include <algorithm>
#include "product.h"
#include "db_parser.h"
#include "product_parser.h"
#include "util.h"
#include <map>
#include <queue>
#include <cctype>
#include "mydatastore.h"
#include "msort.h"

using namespace std;
struct ProdNameSorter {
    bool operator()(Product* p1, Product* p2) {
        return (p1->getName() < p2->getName());
    }
};
struct ReviewSorter {
    bool operator()(Product* p1, Product* p2) {
        return (p1->getAvg_rev() > p2->getAvg_rev());
    }
};
struct DateSorter {
    bool operator()(Review* p1, Review* p2) {
        return (p1->date > p2->date);
    }
};
struct RevSorter {
    bool operator()(pair<string, double> p1, pair<string, double> p2) {
        if(p1.second==p2.second){
            return p1.first < p2.first;
        }
        return p1.second > p2.second;
    }
};

void displayProducts(vector<Product*>& hits);

unsigned long long hash_helper(string pw, int num)
{
    if(num<=0){
        return (int)pw[num];
    }   
    return (int)pw[num] + 128*hash_helper(pw, num-1);
}

void hash_helper1(unsigned int (&array)[4], unsigned long long num, int iter)
{
    if(iter>3 || num<0){
        return;
    }
    array[iter] = num % 65521;
    hash_helper1(array, num/65521, ++iter);
}

unsigned long long Hash(string pw)
{
    unsigned long long final;
    unsigned int arr[4] = {0};
    final = hash_helper(pw, pw.size()-1);
    hash_helper1(arr, final, 0);
    return (45912*arr[3] + 35511*arr[2] + 65169*arr[1] + 4625*arr[0]) % 65521;
}

int main(int argc, char* argv[])
{
    if(argc < 2) {
        cerr << "Please specify a database file" << endl;
        return 1;
    }

    /****************
     * Declare your derived DataStore object here replacing
     *  DataStore type to your derived type
     ****************/
    MyDataStore ds;



    // Instantiate the individual section and product parsers we want
    ProductSectionParser* productSectionParser = new ProductSectionParser;
    productSectionParser->addProductParser(new ProductBookParser);
    productSectionParser->addProductParser(new ProductClothingParser);
    productSectionParser->addProductParser(new ProductMovieParser);
    UserSectionParser* userSectionParser = new UserSectionParser;
    ReviewSectionParser* reviewSectionParser = new ReviewSectionParser;

    // Instantiate the parser
    DBParser parser;
    parser.addSectionParser("products", productSectionParser);
    parser.addSectionParser("users", userSectionParser);
    parser.addSectionParser("reviews", reviewSectionParser);

    // Now parse the database to populate the DataStore
    if( parser.parse(argv[1], ds) ) {
        cerr << "Error parsing!" << endl;
        return 1;
    }

    cout << "============================================" << endl;
    cout << "Menu: " << endl;
    cout << "  LOGIN username password                   " << endl;
    cout << "  LOGOUT                                    " << endl;
    cout << "  AND r/n term term ...                     " << endl;
    cout << "  OR r/n term term ...                      " << endl;
    cout << "  ADD search_hit_number                     " << endl;
    cout << "  VIEWCART                                  " << endl;
    cout << "  BUYCART                                   " << endl;
    cout << "  ADDREV search_hit_number rating YYYY-MM-DD review_text" << endl;
    cout << "  VIEWREV search_hit_number                 " << endl;
    cout << "  REC                                       " << endl;
    cout << "  QUIT new_db_filename                      " << endl;
    cout << "============================================" << endl;

    vector<Product*> hits;
    bool done = false;
    bool logged = false;
    int u_n = 0;
    while(!done) {
        cout << "\nEnter command: " << endl;
        string line;
        getline(cin,line);
        stringstream ss(line);
        string cmd;
        if((ss >> cmd)) {
            if( cmd == "LOGIN"){
                string name;
                ss >> name;
                string password;
                ss >> password;
                if(logged){  //check if already logged in
                    logged = false;
                }
                for(int i=0; i<(signed int)ds.u_vec.size(); i++){  //check for
                    if(ds.u_vec[i]->getName()==name){            //valid user
                        logged = true;
                        u_n = i;
                    }
                }
                if(logged){  //valid user --> need to check pass
                    if(Hash(password)!=ds.u_vec[u_n]->getPassword()){
                        logged = false;
                    }
                }
                if(logged == false){
                    cout << "Invalid login credentials" << endl;
                }
                else{
                    cout << "User logged in" << endl;
                }
            }
            else if( cmd == "LOGOUT"){
                logged = false;
            }
            else if( cmd == "AND") {
                string r_n;
                ss >> r_n;
                if(r_n == "r"){  //sort by review
                    ReviewSorter comp1;
                    string term;
                    vector<string> terms;
                    while(ss >> term) {
                        term = convToLower(term);
                        terms.push_back(term);
                    }
                    hits = ds.search(terms, 0);
                    mergeSort(hits, comp1);
                    displayProducts(hits);
                }
                if(r_n == "n"){  //sort by name
                    ProdNameSorter comp2;
                    string term;
                    vector<string> terms;
                    while(ss >> term) {
                        term = convToLower(term);
                        terms.push_back(term);
                    }
                    hits = ds.search(terms, 0);
                    mergeSort(hits, comp2);
                    displayProducts(hits);
                }
            }
            else if ( cmd == "OR" ) {
                string r_n;
                ss >> r_n;
                if(r_n == "r"){  //sort by review
                    ReviewSorter comp1;
                    string term;
                    vector<string> terms;
                    while(ss >> term) {
                        term = convToLower(term);
                        terms.push_back(term);
                    }
                    hits = ds.search(terms, 1);
                    mergeSort(hits, comp1);
                    displayProducts(hits);
                }
                if(r_n == "n"){  //sort by name
                    ProdNameSorter comp2;
                    string term;
                    vector<string> terms;
                    while(ss >> term) {
                        term = convToLower(term);
                        terms.push_back(term);
                    }
                    hits = ds.search(terms, 1);
                    mergeSort(hits, comp2);
                    displayProducts(hits);
                }
            }
            else if( cmd == "REC"){
                if(logged == false){  //no user
                    cout << "No current user" << endl;
                    continue;
                }
                bool all_rev = true;
                set<Product*> user_rev = ds.u_vec[u_n]->getProd_rev();
                //check if all products reviewed
                for(int i=0; i<(signed int)ds.p_vec.size(); i++){
                    set<Product*>::iterator it = user_rev.find(ds.p_vec[i]);
                    //prod is not in user reviews and has reviews
                    if(it==user_rev.end() && (ds.p_vec[i]->getRev().size()!=0)){
                        all_rev = false;
                    }
                }

                if(all_rev){  //all products reviewed
                    cout << "No recommendations available" << endl;
                    continue;
                }
                vector<std::pair<std::string, double> > suggest;
                suggest = ds.makeSuggestion(ds.u_vec[u_n]->getName());
                RevSorter rs;
                stable_sort(suggest.begin(), suggest.end(), rs);
                //print suggestions
                stringstream s;
                string rec = ds.u_vec[u_n]->getName();
                rec += '\n';
                for(int i=0; i<(signed int)suggest.size(); i++){
                    s << fixed << setprecision(2) << suggest[i].second;
                    rec+= s.str();
                    rec+= " ";
                    rec+= suggest[i].first;
                    if(i!=(signed int)suggest.size()-1){
                        rec+= '\n';
                    }
                    s.str("");
                    s.clear();
                }
                cout << rec << endl;
                ofstream ofile("rec.txt");
                ofile << rec;
                ofile.close();
            }
            else if ( cmd == "QUIT") {
                string filename;
                if(ss >> filename) {
                    ofstream ofile(filename.c_str());
                    ds.dump(ofile);
                    ofile.close();
                }
                done = true;
            }
	    /* Add support for other commands here */
            else if ( cmd == "ADD") {
                if(logged == false){  //check for user
                    cout << "No current user" << endl;
                    continue;
                }
                bool is_true = true;
                int hit_num;
                ss >> hit_num;
                if((hit_num<1) || (hit_num>(signed int)hits.size())){  //check for
                    is_true = false;                                   //valid hit
                }
                if(is_true){ 
                    if(ds.cart.find(ds.u_vec[u_n])!=ds.cart.end()){ //cart has prod alr
                        vector<Product*> p_v = ds.cart[ds.u_vec[u_n]];
                        p_v.push_back(hits[hit_num-1]);
                        ds.cart[ds.u_vec[u_n]] = p_v;
                        p_v.clear();
                    }
                    else{  //user has nothing in cart
                        vector<Product*> p_v;
                        p_v.push_back(hits[hit_num-1]);
                        ds.cart.insert(pair<User*, vector<Product*> >
                            (ds.u_vec[u_n], p_v));
                        p_v.clear();
                    }
                }
                else{  //hit is not valid
                    cout << "Invalid request" << endl;
                }
            }
            else if ( cmd == "VIEWCART") {
                if(logged){  //check for user
                    for(int i=0; i<(signed int)ds.cart[ds.u_vec[u_n]].size(); i++){
                        cout << "Item " << i+1 << endl;
                        cout << ds.cart[ds.u_vec[u_n]][i]->displayString() << endl;
                        cout << endl;
                    }
                }
                else{
                    cout << "No current user" << endl;
                }
            }
            else if ( cmd == "BUYCART") {
                if(logged){  //check for user
                    int size_temp = ds.cart[ds.u_vec[u_n]].size();
                    int count = 0;
                    for(int i=0; i<size_temp; i++){
                        if(ds.cart[ds.u_vec[u_n]][i]->getQty()!=0){  //in stock 
                                                            //and enough money
                            if(ds.cart[ds.u_vec[u_n]][i]->getPrice()<=
                                ds.u_vec[u_n]->getBalance())
                            {   //deduct money from user
                                ds.u_vec[u_n]->deductAmount(
                                    ds.cart[ds.u_vec[u_n]][i]->getPrice());
                                //reduce quantity by 1
                                ds.cart[ds.u_vec[u_n]][i]->subtractQty(1);
                                //delete product from cart
                                ds.cart[ds.u_vec[u_n]].erase(
                                    ds.cart[ds.u_vec[u_n]].begin()+count);
                            }
                            else{
                                count++;  
                            }
                        }
                        else{
                            count++;
                        }
                    }
                }
                else{
                    cout << "No current user" << endl;
                }
            }
            else if ( cmd == "ADDREV"){
                if(logged){  //check for user
                    bool is_true = true;
                    int hit_num;
                    ss >> hit_num;
                    if(ss.fail()){  //check input flag
                         cout << "Invalid input" << endl;
                         continue;   
                    }
                    if((hit_num<1) || (hit_num>(signed int)hits.size())){//check for
                        is_true = false;                                   //valid hit
                    }
                    if(is_true){
                        int r_n;
                        ss >> r_n;
                        if(ss.fail()){  //check input flag
                            cout << "Invalid input" << endl;
                            continue;   
                        }
                        if((r_n < 1) || (r_n > 5)){  //check rating 
                            cout << "Rating is invalid" << endl;
                            continue;
                        }
                        string d;  
                        ss >> d;
                        if(ss.fail()){  //check input flag
                            cout << "Invalid input" << endl;
                            continue;   
                        } 
                        stringstream date(d);
                        bool r = true;
                        if(d.size()!=10){ //check for format
                            r = false;
                        }
                        if((d[4]!= '-') || (d[7]!='-')){
                            r = false;
                        }
                        int year;
                        date >> year;
                        for(int i=0; i<4; i++){  //check year
                            if(!isdigit(d[i])){
                                r = false;
                            }
                        }
                        int month;
                        date >> month;
                        month = month*-1;  //negative bc '-'
                        for(int i=5; i<7; i++){  //check month
                            if(!isdigit(d[i])){
                                r = false;
                            }
                        }
                        if((month < 1) || (month > 12)){
                            r = false;
                        }
                        int day;
                        date >> day;
                        day = day*-1;   //negative bc '-'
                        for(int i=8; i<10; i++){  //check day
                            if(!isdigit(d[i])){
                                r = false;
                            }
                        }
                        if(day < 1){  //check for invalid day
                            r = false;
                        }
                        //check for 31 days in month
                        if((month==1) || (month==3) || (month==5) || (month==7) ||
                        (month==8) || (month==10) || (month==12)){
                            if(day>31){
                                r = false;
                            }
                        } 
                        //check for 30 days in month
                        if((month==4) || (month==6) || (month==9) || (month==11)){
                            if(day>30){
                                r = false;
                            }
                        } 
                        //check for 28 days in month
                        if(month==2){
                            if(day>28){
                                r = false;
                            }
                        } 
                        if(!r){
                            cout << "Date is invalid" << endl;
                            continue;
                        }
                        string text;
                        getline(ss, text); //adding review text
                        text = trim(text);
                        ds.addReview(hits[hit_num-1]->getName(), r_n, 
                            ds.u_vec[u_n]->getName(), d, text);
                    }
                    else{  //hit is not valid
                        cout << "Hit is invalid" << endl;
                    }
                }
                else{  //check user
                    cout << "No current user" << endl;
                }
            }
            else if ( cmd == "VIEWREV"){
                int hit_num;
                ss >> hit_num;
                if((hit_num<1) || (hit_num>(signed int)hits.size())){//check for
                    cout << "Invalid request" << endl;              //valid hit
                }
                else{
                    vector<Review*> rev_t;
                    rev_t = hits[hit_num-1]->getRev();
                    DateSorter comp3;
                    mergeSort(rev_t, comp3); //sort reviews
                    for(int i=0; i<(signed int)rev_t.size(); i++){
                        cout << rev_t[i]->date << " ";
                        cout << rev_t[i]->rating << " ";
                        cout << rev_t[i]->username << " ";
                        cout << rev_t[i]->reviewText;
                        cout << endl;
                    }
                }
            }
            else {
                cout << "Unknown command" << endl;
            }
        }

    }
    return 0;
}

void displayProducts(vector<Product*>& hits)
{
    int resultNo = 1;
    //std::sort(hits.begin(), hits.end(), ProdNameSorter());
    for(vector<Product*>::iterator it = hits.begin(); it != hits.end(); ++it) {
        cout << "Hit " << setw(3) << resultNo << endl;
        cout << (*it)->displayString() << endl;
        cout << endl;
        resultNo++;
    }
}

