'use strict';   // Default i moduler
import Slideshow from './lib/Slideshow.js';

function createSlideshow (id, theme='') {
  const slideshow = new Slideshow(id, theme);
}

window.createSlideshow = createSlideshow;