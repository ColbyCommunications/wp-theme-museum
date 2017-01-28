import LazyLoad from 'vanilla-lazyload';
import MenuHandler from 'colby-bootstrap/js/menu-handler';
import fitParentToChild from 'colby-bootstrap/js/fit-parent-to-child';
import debounce from 'lodash/debounce';
import vex from 'vex-js';
import smoothScroll from 'smooth-scroll';
import React, { Component } from 'react/dist/react.min';
import { render } from 'react-dom';
import 'whatwg-fetch';

import fixSVGs from './fix-svgs';

vex.defaultOptions.className = 'vex-theme-default';

const lazyload = new LazyLoad();
const splashTimeout = 3000;
const galleryInterval = 4000;

window.addEventListener('load', handleSplash);
window.addEventListener('load', () => new GalleryHandler());

if (wpData.isSafari) {
  window.addEventListener('load', fixSVGs);
}

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

window.addEventListener('load', () => {
  const searchContainer = document.getElementById('header-search');

  render(<HeaderSearch />, searchContainer);
});

class HeaderSearch extends Component {
  constructor(props) {
    super(props);

    this.state = {
      search: '',
      results: [],
      showingResults: false,
      currentPage: 1,
      loading: false,
    };
    this.totalPages = null;

    this.handleSearch = this.handleSearch.bind(this);
    this.closeSearch = this.closeSearch.bind(this);
    this.drawResult = this.drawResult.bind(this);

    this.handleSearch = debounce(this.handleSearch, 200);
  }

  componentDidMount() {
    window.addEventListener('click', event => {
      if (this.showingResults === false) {
        return;
      }

      if (event.target.nodeName == 'A' || event.target.nodeName == 'INPUT') {
        return;
      }

      if (!event.target.classList.contains('header-search-container')) {
        this.closeSearch();
      }
    });

    window.addEventListener('keydown', event => {
      if (this.showingResults === false) {
        return;
      }

      if (event.keyCode == 27) {
        this.closeSearch();
      }
    });
  }

  drawResult(result, key) {
    return (
      <li key={key}>
        <a
          href={result.link}
          dangerouslySetInnerHTML={{ __html: result.title.rendered }}
        />
      </li>
    );
  }

  closeSearch() {
    return this.setState({
      search: '',
      results: [],
      showingResults: false,
      currentPage: 1,
    });
  }

  handleSearch(search) {
    if (search === '') {
      return this.closeSearch();
    }

    this.setState({ loading: true });

    const url = `${wpData.bloginfoUrl}` +
      `/wp-json/wp/v2/posts?search=${search}&page=${this.state.currentPage}`;

    fetch(url)
      .then(response => {
        this.totalPages = response.headers.get('X-WP-TotalPages');
        return response.json();
      })
      .then(results => {
        this.setState({ results, showingResults: true, loading: false });
      });
  }

  render() {
    return (
      <div className="header-search-container">
        <a
          href="#"
          style={{
            opacity: this.state.search ? '0' : '1',
            pointerEvents: this.state.search ? 'none' : 'auto',
          }}
          onClick={event => event.preventDefault()}
        >
          Search
        </a>
        <input
          value={this.state.search}
          onChange={event => {
            this.setState({ search: event.target.value });
            this.handleSearch(event.target.value);
          }}

        />
        <ul
          style={{ display: this.state.showingResults ? 'block' : 'none' }}
          className="header-search-results"
        >
          <h3>
            Search Results{' '}
            {this.totalPages > 1 ? `(Page ${this.state.currentPage})` : ''}
          </h3>
          <a
            href="#"
            className="header-search-results__close"
            dangerouslySetInnerHTML={{ __html: '&Cross;' }}
            onClick={event => {
              event.preventDefault();
              this.closeSearch();
            }}

          />
          {this.state.results.map(this.drawResult)}
          <div className="header-search-results__prev-next">
            <a
              href="#"
              dangerouslySetInnerHTML={{
                __html: this.state.currentPage > 1 ? '&laquo;' : '',
              }}
              onClick={event => {
                event.preventDefault();
                this.setState({ currentPage: this.state.currentPage - 1 });
                this.handleSearch(this.state.search);
              }}

            />
            <div className="header-search-results__loading">
              {this.state.loading === true ? 'Loading ...' : ''}
            </div>
            <a
              href="#"
              dangerouslySetInnerHTML={{
                __html: this.state.currentPage < this.totalPages
                  ? '&raquo;'
                  : '',
              }}
              onClick={event => {
                event.preventDefault();
                this.setState({ currentPage: this.state.currentPage + 1 });
                this.handleSearch(this.state.search);
              }}

            />
          </div>
        </ul>
      </div>
    );
  }
}
