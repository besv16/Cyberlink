'use strict';

function voteLink(score, linkID, direction, event) {
  score = score;
  if (direction.className == 'up') {

    ++score;

    event.target.dataset.vote = score;
    event.target.nextElementSibling.dataset.vote = score;

    console.log(event.target.dataset.vote);
    console.log(event.target.nextElementSibling.dataset.vote);
    console.log('-----------');

  }

  if (direction.className == 'down') {

    --score;

    event.target.dataset.vote = score;
    event.target.previousElementSibling.dataset.vote = score;

    console.log(event.target.dataset.vote);
    console.log(event.target.previousElementSibling.dataset.vote);
    console.log('-----------');
  }
}

var upButtons = document.querySelectorAll("p.up");
var downButtons = document.querySelectorAll("p.down");

upButtons.forEach(function(up) {
  up.addEventListener("click", function(event) {
    voteLink(event.target.dataset.vote, event.target.dataset.linkId, up, event);
  })
});

downButtons.forEach(function(down) {
  down.addEventListener("click", function(event) {
    voteLink(event.target.dataset.vote, event.target.dataset.linkId, down, event);
  })
});
