const express = require("express");
const axios = require("axios");
const fs = require("fs");

const app = express();

app.get('/api/github/:username', (request, response) => {
    var filename = './' + request.params.username + '.txt';
    fs.readFile(filename, "utf8", (error, data) => {
        if(error){  // file does not exist
            const promise = axios.get("https://api.github.com/users/" + request.params.username, {
                headers: {
                    Accept: "application/json"
                }
            });
            promise.then((githubResponse) => {
                response.json({
                    "repoCount": githubResponse.data.public_repos
                });
                // cache data to file
                fs.writeFile(filename, githubResponse.data.public_repos.toString(), (error) => {
                    console.log("A file has been written to");
                });
            });
        } // file exists
        else{
            response.json({
                "repoCount": data
            });
        }
    });
});

app.listen(8000);