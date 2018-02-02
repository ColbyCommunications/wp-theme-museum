// Third-party node packages.
import 'whatwg-fetch';
import LazyLoad from 'vanilla-lazyload';
import smoothscrollPolyfill from 'smoothscroll-polyfill';
import React from 'react';
import { render } from 'react-dom';

import MenuHandler from './menu-handler';
import fitParentToChild from './fitParentToChild';
import handleThreeColumnMenu from './handle-three-column-menu';
import { frontPageSplash } from './frontPageSplash';
import FrontPageGallery from './FrontPageGallery';
import handleMediaKit from './handle-media-kit';
import InlineSearch from './InlineSearch';
import CollectionSearch from './CollectionSearch';

new LazyLoad();
smoothscrollPolyfill.polyfill();

window.addEventListener('load', frontPageSplash);
window.addEventListener('load', handleThreeColumnMenu);
window.addEventListener('load', handleMediaKit);

window.addEventListener('load', () => {
  new FrontPageGallery();
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
    render(<InlineSearch />, searchContainer);
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
