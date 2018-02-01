import debounce from 'debounce';

/**
 * Set the height of an HTML element to that of a child element.
 */
export default function fitParentToChild(settings) {
  if (!settings.parentSelector || !settings.childSelector) {
    return;
  }

  const containers = document.querySelectorAll(settings.parentSelector);

  if (!containers) {
    return;
  }

  [...containers].forEach(container => {
    let child = container.querySelector(settings.childSelector);

    if (!child || !container) {
      return;
    }

    const matchHeight = () =>
      (container.style.height = `${child.clientHeight}px`);

    matchHeight();

    window.addEventListener('resize', debounce(matchHeight, 100));
  });
}
