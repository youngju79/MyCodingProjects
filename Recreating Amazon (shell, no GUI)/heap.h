#ifndef HEAP_H
#define HEAP_H

#include <vector>
#include <functional>
#include <utility>
#include <algorithm>
#include <stdexcept>
#include <unordered_map>
template <
         typename T,
         typename TComparator = std::equal_to<T>,
         typename PComparator = std::less<double>,
         typename Hasher = std::hash<T> >
class Heap
{
public:
    /// Constructs an m-ary heap. M should be >= 2
    Heap(int m = 2,
         const PComparator& c = PComparator(),
         const Hasher& hash = Hasher(),
         const TComparator& tcomp = TComparator()  );

    /// Destructor as needed
    ~Heap();

    /// Adds an item with the provided priority
    void push(double pri, const T& item);

    /// returns the element at the top of the heap
    ///  max (if max-heap) or min (if min-heap)
    T const & top() const;

    /// Removes the top element
    void pop();

    /// returns true if the heap is empty
    bool empty() const;

    /// decreaseKey reduces the current priority of
    /// item to newpri, moving it up in the heap
    /// as appropriate.
    void decreaseKey(double newpri, const T& item);

private:
    /// Add whatever helper functions you need below
    void trickleUp(int loc);
    void heapify(int loc);
    void swap(int i_1, int i_2);


    // These should be all the data members you need.
    std::vector< std::pair<double, T> > store_;
    int m_;
    PComparator c_;
    std::unordered_map<T, size_t, Hasher, TComparator> keyToLocation_;
};

// Complete
template <typename T, typename TComparator, typename PComparator, typename Hasher >
Heap<T,TComparator,PComparator,Hasher>::Heap(
    int m,
    const PComparator& c,
    const Hasher& hash,
    const TComparator& tcomp ) :

    store_(),
    m_(m),
    c_(c),
    keyToLocation_(100, hash, tcomp)

{

}

// Complete
template <typename T, typename TComparator, typename PComparator, typename Hasher >
Heap<T,TComparator,PComparator,Hasher>::~Heap()
{

}

template <typename T, typename TComparator, typename PComparator, typename Hasher >
void Heap<T,TComparator,PComparator,Hasher>::push(double priority, const T& item)
{
    // You complete.
    typename std::unordered_map<T, size_t>::iterator it = keyToLocation_.find(item);
    if(it==keyToLocation_.end()){  //not in heap 
      keyToLocation_.insert(std::make_pair(item, store_.size()));
      store_.push_back(std::make_pair(priority,item));
      trickleUp(store_.size()-1);
    }
}

template <typename T, typename TComparator, typename PComparator, typename Hasher >
void Heap<T,TComparator,PComparator,Hasher>::decreaseKey(double priority, const T& item)
{
    // You complete
    typename std::unordered_map<T, size_t>::iterator it = keyToLocation_.find(item);
    if(it!=keyToLocation_.end()){ //found key
      int loc = keyToLocation_[item];
      if(c_(priority, store_[loc].first)){
        store_[loc] = std::make_pair(priority, item);  //change to even "better" priority
        trickleUp(loc);
      }
    }
}

template <typename T, typename TComparator, typename PComparator, typename Hasher >
T const & Heap<T,TComparator,PComparator,Hasher>::top() const
{
    // Here we use exceptions to handle the case of trying
    // to access the top element of an empty heap
    if(empty()) {
        throw std::logic_error("can't top an empty heap");
    }

    // You complete
    return store_.front().second;
}

/// Removes the top element
template <typename T, typename TComparator, typename PComparator, typename Hasher >
void Heap<T,TComparator,PComparator,Hasher>::pop()
{
    if(empty()) {
        throw std::logic_error("can't pop an empty heap");
    }
    // You complete
    keyToLocation_.erase(store_.front().second);  //delete top 
    store_[0] = store_.back();
    keyToLocation_[store_.back().second] = 0;  //change location of back to front
    store_.pop_back();
    heapify(0);
}

/// returns true if the heap is empty
template <typename T, typename TComparator, typename PComparator, typename Hasher >
bool Heap<T,TComparator,PComparator,Hasher>::empty() const
{
    return store_.empty();
}

template <typename T, typename TComparator, typename PComparator, typename Hasher >
void Heap<T,TComparator,PComparator,Hasher>::trickleUp(int loc)
{
  int parent;
  if(loc%m_ == 0){  //special case
    parent = (loc/m_)-1;
  }
  else{ 
    parent = loc/m_;
  }

  while(parent>=0 && c_(store_[loc].first,store_[parent].first)){
    swap(parent, loc);
    loc = parent;
    if(loc%m_ == 0){  //special case
      parent = loc/m_-1;
    }
    else{ 
      parent = loc/m_;
    }
  }
}

template <typename T, typename TComparator, typename PComparator, typename Hasher >
void Heap<T,TComparator,PComparator,Hasher>::heapify(int loc)
{
  if((loc*m_)+1 > (signed int)store_.size()-1){  //leaf node
    return;
  }
  int s_c = (m_*loc)+1;  //leftmost child
  for(int i=1; i<m_; i++){  //compare to other children
    if(s_c+i < (signed int)store_.size()) {   //right child exists
      int r_c = s_c+i;
      if(c_(store_[r_c].first, store_[s_c].first)){
        s_c = r_c;
      }
    }
  }
  if(c_(store_[s_c].first, store_[loc].first)){
    swap(loc, s_c);
    heapify(s_c);
  }
}

template <typename T, typename TComparator, typename PComparator, typename Hasher >
void Heap<T,TComparator,PComparator,Hasher>::swap(int i_1, int i_2)
{
  int loc_1 = keyToLocation_[store_[i_1].second];  //location of first item
  int loc_2 = keyToLocation_[store_[i_2].second];  //location of second item
  keyToLocation_[store_[i_1].second] = loc_2;   //switch locations of items
  keyToLocation_[store_[i_2].second] = loc_1;
  std::pair<int, T> temp = store_[i_1];
  store_[i_1] = store_[i_2];
  store_[i_2] = temp;
}

#endif

