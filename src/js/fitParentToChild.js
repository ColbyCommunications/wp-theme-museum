/**
 * Set the height of an HTML element to that of a child element.
 */
export default function fitParentToChild({
  parentSelector = '',
  childSelector = '',
}) {
  [...document.querySelectorAll(parentSelector)].forEach(parent => {
    let child = parent.querySelector(childSelector);

    if (!child) {
      return;
    }

    const run = () => {
      parent.style.height = `${child.clientHeight}px`;
    };

    run();

    window.addEventListener('resize', run);
  });
}
