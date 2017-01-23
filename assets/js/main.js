import LazyLoad from 'vanilla-lazyload';
import MenuHandler from 'colby-bootstrap/js/menu-handler';
import debounce from 'lodash/debounce';

const lazyload = new LazyLoad();

window.addEventListener('load', handleSplash);
window.addEventListener('load', () => new GalleryHandler());

function handleSplash() {
  const splash = document.querySelector('.front-page-splash');
  const splashText = document.querySelector('.front-page-splash__text');

  if (!splash) {
    document.querySelector('body').style.opacity = '1';
    return;
  }

  const splashBackground = document.querySelector(
    '.front-page-splash__background'
  );

  const header = document.querySelector('.three-column-header');

  let resizeBackground = () => {
    const foregroundHeight = splashText.clientHeight;
    const headerHeight = header.clientHeight;

    splashBackground.style.height = `${foregroundHeight + headerHeight}px`;
  };

  resizeBackground();

  resizeBackground = debounce(resizeBackground, 200);

  window.addEventListener('resize', resizeBackground);
  document.querySelector('body').style.opacity = '1';
  setTimeout(() => splash.style.opacity = '0', 4000);
  setTimeout(() => splash.style['pointer-events'] = 'none', 5000);
}

class GalleryHandler {
  constructor() {
    this.gallery = document.querySelector('.front-page-gallery');
    this.titles = document.querySelectorAll('.front-page-gallery__title');
    this.images = document.querySelectorAll('.front-page-gallery__images img');

    this.run = this.run.bind(this);
    this.handleActiveIndex = this.handleActiveIndex.bind(this);

    if (this.gallery && this.titles && this.images) {
      this.activeIndex = 0;
      this.run();
    }
  }

  run() {
    setTimeout(
      () => {
        setInterval(this.handleActiveIndex, 8000);
        this.gallery.style.opacity = '1';
      },
      4000
    );
  }

  handleActiveIndex() {
    this.activeIndex++;

    if (this.activeIndex >= this.images.length) {
      this.activeIndex = 0;
    }

    [].forEach.call(
      this.images,
      image => image.classList.remove('front-page-gallery__active-image')
    );
    this.images[this.activeIndex].classList.add(
      'front-page-gallery__active-image'
    );

    [].forEach.call(
      this.titles,
      title => title.classList.remove('front-page-gallery__active-title')
    );
    this.titles[this.activeIndex].classList.add(
      'front-page-gallery__active-title'
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
