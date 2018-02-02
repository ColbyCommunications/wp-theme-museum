import React from 'react';

import PostTypeSearch from './post-type-search';

export default class CollectionSearch extends PostTypeSearch {
  constructor(props) {
    super(props);

    this.drawArchive = this.drawArchive.bind(this);
    this.fetchPosts = this.fetchPosts.bind(this);
    this.drawLoading = this.drawLoading.bind(this);
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
    return null;
  }

  drawArchive() {
    return this.fetchPosts();
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
