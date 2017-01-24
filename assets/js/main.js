import LazyLoad from 'vanilla-lazyload';
import MenuHandler from 'colby-bootstrap/js/menu-handler';
import debounce from 'lodash/debounce';

const lazyload = new LazyLoad();
const splashTimeout = 5000;
const galleryInterval = 8000;

window.addEventListener('load', handleSplash);
window.addEventListener('load', () => new GalleryHandler());

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

  let setSplashFooterMargin = () => {
    simpleFooter.style['margin-top'] = `${splash.clientHeight}px`;
    setTimeout(() => simpleFooter.style['transition'] = 'margin-top .5s', 200);
  };
  setSplashFooterMargin();
  setSplashFooterMargin = debounce(setSplashFooterMargin, 200);
  window.addEventListener('resize', setSplashFooterMargin);

  document.querySelector('body').style.opacity = '1';
  setTimeout(
    () => {
      splash.style.opacity = '0';
      window.removeEventListener('resize', setSplashFooterMargin);
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

  let resizeSplashBackground = () => {
    splashBackground.style.height = `${splashText.clientHeight +
      header.clientHeight}px`;
    splashBackground.style.width = 'auto';
  };

  resizeSplashBackground();
  resizeSplashBackground = debounce(resizeSplashBackground, 200);
  window.addEventListener('resize', resizeSplashBackground);
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
    const simpleFooter = document.querySelector('.simple-footer');

    setTimeout(
      () => {
        this.handleActiveIndex();
        setInterval(this.handleActiveIndex, galleryInterval);
        this.header = document.querySelector('body > header');

        let setFooterMargin = () =>
          simpleFooter.style['margin-top'] = `${this.gallery.clientHeight}px`;
        setFooterMargin();
        setFooterMargin = debounce(setFooterMargin, 200);
        window.addEventListener('resize', setFooterMargin);

        this.gallery.style.opacity = '1';
        this.gallery.classList.remove('pre-load');

        let setImageHeights = () => {
          document.querySelector(
            '.front-page-gallery__images'
          ).style.height = `${this.gallery.clientHeight +
            this.header.clientHeight}px`;
        };

        setImageHeights();
        setImageHeights = debounce(setImageHeights, 200);
        window.addEventListener('resize', setImageHeights);
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
        span.style['opacity'] = '';
      }
    );

    [].forEach.call(
      document.querySelectorAll(`.title-${this.activeIndex}`),
      span => {
        span.style['font-weight'] = '900';
        span.style['opacity'] = 1;
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
    [ ...menus ].forEach(menu => menu.classList.toggle('mobile-active'));
  });
});

window.addEventListener(
  'load',
  () =>
    new MenuHandler({
      parentSelector: '.menu-item-has-children',
      submenuSelector: '.sub-menu'
    })
);

window.addEventListener('load', () => {
  const text = document.querySelector('.front-page-gallery__titles');
});
