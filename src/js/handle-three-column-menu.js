export default function handleThreeColumnMenu() {
  const menuIcon = document.querySelector('.menu-icon-container');
  const menus = document.querySelectorAll(
    '.three-column-header__collapsible-columns'
  );

  if (!menuIcon && !menus) {
    return;
  }

  menuIcon.addEventListener('click', event => {
    event.preventDefault();

    menuIcon.classList.toggle('active');
    [...menus].forEach(menu => menu.classList.toggle('mobile-active'));
  });
}
