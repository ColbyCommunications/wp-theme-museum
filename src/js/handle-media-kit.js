import vex from 'vex-js';

vex.defaultOptions.className = 'vex-theme-default';

export default function() {
  const mediaKitPosts = document.querySelectorAll('.media-kit-post');

  if (!mediaKitPosts) {
    return;
  }

  [].forEach.call(mediaKitPosts, post => {
    post.addEventListener('click', event => {
      event.preventDefault();

      const imageHTML = post.getAttribute('data-image');

      const closeOnEnter = event => {
        if (event.which == 13 || event.keyCode == 13) {
          event.preventDefault();
          vex.closeAll();
        }
      };

      vex.open({
        unsafeContent: imageHTML,
        afterOpen: () => window.addEventListener('keydown', closeOnEnter),
        afterClose: () => window.removeEventListener('keydown', closeOnEnter),
      });
      document.querySelector('.vex').classList.add('active');
    });
  });
}
