var fs = require('fs');
var express = require('express');
var app = express();


app.use(express.json());
app.use('/', express.static(__dirname + "/"));

app.post('/readScoreboard', function(req, res){ 
	filePath = __dirname + '/scoreboard.txt';
	var scoreObject;
	fs.readFile(filePath, function(err, data){
		if(err){
			throw err;
		}
		scoreObject = JSON.parse(data);
	});
});

app.post('/writeScoreboard', function(req, res){ 
	filePath = __dirname + '/scoreboard.txt';
	var scoreObject;
	fs.readFile(filePath, function(err, data){
		if(err){
			throw err;
		}
		scoreObject = JSON.parse(data);
		scoreObject["iteration"]++;
		req.body[0].id = scoreObject["iteration"];
		scoreObject["scoreboard"].push(req.body[0]);
		if(scoreObject["scoreboard"].length <= 10){
			fs.writeFile(filePath, JSON.stringify(scoreObject), function(err){
				if(err){
					throw err;
				}
			});
		} else {
				console.log('check scores');
		}
	});
});

app.listen(3000, function(){
        console.log('Listening...');
});
