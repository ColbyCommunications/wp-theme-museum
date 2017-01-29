const splashTimeout = 3000;
const galleryInterval = 4000;

export default class GalleryHandler {
  constructor() {
    this.gallery = document.querySelector('.front-page-gallery');
    this.titleSpans = document.querySelectorAll(
      `.front-page-gallery__titles > span`
    );
    this.images = document.querySelectorAll('.front-page-gallery__images img');
    this.savedTitles = {};

    this.start = null;

    this.run = this.run.bind(this);
    this.handleActiveIndex = this.handleActiveIndex.bind(this);

    if (this.gallery && this.titleSpans && this.images) {
      this.activeIndex = -1;
      window.requestAnimationFrame(this.run);
    }
  }

  run(timestamp) {
    this.start = this.start ? this.start : timestamp;
    const progress = timestamp - this.start;

    if (progress > splashTimeout && progress % splashTimeout < 20) {
      this.handleActiveIndex();
      this.gallery.style.opacity = '1';
    }

    window.requestAnimationFrame(this.run);
  }

  handleActiveIndex() {
    this.activeIndex++;

    if (this.activeIndex >= this.images.length) {
      this.activeIndex = 0;
    }

    [].forEach.call(this.titleSpans, span => {
      span.style['font-weight'] = '';
      span.style.opacity = '';
    });

    // Cache words in this title.
    if (!this.savedTitles[`.title-${this.activeIndex}`]) {
      let titles = document.querySelectorAll(`.title-${this.activeIndex}`);
      this.savedTitles[`.title-${this.activeIndex}`] = titles;
    }

    [].forEach.call(this.savedTitles[`.title-${this.activeIndex}`], span => {
      span.style['font-weight'] = '900';
      span.style.opacity = 1;
    });

    [].forEach.call(
      this.images,
      image => image.classList.remove('front-page-gallery__active-image')
    );

    this.images[this.activeIndex].classList.add(
      'front-page-gallery__active-image'
    );
  }
}
