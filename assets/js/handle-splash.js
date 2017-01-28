const splashTimeout = 3000;

export default function handleSplash() {
  const splash = document.querySelector('.front-page-splash');

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
  setTimeout(
    () => {
      splash.style.opacity = '0';
    },

    splashTimeout
  );
  setTimeout(
    () => {
      splash.style.height = '0';
      splash.style['pointer-events'] = 'none';
    },

    splashTimeout + 1000
  );
}
