import LazyLoad from 'vanilla-lazyload';
import MenuHandler from 'colby-bootstrap/js/menu-handler';
import fitParentToChild from 'colby-bootstrap/js/fit-parent-to-child';
import debounce from 'lodash/debounce';
import vex from 'vex-js';
import smoothScroll from 'smooth-scroll';

vex.defaultOptions.className = 'vex-theme-default';

const lazyload = new LazyLoad();
const splashTimeout = 3000;
const galleryInterval = 4000;

window.addEventListener('load', handleSplash);
window.addEventListener('load', () => new GalleryHandler());
window.addEventListener('load', fixSVGs);

function handleSplash() {
  const splash = document.querySelector('.front-page-splash');

  const simpleFooter = document.querySelector('.simple-footer');
  const splashText = document.querySelector('.front-page-splash__text');
  const splashBackground = document.querySelector(
    '.front-page-splash__background'
  );
  const header = document.querySelector('.three-column-header');

  if (!splash) {
    return document.querySelector('body').style.opacity = '1';
  }

  document.querySelector('body').style.opacity = '1';
  setTimeout(
    () => {
      splash.style.opacity = '0';
    },

    splashTimeout
  );
  setTimeout(
    () => {
      splash.style.height = '0';
      splash.style['pointer-events'] = 'none';
    },

    splashTimeout + 1000
  );
}

class GalleryHandler {
  constructor() {
    this.gallery = document.querySelector('.front-page-gallery');
    this.titles = document.querySelectorAll('[class*=title-]');
    this.images = document.querySelectorAll('.front-page-gallery__images img');
    this.imagesContainer = document.querySelector(
      '.front-page-gallery__images'
    );

    this.run = this.run.bind(this);
    this.handleActiveIndex = this.handleActiveIndex.bind(this);

    if (this.gallery && this.titles && this.images) {
      this.activeIndex = -1;
      this.run();
    }
  }

  run() {
    setTimeout(
      () => {
        this.gallery.classList.remove('pre-load');
        this.handleActiveIndex();
        setInterval(this.handleActiveIndex, galleryInterval);
        this.gallery.style.opacity = '1';
      },

      splashTimeout
    );
  }

  handleActiveIndex() {
    this.activeIndex++;

    if (this.activeIndex >= this.images.length) {
      this.activeIndex = 0;
    }

    [].forEach.call(
      document.querySelectorAll(`.front-page-gallery__titles > span`),
      span => {
        span.style['font-weight'] = '';
        span.style.opacity = '';
      }
    );

    [].forEach.call(
      document.querySelectorAll(`.title-${this.activeIndex}`),
      span => {
        span.style['font-weight'] = '900';
        span.style.opacity = 1;
      }
    );

    [].forEach.call(
      this.images,
      image => image.classList.remove('front-page-gallery__active-image')
    );

    this.images[this.activeIndex].classList.add(
      'front-page-gallery__active-image'
    );
  }
}

window.addEventListener('load', () => {
  const menuIcon = document.querySelector('.menu-icon-container');
  const menus = document.querySelectorAll(
    '.three-column-header__collapsible-columns'
  );

  if (!menuIcon && !menus) {
    return;
  }

  menuIcon.addEventListener('click', event => {
    event.preventDefault();

    menuIcon.classList.toggle('active');
    [...menus].forEach(menu => menu.classList.toggle('mobile-active'));
  });
});

window.addEventListener(
  'load',
  () =>
    new MenuHandler({
      parentSelector: '.menu-item-has-children',
      submenuSelector: '.sub-menu',
    })
);

window.addEventListener('load', () => {
  const text = document.querySelector('.front-page-gallery__titles');
});

function fixSVGs() {
  const svgs = document.querySelectorAll('svg');

  if (!svgs) {
    return;
  }

  let fixIt = svg => {
    let height = svg.getAttribute('height');
    let width = svg.getAttribute('width');

    if (!height || !width) {
      return;
    }

    width = Number(width.replace('px', ''));
    height = Number(height.replace('px', ''));

    const ratio = height / width;
    const computedHeight = svg.clientWidth * ratio;
    console.log(width, height, ratio);

    svg.style.height = `${computedHeight}px`;
  };

  let fixThem = () => {
    [].forEach.call(svgs, fixIt);
  };

  fixThem();
  fixThem = debounce(fixThem, 100);
  window.addEventListener('resize', fixThem);
}

window.addEventListener('load', () => {
  fitParentToChild({
    parentSelector: '.front-page-gallery',
    childSelector: '.front-page-gallery__images img',
  });
});

window.addEventListener('load', () => {
  const mediaKitPosts = document.querySelectorAll('.media-kit-post');

  if (!mediaKitPosts) {
    return;
  }

  [].forEach.call(mediaKitPosts, post => {
    post.addEventListener('click', event => {
      event.preventDefault();

      const imageHTML = post.getAttribute('data-image');
      vex.open({ unsafeContent: imageHTML });
      document.querySelector('.vex').classList.add('active');
    });
  });
});

