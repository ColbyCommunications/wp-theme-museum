import React from 'react';
import styled from 'styled-components';

const StyledInput = styled.input`
  cursor: pointer;
  padding: 0.375rem;
  position: absolute;
  top: -0.2em;
  left: -0.25em;
  background: transparent;
  border: 0;
  color: #353535;
  color: var(--primary, #353535);

  &:focus {
    background: rgba(white, 0.3);
  }
`;

export const SearchInput = ({ searchTerm, onChange }) => (
  <StyledInput
    style={{ cursor: 'pointer' }}
    value={searchTerm}
    onChange={onChange}
    type="search"
  />
);
