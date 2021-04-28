import numpy as np

from lab4_utils import feature_names, accuracy_score


# Hint: Consider how to utilize np.unique()
def preprocess_data(training_inputs, testing_inputs, training_labels, testing_labels):
    processed_training_inputs, processed_testing_inputs = ([], [])
    processed_training_labels, processed_testing_labels = ([], [])
    # VVVVV YOUR CODE GOES HERE VVVVV $
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
    processed_training_inputs = training_inputs.tolist()
    processed_testing_inputs = testing_inputs.tolist()
    processed_training_labels = training_labels.tolist()
    processed_testing_labels = testing_labels.tolist()
    # ^^^^^ YOUR CODE GOES HERE ^^^^^ $
    return (
        processed_training_inputs,
        processed_testing_inputs,
        processed_training_labels,
        processed_testing_labels,
    )


def naive_bayes(predict_on, reference_points, reference_labels):
    # Here you should calculate the requisite probabilities from the reference points
    # and then use them to classify each test point. Don't forget to use Laplace smoothing
    assert (
            len(predict_on) > 0
    ), f"parameter predict_on needs to be of length 0 or greater"
    assert (
            len(reference_points) > 0
    ), f"parameter reference_points needs to be of length 0 or greater"
    assert (
            len(reference_labels) > 0
    ), f"parameter reference_labels needs to be of length 0 or greater"
    assert len(reference_labels) == len(reference_points), (
        f"reference_points and reference_labels need to be the" f" same length"
    )
    predictions = []
    # VVVVV YOUR CODE GOES HERE VVVVV $
    recur_points = []
    norecur_points = []
    for idx, row in enumerate(reference_points):
        if reference_labels[idx] == "recurrence-events":
            recur_points.append(row)
        else:
            norecur_points.append(row)
    recur_points = np.array(recur_points)
    norecur_points = np.array(norecur_points)
    norecurCount = len(norecur_points)
    recurCount = len(recur_points)
    pRecur = recurCount / (recurCount + norecurCount)
    pNoRecur = norecurCount / (recurCount + norecurCount)

    rec1 = np.unique(recur_points[:, 0], return_counts=True)
    rec2 = np.unique(recur_points[:, 1], return_counts=True)
    rec3 = np.unique(recur_points[:, 2], return_counts=True)
    rec4 = np.unique(recur_points[:, 3], return_counts=True)
    rec5 = np.unique(recur_points[:, 4], return_counts=True)
    rec6 = np.unique(recur_points[:, 5], return_counts=True)
    rec7 = np.unique(recur_points[:, 6], return_counts=True)
    rec8 = np.unique(recur_points[:, 7], return_counts=True)
    rec9 = np.unique(recur_points[:, 8], return_counts=True)

    norec1 = np.unique(norecur_points[:, 0], return_counts=True)
    norec2 = np.unique(norecur_points[:, 1], return_counts=True)
    norec3 = np.unique(norecur_points[:, 2], return_counts=True)
    norec4 = np.unique(norecur_points[:, 3], return_counts=True)
    norec5 = np.unique(norecur_points[:, 4], return_counts=True)
    norec6 = np.unique(norecur_points[:, 5], return_counts=True)
    norec7 = np.unique(norecur_points[:, 6], return_counts=True)
    norec8 = np.unique(norecur_points[:, 7], return_counts=True)
    norec9 = np.unique(norecur_points[:, 8], return_counts=True)

    for row in predict_on:
        # calculate p(recurrence|X)
        if row[0] in rec1[0]:
            instances = rec1[1][np.where(rec1[0] == row[0])[0][0]]
        else:
            instances = 0
        pX1Recur = (instances + 1) / (recurCount + 9)
        if row[1] in rec2[0]:
            instances = rec2[1][np.where(rec2[0] == row[1])[0][0]]
        else:
            instances = 0
        pX2Recur = (instances + 1) / (recurCount + 3)
        if row[2] in rec3[0]:
            instances = rec3[1][np.where(rec3[0] == row[2])[0][0]]
        else:
            instances = 0
        pX3Recur = (instances + 1) / (recurCount + 12)
        if row[3] in rec4[0]:
            instances = rec4[1][np.where(rec4[0] == row[3])[0][0]]
        else:
            instances = 0
        pX4Recur = (instances + 1) / (recurCount + 13)
        if row[4] in rec5[0]:
            instances = rec5[1][np.where(rec5[0] == row[4])[0][0]]
        else:
            instances = 0
        pX5Recur = (instances + 1) / (recurCount + 2)
        if row[5] in rec6[0]:
            instances = rec6[1][np.where(rec6[0] == row[5])[0][0]]
        else:
            instances = 0
        pX6Recur = (instances + 1) / (recurCount + 3)
        if row[6] in rec7[0]:
            instances = rec7[1][np.where(rec7[0] == row[6])[0][0]]
        else:
            instances = 0
        pX7Recur = (instances + 1) / (recurCount + 2)
        if row[7] in rec8[0]:
            instances = rec8[1][np.where(rec8[0] == row[7])[0][0]]
        else:
            instances = 0
        pX8Recur = (instances + 1) / (recurCount + 5)
        if row[8] in rec9[0]:
            instances = rec9[1][np.where(rec9[0] == row[8])[0][0]]
        else:
            instances = 0
        pX9Recur = (instances + 1) / (recurCount + 2)
        pRecurAllX = pX1Recur * pX2Recur * pX3Recur * pX4Recur * pX5Recur * pX6Recur * pX7Recur * pX8Recur \
                     * pX9Recur * pRecur

        # calculate p(no recurrence|X)
        if row[0] in norec1[0]:
            instances = norec1[1][np.where(norec1[0] == row[0])[0][0]]
        else:
            instances = 0
        pX1NoRecur = (instances + 1) / (norecurCount + 9)
        if row[1] in norec2[0]:
            instances = norec2[1][np.where(norec2[0] == row[1])[0][0]]
        else:
            instances = 0
        pX2NoRecur = (instances + 1) / (norecurCount + 3)
        if row[2] in norec3[0]:
            instances = norec3[1][np.where(norec3[0] == row[2])[0][0]]
        else:
            instances = 0
        pX3NoRecur = (instances + 1) / (norecurCount + 12)
        if row[3] in norec4[0]:
            instances = norec4[1][np.where(norec4[0] == row[3])[0][0]]
        else:
            instances = 0
        pX4NoRecur = (instances + 1) / (norecurCount + 13)
        if row[4] in norec5[0]:
            instances = norec5[1][np.where(norec5[0] == row[4])[0][0]]
        else:
            instances = 0
        pX5NoRecur = (instances + 1) / (norecurCount + 2)
        if row[5] in norec6[0]:
            instances = norec6[1][np.where(norec6[0] == row[5])[0][0]]
        else:
            instances = 0
        pX6NoRecur = (instances + 1) / (norecurCount + 3)
        if row[6] in norec7[0]:
            instances = norec7[1][np.where(norec7[0] == row[6])[0][0]]
        else:
            instances = 0
        pX7NoRecur = (instances + 1) / (norecurCount + 2)
        if row[7] in norec8[0]:
            instances = norec8[1][np.where(norec8[0] == row[7])[0][0]]
        else:
            instances = 0
        pX8NoRecur = (instances + 1) / (norecurCount + 5)
        if row[8] in norec9[0]:
            instances = norec9[1][np.where(norec9[0] == row[8])[0][0]]
        else:
            instances = 0
        pX9NoRecur = (instances + 1) / (norecurCount + 2)
        pNoRecurAllX = pX1NoRecur * pX2NoRecur * pX3NoRecur * pX4NoRecur * pX5NoRecur * pX6NoRecur * pX7NoRecur \
                       * pX8NoRecur * pX9NoRecur * pNoRecur

        if pRecurAllX >= pNoRecurAllX:
            predictions.append("recurrence-events")
        else:
            predictions.append("no-recurrence-events")
    # ^^^^^ YOUR CODE GOES HERE ^^^^^ $
    return predictions


def cross_validate(training_inputs, testing_inputs, training_labels, testing_labels, k=5):
    # Here you should re-split the dataset into folds, preprocess again,
    #   run through your naive bayes, and measure the accuracy for each fold.
    # See the test script for examples of part of this process.

    kf_ete = []  # array of k-fold cross validation estimates of test error

    # VVVVV YOUR CODE GOES HERE VVVVV $

    # ^^^^^ YOUR CODE GOES HERE ^^^^^ $
    return kf_ete
