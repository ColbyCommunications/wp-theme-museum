// Third-party node packages.
import 'whatwg-fetch';
import LazyLoad from 'vanilla-lazyload';
import vex from 'vex-js';
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

vex.defaultOptions.className = 'vex-theme-default';

const lazyload = new LazyLoad();

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
