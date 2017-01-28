const splashTimeout = 3000;
const galleryInterval = 4000;

export default class GalleryHandler {
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
