export default class MenuHandler {
  constructor(settings) {
    this.settings = settings;
    this.handleParentHover = this.handleParentHover.bind(this);

    const parents = document.querySelectorAll(settings.parentSelector);
    [...parents].forEach(this.handleParentHover);
  }

  handleParentHover(parent) {
    if (window.innerWidth <= 768) {
      return;
    }

    const child = parent.querySelector(this.settings.submenuSelector);

    if (!child) {
      return;
    }

    const toggle = () => {
      child.classList.toggle('visible');
      child.style['width'] = `${parent.clientWidth + 24}px`;
      child.style['min-width'] = '200px';
    };

    parent.addEventListener('mouseenter', toggle);
    parent.addEventListener('mouseleave', toggle);
  }
}
