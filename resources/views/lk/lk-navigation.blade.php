<div class="lk-nav">
  <div class="lk-nav-item {{ request()->getPathInfo() == '/lk' ? 'active' : '' }}">
    <div class="lk-nav-item__image">
      <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="22" height="22" rx="11" fill="white" stroke="F6F7F9"/>
        <path d="M4.91016 5H6.13805C6.68619 5 6.96026 5 7.1666 5.14872C7.37294 5.29744 7.45961 5.55745 7.63295 6.07746L8.06167 7.36364" stroke-linecap="round"/>
        <path d="M15.9398 15.2425H8.49503C8.37984 15.2425 8.32225 15.2425 8.27856 15.2376C7.81561 15.1857 7.49847 14.7457 7.59569 14.2902C7.60487 14.2471 7.62308 14.1925 7.6595 14.0833C7.69995 13.9619 7.72016 13.9013 7.74251 13.8478C7.97121 13.2997 8.48861 12.9267 9.08087 12.8831C9.13872 12.8788 9.20266 12.8788 9.33054 12.8788H13.5761" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M13.3251 12.8788H10.9291C9.92121 12.8788 9.41727 12.8788 9.02259 12.6185C8.62791 12.3583 8.42941 11.8951 8.03238 10.9687L7.89937 10.6584C7.26159 9.17019 6.9427 8.42611 7.293 7.89487C7.64329 7.36363 8.45282 7.36363 10.0719 7.36363H14.2326C16.0439 7.36363 16.9496 7.36363 17.2912 7.95226C17.6328 8.5409 17.1834 9.32726 16.2848 10.8999L16.0614 11.2909C15.6186 12.0656 15.3973 12.453 15.0305 12.6659C14.6636 12.8788 14.2175 12.8788 13.3251 12.8788Z" stroke-linecap="round"/>
        <path d="M15.8336 17.2122C15.8336 17.3712 15.7047 17.5 15.5457 17.5C15.3867 17.5 15.2578 17.3712 15.2578 17.2122C15.2578 17.0532 15.3867 16.9243 15.5457 16.9243C15.7047 16.9243 15.8336 17.0532 15.8336 17.2122Z"/>
        <path d="M9.53279 17.2122C9.53279 17.3712 9.4039 17.5 9.24491 17.5C9.08592 17.5 8.95703 17.3712 8.95703 17.2122C8.95703 17.0532 9.08592 16.9243 9.24491 16.9243C9.4039 16.9243 9.53279 17.0532 9.53279 17.2122Z"/>
      </svg>
    </div>
    <div class="lk-nav-item__text">Заказы</div>
    <a href="/lk" class="full-link"></a>
  </div>
  <div class="lk-nav-item {{ request()->getPathInfo() == '/lk/profile' ? 'active' : '' }}">
    <div class="lk-nav-item__image">
      <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="22" height="22" rx="11" fill="white" stroke="F6F7F9"/>
        <path d="M10.9989 11C12.5796 11 13.861 9.65685 13.861 8C13.861 6.34315 12.5796 5 10.9989 5C9.41814 5 8.13672 6.34315 8.13672 8C8.13672 9.65685 9.41814 11 10.9989 11Z"/>
        <path d="M13.8621 12.2H14.0635C14.9295 12.2 15.66 12.876 15.7675 13.7767L15.991 15.6511C16.0764 16.3674 15.5436 17 14.855 17H7.14502C6.4564 17 5.9236 16.3674 6.00901 15.6511L6.23254 13.7767C6.33996 12.876 7.0705 12.2 7.93657 12.2H8.13786" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="lk-nav-item__text">Личные данные</div>
    <a href="/lk/profile" class="full-link"></a>
  </div>
  <form action="{{ route('logout') }}" class="form" method="post">
    @csrf
    <button type="submit" class="logout-submit-btn lk-nav-item__text">
      <div class="lk-nav-item__image">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="22" height="22" rx="11" fill="white" stroke="F6F7F9"/>
          <g clip-path="url(#clip0_673_20224)">
          <path d="M9.6875 6.1875H6.625C6.50897 6.1875 6.39769 6.23359 6.31564 6.31564C6.23359 6.39769 6.1875 6.50897 6.1875 6.625V15.375C6.1875 15.491 6.23359 15.6023 6.31564 15.6844C6.39769 15.7664 6.50897 15.8125 6.625 15.8125H9.6875" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9.6875 11H15.8125" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M13.625 8.8125L15.8125 11L13.625 13.1875" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </g>
          <defs>
          <clipPath id="clip0_673_20224">
          <rect width="14" height="14" fill="white" transform="translate(4 4)"/>
          </clipPath>
          </defs>
        </svg>
      </div>
      <div class="lk-nav-item__text">Выйти</div>      
    </button>
  </form>
</div>