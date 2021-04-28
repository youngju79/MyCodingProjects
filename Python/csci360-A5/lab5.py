import numpy as np
from lab5_utils import relu, mean_squared_error, ArtificialNeuralNetwork


def d_mse(y, y_hat):
    return y_hat - y


def d_relu(x):
    temp = np.maximum(0, x)
    temp = np.where(temp != 0, 1, temp)
    return temp


# consider how you can use ArtificialNeuralNetwork.forward and ArtificialNeuralNetwork.at_layer to help with BP
def train(
        neural_network,
        training_inputs,
        training_labels,
        n_epochs,
        learning_rate=0.001
):
    losses = []
    for i in range(n_epochs):
        y_hat, a_memory, z_memory = neural_network.forward(training_inputs)
        dAl = d_mse(training_labels[0], y_hat)
        for layer in range(len(neural_network.layers) - 1, -1, -1):
            if layer == 0:
                Alminus1 = training_inputs
            else:
                Alminus1 = relu(z_memory[layer - 1])
            dZl = np.multiply(dAl, d_relu(z_memory[layer]))
            dWl = np.dot(dZl, np.transpose(Alminus1))
            dB = np.sum(dZl)/len(training_inputs)
            dAl = np.dot(np.transpose(neural_network.layers[layer]), dZl)

            neural_network.layers[layer] = neural_network.layers[layer] - learning_rate * dWl
            neural_network.biases[layer] = neural_network.biases[layer] - learning_rate * dB
        losses.append(mean_squared_error(training_labels, y_hat))
    return losses


def extra_credit(x_train, y_train, x_test, y_test):
    # populate this dictionary with your extra credit experiments...
    results = {
        "architectures": [],
        "n_epochs": [],
        "learning_rate": [],
        "training_losses": [],
        "evaluation_mean_squared_error": []
    }

    return results
