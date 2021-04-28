const http = require("http");
const fs = require("fs");

http.createServer((request, response) => {
    console.log(request.url);
    fs.readFile(`.${request.url}`, 'utf8', (error, data) => {
        if(error){
            response.writeHead(404);
            response.end();
        }
        else{
            response.write(data);
            response.end();
        }
    });

}).listen(8000);
