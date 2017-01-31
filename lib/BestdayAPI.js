var webPage = require('webpage');
var page = webPage.create();

alert("hello");

page.open('https://www.bestday.com/Flores-Guatemala/Hotels/', function(status) {
  console.log("Already run.");
  alert("good");
  phantom.exit();
});
