import numpy as np
from lab3_utils import edit_distance, feature_names, load_data


def convert_level(inputs, i, array):
    result = np.unique(inputs[:, i], return_counts=True)
    if i == 0:
        for string in result[0]:
            numStr = string.split("-")[0]
            num = int(numStr) // 10
            inputs[inputs[:, i] == string, i] = num
        array[:, 0] = inputs[:, i]
    elif i == 2:
        for string in result[0]:
            numStr = string.split("-")[0]
            num = int(numStr) // 5
            inputs[inputs[:, i] == string, i] = num
        array[:, 4] = inputs[:, i]
    elif i == 3:
        for string in result[0]:
            numStr = string.split("-")[0]
            num = int(numStr) // 3
            inputs[inputs[:, i] == string, i] = num
        array[:, 5] = inputs[:, i]
    elif i == 5:
        array[:, 7] = inputs[:, i]


def convert_nonlevel(inputs, i, array):
    if i == 1:
        for idx, string in enumerate(inputs[:, i]):
            if string == "lt40":
                array[idx][1] = 1
            elif string == "ge40":
                array[idx][2] = 1
            elif string == "premeno":
                array[idx][3] = 1
    elif i == 4:
        for idx, string in enumerate(inputs[:, i]):
            if string == "yes":
                array[idx][6] = 1
            elif string == "no":
                array[idx][6] = 0
    elif i == 6:
        for idx, string in enumerate(inputs[:, i]):
            if string == "right":
                array[idx][8] = 1
            elif string == "left":
                array[idx][8] = 0
    elif i == 7:
        for idx, string in enumerate(inputs[:, i]):
            if string == "left-up":
                array[idx][9] = 1
            elif string == "left-low":
                array[idx][10] = 1
            elif string == "right-up":
                array[idx][11] = 1
            elif string == "right-low":
                array[idx][12] = 1
            elif string == "central":
                array[idx][13] = 1
    elif i == 8:
        for idx, string in enumerate(inputs[:, i]):
            if string == "yes":
                array[idx][14] = 1
            elif string == "no":
                array[idx][14] = 0


# Hint: Consider how to utilize np.unique()
def preprocess_data(training_inputs, testing_inputs, training_labels, testing_labels):
    processed_training_inputs, processed_testing_inputs = ([], [])
    processed_training_labels, processed_testing_labels = ([], [])
    # VVVVV YOUR CODE GOES ERE VVVVV $
    # replace ? with mode of each feature
    for i in range(len(feature_names)):
        # replace ? for training inputs
        res1 = np.unique(training_inputs[:, i], return_counts=True)
        if "?" in res1[0]:
            idx = np.argmax(res1[1])
            training_inputs[training_inputs[:, i] == "?", i] = res1[0][idx]
        # replace ? for testing inputs
        res2 = np.unique(testing_inputs[:, i], return_counts=True)
        if "?" in res2[0]:
            idx = np.argmax(res2[1])
            testing_inputs[testing_inputs[:, i] == "?", i] = res2[0][idx]
    # convert categorical features to numeric features
    training_arr = np.zeros((len(training_inputs), 15)).astype("int")
    convert_level(training_inputs, 0, training_arr)
    convert_nonlevel(training_inputs, 1, training_arr)
    convert_level(training_inputs, 2, training_arr)
    convert_level(training_inputs, 3, training_arr)
    convert_nonlevel(training_inputs, 4, training_arr)
    convert_level(training_inputs, 5, training_arr)
    convert_nonlevel(training_inputs, 6, training_arr)
    convert_nonlevel(training_inputs, 7, training_arr)
    convert_nonlevel(training_inputs, 8, training_arr)
    testing_arr = np.zeros((len(testing_inputs), 15)).astype("int")
    convert_level(testing_inputs, 0, testing_arr)
    convert_nonlevel(testing_inputs, 1, testing_arr)
    convert_level(testing_inputs, 2, testing_arr)
    convert_level(testing_inputs, 3, testing_arr)
    convert_nonlevel(testing_inputs, 4, testing_arr)
    convert_level(testing_inputs, 5, testing_arr)
    convert_nonlevel(testing_inputs, 6, testing_arr)
    convert_nonlevel(testing_inputs, 7, testing_arr)
    convert_nonlevel(testing_inputs, 8, testing_arr)

    processed_training_inputs = training_arr.tolist()
    processed_testing_inputs = testing_arr.tolist()
    processed_training_labels = training_labels.tolist()
    processed_testing_labels = testing_labels.tolist()
    # ^^^^^ YOUR CODE GOES ERE ^^^^^ $
    return processed_training_inputs, processed_testing_inputs, processed_training_labels, processed_testing_labels


# Hint: consider how to utilize np.argsort()
def k_nearest_neighbors(predict_on, reference_points, reference_labels, k, l, weighted):
    assert len(predict_on) > 0, f"parameter predict_on needs to be of length 0 or greater"
    assert len(reference_points) > 0, f"parameter reference_points needs to be of length 0 or greater"
    assert len(reference_labels) > 0, f"parameter reference_labels needs to be of length 0 or greater"
    assert len(reference_labels) == len(reference_points), f"reference_points and reference_labels need to be the" \
                                                           f" same length"
    predictions = []
    # VVVVV YOUR CODE GOES ERE VVVVV $
    for test_pt in predict_on:
        dist = []
        for train_pt in reference_points:
            dist.append(edit_distance(train_pt, test_pt, l))
        sortedIdx = np.argsort(dist)
        recurr = 0
        for i in range(k):
            label = reference_labels[sortedIdx[i]]
            if label == "recurrence-events":
                recurr += 1
        if k % 2 == 0 and recurr >= (k // 2):
            predictions.append("recurrence-events")
        elif k % 2 == 1 and recurr > (k // 2):
            predictions.append("recurrence-events")
        else:
            predictions.append("no-recurrence-events")
    # ^^^^^ YOUR CODE GOES ERE ^^^^^ $
    return predictions
