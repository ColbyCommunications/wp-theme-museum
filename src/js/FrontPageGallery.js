const SPLASH_TIMEOUT = 4000;

/**
 * Runs the gallery usually set as the front page of the lunder site.
 */
export default class FrontPageGallery {
  run = this.run.bind(this);
  handleActiveIndex = this.handleActiveIndex.bind(this);

  constructor() {
    this.gallery = document.querySelector('.front-page-gallery');
    this.titleSpans = document.querySelectorAll(
      `.front-page-gallery__titles > span`
    );
    this.images = document.querySelectorAll('.front-page-gallery__images img');
    this.savedTitles = {};
    this.start = null;

    if (this.gallery && this.titleSpans && this.images) {
      this.activeIndex = -1;
      window.requestAnimationFrame(this.run);
    }
  }

  run(timestamp) {
    this.start = this.start ? this.start : timestamp;
    const progress = timestamp - this.start;

    if (progress > SPLASH_TIMEOUT) {
      this.handleActiveIndex();
      this.gallery.style.opacity = '1';
      this.start = timestamp;
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

    [].forEach.call(this.images, image =>
      image.classList.remove('front-page-gallery__active-image')
    );

    this.images[this.activeIndex].classList.add(
      'front-page-gallery__active-image'
    );
  }
}
