import React from 'react';
import styled from 'styled-components';

const StyledSearchButton = styled.button`
  color: #353535;
  color: var(--black, #353535);
  font-weight: 400;
  text-transform: uppercase;
  font-size: 1.122em;
  opacity: ${({ searching }) => (searching ? '0' : '1')};
  pointer-events: ${({ searching }) => (searching ? 'none' : 'auto')};
`;

export const SearchButton = ({ searching }) => (
  <StyledSearchButton searching={searching} tabIndex="-1">
    Search
  </StyledSearchButton>
);
