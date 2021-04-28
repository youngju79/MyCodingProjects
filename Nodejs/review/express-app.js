const express = require("express");
const axios = require("axios");

const app = express();

app.get('/dad-joke', (request, response) => {
    const promise = axios.get("https://icanhazdadjoke.com/", {
        headers: {
            Accept: "application/json"
        }
    });

    promise.then((icanhazdadjokeResponse) => {
        response.json(icanhazdadjokeResponse.data);
    });
});

app.listen(8000);