'use strict';

let up = document.querySelectorAll("p.up");
let down = document.querySelectorAll("p.down");

up.forEach(function(up) {
up.addEventListener("click", function(event) {
  console.log("clicked up!");
})});

down.forEach(function(down) {
down.addEventListener("click", function(event) {
  console.log("clicked down!");
})});
