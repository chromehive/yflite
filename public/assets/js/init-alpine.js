function data() {
  function getThemeFromLocalStorage() {
    // if user already changed the theme, use it
    if (window.localStorage.getItem('dark')) {
      return JSON.parse(window.localStorage.getItem('dark'))
    }

    // else return their preferences
    return (
      !!window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: dark)').matches
    )
  }

  function setThemeToLocalStorage(value) {
    window.localStorage.setItem('dark', value)
  }

  return {
    dark: getThemeFromLocalStorage(),
    toggleTheme() {
      this.dark = !this.dark
      setThemeToLocalStorage(this.dark)
    },
    isSideMenuOpen: false,
    toggleSideMenu() {
      this.isSideMenuOpen = !this.isSideMenuOpen
    },
    closeSideMenu() {
      this.isSideMenuOpen = false
    },
    isDesktopSideMenuOpen: true,
    toggleDesktopSideMenu() {
      this.isDesktopSideMenuOpen = !this.isDesktopSideMenuOpen
    },
    openDesktopSideMenu() {
      this.isDesktopSideMenuOpen = true
    },
    closeDesktopSideMenu() {
      this.isDesktopSideMenuOpen = false
    },
    isFNBarOpen: false,
    toggleFNBar() {
      this.isFNBarOpen = !this.isFNBarOpen
    },
    closeFNBar() {
      this.isFNBarOpen = false
    },
    isDesktopFNBarOpen: true,
    toggleDesktopFNBar() {
      this.isDesktopFNBarOpen = !this.isDesktopFNBarOpen
    },
    closeDesktopFNBar() {
      this.isDesktopFNBarOpen = false
    },
    isNotificationsMenuOpen: false,
    toggleNotificationsMenu() {
      this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
    },
    closeNotificationsMenu() {
      this.isNotificationsMenuOpen = false
    },
    isAddNewMenuOpen: false,
    toggleAddNewMenu() {
      this.isAddNewMenuOpen = !this.isAddNewMenuOpen
    },
    closeAddNewMenu() {
      this.isAddNewMenuOpen = false
    },
    isProfileMenuOpen: false,
    toggleProfileMenu() {
      this.isProfileMenuOpen = !this.isProfileMenuOpen
    },
    closeProfileMenu() {
      this.isProfileMenuOpen = false
    },
    isPagesMenuOpen: false,
    togglePagesMenu() {
      this.isPagesMenuOpen = !this.isPagesMenuOpen
    },
    isMiscMenuInSideBarOpen: false,
    toggleMiscMenuInSideBar() {
      this.isMiscMenuInSideBarOpen = !this.isMiscMenuInSideBarOpen
    },
    isManagePropsMenuOpen: false,
    toggleManagePropsMenu() {
      this.isManagePropsMenuOpen = !this.isManagePropsMenuOpen
    },
    isManageTenantsMenuOpen: false,
    toggleManageTenantsMenu() {
      this.isManageTenantsMenuOpen = !this.isManageTenantsMenuOpen
    },
    isBillingMenuOpen: false,
    toggleBillingMenu() {
      this.isBillingMenuOpen = !this.isBillingMenuOpen
    },
    // Modal
    isModalOpen: false,
    trapCleanup: null,
    openModal() { //modalID
      this.isModalOpen = true
      this.trapCleanup = focusTrap(document.querySelector('.modal'))
    },
    closeModal() { //modalID
      this.isModalOpen = false
      this.trapCleanup()
    },
    isSessionMessageOpen: true,
    closeSessionMessage() {
      this.isSessionMessageOpen = false
    },
    isAnnouncementBannerOpen: true,
    closeAnnouncementBanner() {
      this.isAnnouncementBannerOpen = false
    },
    isAdBannerOpen: true,
    closeAdBanner() {
      this.isAdBannerOpen = false
    },
  }
}
