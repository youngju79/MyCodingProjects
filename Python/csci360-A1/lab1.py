# you can add imports but you should not rely on libraries that are not already provided in "requirements.txt #
from collections import deque

def breadth_first_search(stack):
    flip_sequence = []

    # --- v ADD YOUR CODE HERE v --- #
    queue = deque()
    flips = deque()
    visitedStates = [stack.copy()]
    queue.append(stack.copy())
    flips.append(flip_sequence)
    while queue:
        currStack = queue.popleft()
        currFlips = flips.popleft()
        if currStack.check_ordered():
            break
        for i in range(1, stack.num_books + 1):
            # update state and flip sequence
            stackCopy = currStack.copy()
            stackCopy.flip_stack(i)
            flipCopy = currFlips.copy()
            flipCopy.append(i)
            # check if already visited
            if stackCopy not in visitedStates:
                queue.append(stackCopy)
                flips.append(flipCopy)
                visitedStates.append(stackCopy)
    return currFlips
    # ---------------------------- #


def depth_first_search(stack):
    flip_sequence = []

    # --- v ADD YOUR CODE HERE v --- #
    stackQ = deque()
    flips = deque()
    visitedStates = [stack.copy()]
    stackQ.append(stack.copy())
    flips.append(flip_sequence)
    while stackQ:
        currStack = stackQ.pop()
        currFlips = flips.pop()
        if currStack.check_ordered():
            break
        for i in range(1, stack.num_books + 1):
            # update state and flip sequence
            stackCopy = currStack.copy()
            stackCopy.flip_stack(i)
            flipCopy = currFlips.copy()
            flipCopy.append(i)
            # check if already visited
            if stackCopy not in visitedStates:
                stackQ.append(stackCopy)
                flips.append(flipCopy)
                visitedStates.append(stackCopy)
    return currFlips
    # ---------------------------- #
