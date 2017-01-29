// Third-party node packages.
import 'whatwg-fetch';
import LazyLoad from 'vanilla-lazyload';
import smoothScroll from 'smooth-scroll';
import React from 'react';
import { render } from 'react-dom';

// Colby Bootstrap node packages.
import MenuHandler from 'colby-bootstrap/js/menu-handler';
import fitParentToChild from 'colby-bootstrap/js/fit-parent-to-child';
import handleThreeColumnMenu from 'colby-bootstrap/js/handle-three-column-menu';

// Imports from this project.
import handleSplash from './handle-splash';
import GalleryHandler from './gallery-handler';
import handleMediaKit from './handle-media-kit';
import HeaderSearch from './header-search';

const lazyload = new LazyLoad();

// Import babel-polyfill if Array.from is not defined (a sign of an old browser).
if (typeof Array.from === 'undefined') {
  let script = document.createElement('script');
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.16.0/polyfill.min.js';
  document.head.appendChild(script);
}

window.addEventListener('load', () => {
  handleSplash();
  handleThreeColumnMenu();
  handleMediaKit();

  new GalleryHandler();
  new MenuHandler({
    parentSelector: '.menu-item-has-children',
    submenuSelector: '.sub-menu',
  });
  fitParentToChild({
    parentSelector: '.front-page-gallery',
    childSelector: '.front-page-gallery__images img',
  });

  const searchContainer = document.getElementById('header-search');
  if (searchContainer) {
    render(<HeaderSearch />, searchContainer);
  }
});
