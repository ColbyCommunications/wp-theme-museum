import React, { Component } from 'react';
import debounce from 'debounce';
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
    this.drawNav = this.drawNav.bind(this);
    this.updateWindowHistory = this.updateWindowHistory.bind(this);

    /** Debounce functions. */
    this.fetchPosts = debounce(this.fetchPosts, 200);
  }

  /** Parse the URL for GET parameters. */
  getURLQueryVars() {
    const url = parse(window.location.href, true);

    if (
      url.query &&
      [`${this.postType}Search`] in url.query &&
      url.query.currentPage
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
        `?${this.postType}Search=${this.state.search}&currentPage=${
          this.state.currentPage
        }`
    );
  }

  async fetchPosts(options) {
    if (options && 'pageIncrementer' in options) {
      this.setState({
        currentPage: (this.state.currentPage += options.pageIncrementer),
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
      this.setState({
        posts: this.cache[url].posts,
        totalPages: this.cache[url].totalPages,
      });

      return;
    }

    this.setState({ loading: true });

    const data = await fetch(url);
    this.setState({ totalPages: data.headers.get('X-WP-TotalPages') });
    const posts = await data.json();

    this.cache[url] = { posts, totalPages: this.state.totalPages };
    this.setState({ posts, loading: false });
  }

  drawContent = post => (
    <div className={`${this.cssNamespace}-search__content-container`}>
      <h1
        className={`${this.cssNamespace}-search__title`}
        dangerouslySetInnerHTML={{
          __html: post.title.rendered
            .replace(' ,', '')
            .replace(' &nbsp;&nbsp;,', ''),
        }}
      />
      <div
        className={`${this.cssNamespace}-search__content`}
        dangerouslySetInnerHTML={{ __html: post.content.rendered }}
      />
    </div>
  );

  drawThumbnail = () => null;

  drawPost = (post, key) => (
    <a
      href={`${post.link}?source=collection`}
      key={key}
      className={`${this.cssNamespace}-search__post`}
    >
      {this.drawContent(post)}
      {this.drawThumbnail(post)}
    </a>
  );

  drawLoading = () => <div>Loading</div>;

  drawNav = options => (
    <div className={`${this.cssNamespace}-search__nav`}>
      <div className={`${this.cssNamespace}-search__nav-left`}>
        {this.state.currentPage < 2 ? (
          ' '
        ) : (
          <a
            href="#"
            onClick={event => {
              event.preventDefault();

              if (options && options.location && options.location == 'bottom') {
                this.refs['search-input'].scrollIntoView({
                  behavior: 'smooth',
                });
              }

              this.fetchPosts({ pageIncrementer: -1 });
            }}
          >
            Previous
          </a>
        )}
      </div>
      <div className={`${this.cssNamespace}-search__nav-middle`}>
        {this.state.totalPages > 1 ? (
          <div>
            {`Page ${this.state.currentPage} of ${this.state.totalPages}`}
          </div>
        ) : (
          ''
        )}
        <div className={`${this.cssNamespace}-search__loading`}>
          {this.state.loading == true ? 'Loading ...' : ''}
        </div>
      </div>
      <div className={`${this.cssNamespace}-search__nav-right`}>
        {this.state.currentPage >= this.state.totalPages ? (
          ' '
        ) : (
          <a
            href="#"
            onClick={event => {
              event.preventDefault();

              if (options && options.location && options.location == 'bottom') {
                this.refs['search-input'].scrollIntoView({
                  behavior: 'smooth',
                });
              }

              this.fetchPosts({ pageIncrementer: 1 });
            }}
          >
            Next
          </a>
        )}
      </div>
    </div>
  );

  render = ({ search, posts } = this.state) => (
    <div className={`${this.cssNamespace}-search`}>
      <div className={`${this.cssNamespace}-search__input-container`}>
        <input
          ref={'search-input'}
          id={`${this.cssNamespace}-search__input`}
          defaultValue={search}
          placeholder={this.props.placeholder || 'Search posts'}
          onInput={this.handleSearchInputChange}
        />
      </div>
      {this.drawNav({ location: 'top' })}
      {posts !== null && posts.length
        ? posts.map(this.drawPost)
        : this.drawLoading()}
      {this.drawNav({ location: 'bottom' })}
    </div>
  );
}
