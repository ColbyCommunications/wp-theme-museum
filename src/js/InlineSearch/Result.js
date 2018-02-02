import React from 'react';
import styled from 'styled-components';

const StyledResult = styled.li`
  display: block;
  padding-bottom: 0.75em;
  clear: both;

  @media screen and (min-width: 767px) {
    padding-right: 1.5rem;
    padding-left: 1.5rem;
  }

  a {
    font-size: 1em;
    text-transform: none;
  }

  &:last-of-type {
    padding-right: 1.5rem;
  }
`;

export const Result = ({ id, link, title }) =>
  title ? (
    <StyledResult key={id} className="result-item">
      <a
        href={link}
        dangerouslySetInnerHTML={{
          __html: title.rendered
            .replace(' ,', '')
            .replace(' &nbsp;&nbsp;,', ''),
        }}
      />
    </StyledResult>
  ) : null;
