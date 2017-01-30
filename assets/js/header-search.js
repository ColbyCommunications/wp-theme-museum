import debounce from 'lodash/debounce';
import React, { Component } from 'react';

const queryCache = {};

export default class HeaderSearch extends Component {
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

      if (
        !event.target.classList.contains('header-search-container') &&
          !event.target.classList.contains('header-search-results') &&
          !event.target.classList.contains('result-item')
      ) {
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
      <li key={key} className="result-item">
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

    if (queryCache[url]) {
      return this.setState({
        results: queryCache[url],
        showingResults: true,
        loading: false,
      });
    }

    fetch(url)
      .then(response => {
        this.totalPages = response.headers.get('X-WP-TotalPages');
        return response.json();
      })
      .then(results => {
        queryCache[url] = results;
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
          tabIndex="-1"
          onClick={event => event.preventDefault()}
        >
          Search
        </a>
        <input
          style={{ cursor: 'pointer' }}
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
          {
            this.state.results.length > 0
              ? this.state.results.map(this.drawResult)
              : <span className="no-results">No results.</span>
          }
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
