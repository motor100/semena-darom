// Show/hidden user menu 
const contentHeaderUser = document.querySelector('.content-header .user');

contentHeaderUser.onclick = showUserMenu;

function showUserMenu() {
  const contentUserMenu = document.querySelector('.content .user-menu');

  contentUserMenu.classList.toggle('active');

  return false;
}

// Nav menu item set active
const itemLink = document.querySelectorAll('.aside .item-link');

if(typeof(menuItem) != "undefined" && menuItem !== null) {
  itemLink[menuItem].classList.add('active');
}

// Show/hidden submenu dropdown
const navItemItemLinks = document.querySelectorAll('.nav-item-has-children > .item-link');

navItemItemLinks.forEach((item) => {
  item.onclick = function(event) {
    event.preventDefault();
    item.parentElement.classList.toggle('active');
  }
});