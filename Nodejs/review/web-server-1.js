const http = require("http");

http.createServer((request, response) => {
    response.writeHead(200, { "Content-Type": "text/html" });
    response.write(`
        <h1>ITP 405</h1>
        <p>Hello World!</p>
    `);
    response.end();
}).listen(8000);
