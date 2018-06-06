var fs = require('fs');
var express = require('express');
var app = express();


app.use(express.json());
app.use('/super-mario/js', express.static(__dirname + '/super-mario/public/js'));
app.use('/super-mario/img', express.static(__dirname + '/super-mario/public/img'));
app.use('/super-mario/levels', express.static(__dirname + '/super-mario/public/levels'));
app.use('/super-mario/sprites', express.static(__dirname + '/super-mario/public/sprites'));

app.use('/', express.static(__dirname + '/'));

app.listen(3000, function(){
        console.log('Listening...');
});
