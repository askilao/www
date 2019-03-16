import {qs as $} from './util.js';

export default class Slideshow {
  constructor (id, theme='') {
    this.id = id;
    $(id).innerHTML = '<div></div><div></div>';  // Add two divs into the div
    fetch ('https://quota.glitch.me/random')
    .then(res=>res.json())
    .then(data=> {
        console.log (data['quoteText']);
        $(`${id} div:first-child`).innerHTML = data['quoteText'];
      });

    $(`${id} div:last-child`).addEventListener('transitionend', e=>{
      $(`${id} div:last-child`).style.opacity = 1;
      $(`${id} div:first-child`).innerHTML =
                      $(`${id} div:last-child`).innerHTML;
    });

    window.setTimeout(this.loadQuote.bind(this), 5000);  // bind this i slideShow til this
  }


  loadQuote() {
    fetch ('https://quota.glitch.me/random')
    .then(res=>res.json())
    .then(data=> {
        console.log (data['quoteText']);
        $(`${this.id} div:first-child`).innerHTML = data['quoteText'];
        $(`${this.id} div:last-child`).style.opacity = 0;
      });
    window.setTimeout(this.loadQuote.bind(this), 5000);
  } 
}