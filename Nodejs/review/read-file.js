const fs = require("fs");

console.log(1);

fs.readFile('./hello-world.txt', "utf8", (error, data) => {
    console.log(data);
});

fs.readFile('./file-does-not-exist.txt', "utf8", (error, data) => {
    if(error){
        console.error(error);
    }
    console.log(data);
});

console.log(2);