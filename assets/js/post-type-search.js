import React, { Component } from 'react';
import debounce from 'lodash/debounce';
import parse from 'url-parse';

export default class PostTypeSearch extends Component {
  constructor(props) {
    super(props);

    this.cache = {};
    this.postType = this.props.postType || 'posts';
    this.cssNamespace = this.postType;

    this.baseUrl = `${wpData.bloginfoUrl}/wp-json/wp/v2/${this.postType}/`;

    const parsedQuery = this.getURLQueryVars();
    this.state = {
      search: parsedQuery.collectionSearch,
      loading: false,
      posts: null,
      currentPage: Number(parsedQuery.currentPage),
      totalPages: 0,
    };

    /** Bind functions to class. */
    this.handleSearchInputChange = this.handleSearchInputChange.bind(this);
    this.fetchPosts = this.fetchPosts.bind(this);
    this.drawPost = this.drawPost.bind(this);
    this.drawTopNav = this.drawTopNav.bind(this);
    this.drawBottomNav = this.drawBottomNav.bind(this);
    this.drawNav = this.drawNav.bind(this);
    this.updateWindowHistory = this.updateWindowHistory.bind(this);

    /** Debounce functions. */
    this.fetchPosts = debounce(this.fetchPosts, 200);
  }

  /** Parse the URL for GET parameters. */
  getURLQueryVars() {
    const url = parse(window.location.href, true);

    if (
      url.query && url.query[`${this.postType}Search`] && url.query.currentPage
    ) {
      return url.query;
    }

    const parsedQuery = {};
    parsedQuery.currentPage = 1;
    parsedQuery[`${this.postType}Search`] = '';

    return parsedQuery;
  }

  /** Handle the search string from the input box. */
  handleSearchInputChange(event) {
    this.setState({ search: event.target.value, currentPage: 1 });
    this.fetchPosts({ search: event.target.value });
  }

  /** Set URL parameters according to current app state. */
  updateWindowHistory() {
    window.history.replaceState(
      {},
      document.title,
      `${window.location.origin}${window.location.pathname}` +
        `?${this.postType}Search=${this.state.search}&currentPage=${this.state.currentPage}`
    );
  }

  fetchPosts(options) {
    if (options && 'pageIncrementer' in options) {
      this.setState({
        currentPage: this.state.currentPage += options.pageIncrementer,
      });
    }

    const pageParameter = `page=${this.state.currentPage}`;

    let searchParameter = this.state.search
      ? `&search=${this.state.search}`
      : '';

    this.updateWindowHistory();

    const url = `${this.baseUrl}?${pageParameter}${searchParameter}`;

    /** Restore from cache if this URL has been requested already. */
    if (url in this.cache) {
      return this.setState({
        posts: this.cache[url].posts,
        totalPages: this.cache[url].totalPages,
      });
    }

    this.setState({ loading: true });

    fetch(url)
      .then(data => {
        this.setState({ totalPages: data.headers.get('X-WP-TotalPages') });
        return data.json();
      })
      .then(posts => {
        this.cache[url] = { posts, totalPages: this.state.totalPages };
        this.setState({ posts, loading: false });
      });
  }

  drawThumbnail(post) {
    return null;
  }

  drawPost(post, key) {
    return (
      <a
        href={post.link}
        key={key}
        className={`${this.cssNamespace}-search__post`}
      >
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
      </a>
    );
  }

  drawLoading() {
    return <div>Loading</div>;
  }

  drawTopNav() {
    return this.drawNav({ location: 'top' });
  }

  drawBottomNav() {
    return this.drawNav({ location: 'bottom' });
  }

  drawNav() {
    return null;
  }

  render() {
    return (
      <div className={`${this.cssNamespace}-search`}>
        <div className={`${this.cssNamespace}-search__input-container`}>
          <input
            ref={'search-input'}
            id={`${this.cssNamespace}-search__input`}
            value={this.state.search}
            placeholder={this.props.placeholder || 'Search posts'}
            onChange={this.handleSearchInputChange}
          />
        </div>
        {this.drawTopNav()}
        {
          this.state.posts !== null && this.state.posts.length
            ? this.state.posts.map(this.drawPost)
            : this.drawLoading()
        }
        {this.drawBottomNav()}
      </div>
    );
  }
}
