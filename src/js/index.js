// Third-party node packages.
import 'whatwg-fetch';
import LazyLoad from 'vanilla-lazyload';
import smoothscrollPolyfill from 'smoothscroll-polyfill';
import React from 'react';
import { render } from 'react-dom';

// Colby Bootstrap node packages.
import MenuHandler from './menu-handler';
import fitParentToChild from './fit-parent-to-child';
import handleThreeColumnMenu from './handle-three-column-menu';

// Imports from this project.
import handleSplash from './handle-splash';
import GalleryHandler from './gallery-handler';
import handleMediaKit from './handle-media-kit';
import HeaderSearch from './header-search';
import CollectionSearch from './collection-search';

const lazyload = new LazyLoad();
smoothscrollPolyfill.polyfill();

// Import babel-polyfill if Array.from is not defined (a sign of an old browser).
if (typeof Array.from === 'undefined') {
  let script = document.createElement('script');
  script.src =
    'https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.16.0/polyfill.min.js';
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

  const collectionSearchContainer = document.getElementById(
    'collection-search'
  );
  if (collectionSearchContainer) {
    render(
      <CollectionSearch
        postType="collection"
        placeholder="Search the Collection"
      />,
      collectionSearchContainer
    );
  }
});
