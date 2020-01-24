
#include <iostream>
#include <vector>

template <class T, class Comparator>
void mergeSort(std::vector<T>& myArray, Comparator comp) 
{
	if(myArray.size()<2){  //return if size = 0 or size = 1
		return;
	}
	int f = myArray.size()-1;
	mergeSorthelper(myArray, comp, 0, f);
}

template <class T, class Comparator>
void mergeSorthelper(std::vector<T>& myArray, Comparator comp, int l, int r) 
{
	if(l<r){
		int m = (l+r)/2;
		mergeSorthelper(myArray, comp, l, m);
		mergeSorthelper(myArray,comp, m+1, r);
		merge(myArray, l, r, m, comp);
	}
}

template<class T, class Comparator>
void merge(std::vector<T>& myArray, int l, int r, int m, Comparator comp)
{
	std::vector<T> result;
	int left = l;
	int right = m+1;
	while((left<=m) && (right<=r)){
		if(comp(myArray[left], myArray[right])){
			result.push_back(myArray[left++]);
		}
		else{
			result.push_back(myArray[right++]);
		}
	}
	if(left<=m){  //need to complete right side
		for(int i=left; i<=m; i++){
			result.push_back(myArray[left++]);
		}
	}
	if(right<=r){  //need to complete left side
		for(int i=right; i<=r; i++){
			result.push_back(myArray[right++]);
		}
	}
	for(int i=0; i<(signed int)result.size(); i++){
		myArray[i+l] = result[i];
	}
	
}
