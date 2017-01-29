const splashTimeout = 3000;
let start = null;
let splashAnimationFrame;
let splash;

export default function handleSplash() {
  splash = document.querySelector('.front-page-splash');

  const simpleFooter = document.querySelector('.simple-footer');
  const splashText = document.querySelector('.front-page-splash__text');
  const splashBackground = document.querySelector(
    '.front-page-splash__background'
  );
  const header = document.querySelector('.three-column-header');

  if (!splash) {
    return document.querySelector('body').style.opacity = '1';
  }

  document.querySelector('body').style.opacity = '1';

  splashAnimationFrame = window.requestAnimationFrame(fadeOut);
}

function fadeOut(timestamp) {
  start = start ? start : timestamp;
  const progress = timestamp - start;

  if (progress > splashTimeout) {
    splash.style.opacity = '0';
  }

  if (progress > splashTimeout + 1000) {
    splash.style.height = '0';
    splash.style['pointer-events'] = 'none';
    return window.cancelAnimationFrame(splashAnimationFrame);
  }

  splashAnimationFrame = window.requestAnimationFrame(fadeOut);
}
