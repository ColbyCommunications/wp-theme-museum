/**
 * Fades out the panel initially showing on the front page.
 */
export const frontPageSplash = () => {
  const splash = document.querySelector('.front-page-splash');

  if (!splash) {
    document.body.style.opacity = '1';
    return;
  }

  document.body.style.opacity = '1';
  window.setTimeout(() => fadeOut(splash), 4000);
};

const fadeOut = splash => {
  splash.classList.add('unloading');

  window.setTimeout(() => {
    splash.classList.add('unloaded');
  }, 1000);
};
