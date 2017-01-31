import React, { Component } from 'react';
import debounce from 'lodash/debounce';

export default class PostTypeSearch extends Component {
  constructor(props) {
    super(props);

    this.cache = {};

    this.currentPage = 1;
    this.totalPages = 0;

    this.postType = this.props.postType || 'posts';
    this.cssNamespace = this.postType;

    this.baseUrl = `${wpData.bloginfoUrl}/wp-json/wp/v2/${this.postType}/`;

    this.state = { search: '', searching: false, posts: [] };

    this.handleChange = this.handleChange.bind(this);
    this.fetchPosts = this.fetchPosts.bind(this);
    this.drawPost = this.drawPost.bind(this);
    this.drawTopNav = this.drawTopNav.bind(this);
    this.drawBottomNav = this.drawBottomNav.bind(this);
    this.drawNav = this.drawNav.bind(this);

    this.fetchPosts = debounce(this.fetchPosts, 200);
  }

  handleChange(event) {
    this.currentPage = 1;
    this.setState({ search: event.target.value });
    this.fetchPosts({ search: event.target.value });
  }

  fetchPosts(options) {
    if (options && 'pageIncrementer' in options) {
      this.currentPage += options.pageIncrementer;
    }

    const pageParameter = `page=${this.currentPage}`;

    let searchParameter = '';
    if (this.state.search) {
      searchParameter = `&search=${this.state.search}`;
    }

    const url = `${this.baseUrl}?${pageParameter}${searchParameter}`;

    if (url in this.cache) {
      return this.setState({ posts: this.cache[url] });
    }

    this.setState({ searching: false });

    fetch(url)
      .then(data => {
        this.totalPages = data.headers.get('X-WP-TotalPages');
        return data.json();
      })
      .then(posts => {
        this.cache[url] = posts;
        this.setState({ posts, searching: false });
      });
  }

  drawThumbnail(post) {
    return null;
  }

  drawPost(post, key) {
    return (
      <div key={key} className={`${this.cssNamespace}-search__post`}>
        <div className={`${this.cssNamespace}-search__content-container`}>
          <h1
            className={`${this.cssNamespace}-search__title`}
            dangerouslySetInnerHTML={{ __html: post.title.rendered }}
          />
          <div
            className={`${this.cssNamespace}-search__content`}
            dangerouslySetInnerHTML={{ __html: post.content.rendered }}
          />
        </div>
        {this.drawThumbnail(post)}
      </div>
    );
  }

  drawLoading() {
    return <div>Loading</div>;
  }

  drawTopNav() {
    return this.drawNav();
  }

  drawBottomNav() {
    return this.drawNav();
  }

  drawNav() {
    return null;
  }

  render() {
    return (
      <div className={`${this.cssNamespace}-search`}>
        <div className={`${this.cssNamespace}-search__input-container`}>
          <input
            value={this.state.search}
            placeholder={this.props.placeholder || 'Search posts'}
            onChange={this.handleChange}
          />
        </div>
        {this.drawTopNav()}
        {
          this.state.posts.length
            ? this.state.posts.map(this.drawPost)
            : this.drawLoading()
        }
        {this.drawBottomNav()}
      </div>
    );
  }
}
