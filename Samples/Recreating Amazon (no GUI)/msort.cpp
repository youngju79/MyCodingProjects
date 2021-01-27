#include <iostream>
#include <vector>
#include "msort.h"

using namespace std;

struct comp {
    bool operator()(const int lhs, const int rhs) 
    { 
      return lhs < rhs; 
    }
};

int main(){

	vector<int> vec_1 = {7, 3, 8, 6, 5, 10, 4, 2};
	comp comp1;
	mergeSort(vec_1, comp1);
	for(int i=0; i<(signed int)vec_1.size(); i++){
		cout << vec_1[i] << " ";
	}
	cout << endl;

	vector<int> vec_2 = {9, 1 ,7};
	mergeSort(vec_2, comp1);
	for(int i=0; i<(signed int)vec_2.size(); i++){
		cout << vec_2[i] << " ";
	}
	cout << endl;


	return 0;
}