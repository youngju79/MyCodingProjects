# you can add imports but you should not rely on libraries that are not already provided in "requirements.txt #
from heapq import heappush, heappop
from lab2_utils import TextbookStack

def a_star_search(stack):

    flip_sequence = []

    # --- v ADD YOUR CODE HERE v --- #

    # helper function that calculates heuristic
    def helper(g, s):
        h = 0
        for i in range(0, s.num_books - 1):
            order1 = s.order[i]
            order2 = s.order[i+1]
            orient1 = s.orientations[i]
            orient2 = s.orientations[i+1]
            # check first type
            if order1 != (order2 - 1) and order2 != (order1 - 1):
                h += 1
            # check second type
            elif orient1 != orient2:
                h += 1
            # check third type
            elif orient1 == orient2 == 1 and order1 > order2:
                h += 1
            # check fourth type
            elif orient1 == orient2 == 0 and order1 < order2:
                h += 1
        return g + h

    g = 0
    counter = 0
    heap = []
    flips = []
    heappush(heap, [helper(g, stack), counter, stack.copy(), g])
    heappush(flips, [helper(g, stack), counter, flip_sequence])
    while heap:
        currState = heappop(heap)
        currStack = currState[2]
        currFlipSeq = heappop(flips)[2]
        if currStack.check_ordered():
            break
        g = currState[3] + 1
        for i in range(1, stack.num_books + 1):
            counter += 1
            newStack = currStack.copy()
            newStack.flip_stack(i)
            newF = helper(g, newStack)
            heappush(heap, [newF, counter, newStack, g])
            newFlipSeq = currFlipSeq.copy()
            newFlipSeq.append(i)
            heappush(flips, [newF, counter, newFlipSeq])
    return currFlipSeq

    # ---------------------------- #


def weighted_a_star_search(stack, epsilon=None, N=1):
    # Weighted A* is extra credit

    flip_sequence = []

    # --- v ADD YOUR CODE HERE v --- #

    return flip_sequence

    # ---------------------------- #
