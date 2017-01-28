export default function() {
  const mediaKitPosts = document.querySelectorAll('.media-kit-post');

  if (!mediaKitPosts) {
    return;
  }

  [].forEach.call(mediaKitPosts, post => {
    post.addEventListener('click', event => {
      event.preventDefault();

      const imageHTML = post.getAttribute('data-image');
      vex.open({ unsafeContent: imageHTML });
      document.querySelector('.vex').classList.add('active');
    });
  });
}
