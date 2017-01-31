import React, { Component } from 'react';
import debounce from 'lodash/debounce';

import PostTypeSearch from './post-type-search';

export default class CollectionSearch extends PostTypeSearch {
  constructor(props) {
    super(props);

    this.drawArchive = this.drawArchive.bind(this);
    this.fetchPosts = this.fetchPosts.bind(this);
    this.drawLoading = this.drawLoading.bind(this);
  }

  drawLoading() {
    this.drawArchive();
  }

  drawArchive() {
    return this.fetchPosts();
  }

  drawNav() {
    return (
      <div className={`${this.cssNamespace}-search__nav`}>
        <div className={`${this.cssNamespace}-search__nav-left`}>
          {
            this.currentPage < 2 ? ' ' : <a
                href="#"
                onClick={event => {
                  event.preventDefault();
                  this.fetchPosts({ pageIncrementer: -1 });
                }}
              >
                Previous
              </a>
          }
        </div>
        <div className={`${this.cssNamespace}-search__nav-middle`}>
          Page {this.currentPage} of {this.totalPages}
        </div>
        <div className={`${this.cssNamespace}-search__nav-right`}>
          {
            this.currentPage >= this.totalPages ? ' ' : <a
                href="#"
                onClick={event => {
                  event.preventDefault();
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
