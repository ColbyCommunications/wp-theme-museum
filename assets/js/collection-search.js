import React, { Component } from 'react';
import debounce from 'lodash/debounce';
import smoothScroll from 'smooth-scroll';

import PostTypeSearch from './post-type-search';

export default class CollectionSearch extends PostTypeSearch {
  constructor(props) {
    super(props);

    this.drawArchive = this.drawArchive.bind(this);
    this.fetchPosts = this.fetchPosts.bind(this);
    this.drawLoading = this.drawLoading.bind(this);
    this.drawNav = this.drawNav.bind(this);
  }

  drawLoading() {
    if (
      this.state.search &&
        this.state.posts !== null &&
        this.state.posts.length === 0
    ) {
      return <div>No results</div>;
    }

    this.drawArchive();
  }

  drawArchive() {
    return this.fetchPosts();
  }

  drawNav(options) {
    return (
      <div className={`${this.cssNamespace}-search__nav`}>
        <div className={`${this.cssNamespace}-search__nav-left`}>
          {
            this.state.currentPage < 2 ? ' ' : <a
                href="#"
                onClick={event => {
                  event.preventDefault();

                  if (
                    options && options.location && options.location == 'bottom'
                  ) {
                    smoothScroll.animateScroll(this.refs['search-input']);
                  }

                  this.fetchPosts({ pageIncrementer: -1 });
                }}
              >
                Previous
              </a>
          }
        </div>
        <div className={`${this.cssNamespace}-search__nav-middle`}>
          {
            this.state.totalPages > 1
              ? `Page ${this.state.currentPage} of ${this.state.totalPages}`
              : ''
          }
          <div className={`${this.cssNamespace}-search__loading`}>
            {this.state.loading == true ? 'Loading ...' : ''}
          </div>
        </div>
        <div className={`${this.cssNamespace}-search__nav-right`}>
          {
            this.state.currentPage >= this.state.totalPages ? ' ' : <a
                href="#"
                onClick={event => {
                  event.preventDefault();

                  if (
                    options && options.location && options.location == 'bottom'
                  ) {
                    smoothScroll.animateScroll(this.refs['search-input']);
                  }

                  this.fetchPosts({ pageIncrementer: 1 });
                }}
              >
                Next
              </a>
          }
        </div>
      </div>
    );
  }

  drawThumbnail(post) {
    if (!post.img_url || post.img_url.indexOf('noimage') !== -1) {
      return null;
    }

    return (
      <div className="post-type-search__thumbnail-container">
        <img src={post.img_url} />
      </div>
    );
  }
}
