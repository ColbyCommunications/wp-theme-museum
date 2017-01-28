import debounce from 'lodash/debounce';

export default function fixSVGs() {
  const svgs = document.querySelectorAll('svg');

  if (!svgs) {
    return;
  }

  let fixIt = svg => {
    let height = svg.getAttribute('height');
    let width = svg.getAttribute('width');

    if (!height || !width) {
      return;
    }

    width = Number(width.replace('px', ''));
    height = Number(height.replace('px', ''));

    const ratio = height / width;
    const computedHeight = svg.clientWidth * ratio;

    svg.style.height = `${computedHeight}px`;
  };

  let fixThem = () => {
    [].forEach.call(svgs, fixIt);
  };

  fixThem();
  fixThem = debounce(fixThem, 100);
  window.addEventListener('resize', fixThem);
}
