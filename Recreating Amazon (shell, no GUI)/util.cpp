#include <iostream>
#include <sstream>
#include <cctype>
#include <algorithm>
#include <sstream>
#include "util.h"

using namespace std;
std::string convToLower(std::string src)
{
    std::transform(src.begin(), src.end(), src.begin(), ::tolower);
    return src;
}

/** Complete the code to convert a string containing a rawWord
    to a set of words based on the criteria given in the assignment **/
std::set<std::string> parseStringToWords(string rawWords)
{
    set<string> s;
    stringstream ss(rawWords);
    string word;
    while(ss >> word){  //turn words into strings
        word = convToLower(word);
        stringstream temp(word);
        char alph;  
        string final = "";
        while(temp >> alph){  //check words for punc
            if(ispunct(alph)) {
                if(final.size()<2){
                    final = "";
                }
                else{
                    s.insert(final);
                    final = "";
                }
            }
            else{
                final += alph;
            }

        }
        if (final.size()>2){  //check for end word with no punc
            s.insert(final);
            final = "";
        }
    }
    return s;
}

/**************************************************
 * COMPLETED - You may use the following functions
 **************************************************/

// Used from http://stackoverflow.com/questions/216823/whats-the-best-way-to-trim-stdstring
// trim from start
std::string &ltrim(std::string &s) {
    s.erase(s.begin(), 
	    std::find_if(s.begin(), 
			 s.end(), 
			 std::not1(std::ptr_fun<int, int>(std::isspace))));
    return s;
}

// trim from end
std::string &rtrim(std::string &s) {
    s.erase(
	    std::find_if(s.rbegin(), 
			 s.rend(), 
			 std::not1(std::ptr_fun<int, int>(std::isspace))).base(), 
	    s.end());
    return s;
}

// trim from both ends
std::string &trim(std::string &s) {
    return ltrim(rtrim(s));
}
