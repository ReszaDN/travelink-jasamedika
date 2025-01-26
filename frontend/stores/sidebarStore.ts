import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useSidebarStore = defineStore('sidebar', () => {
    // State
    const isSidebarActive = ref(false);
    const isMobileSidebarOpen = ref(false);
    const isDarkTheme = ref(
        localStorage.getItem('color-theme') === 'dark' ||
        (!localStorage.getItem('color-theme') &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
    );

    // Actions
    const toggleSidebar = () => {
        isSidebarActive.value = !isSidebarActive.value;
    };

    const openMobileSidebar = () => {
        isMobileSidebarOpen.value = true;
        document.body.classList.add('overlay-active');
    };

    const closeMobileSidebar = () => {
        isMobileSidebarOpen.value = false;
        document.body.classList.remove('overlay-active');
    };

    const toggleDropdown = (menuItem: HTMLElement) => {
        const submenu = menuItem.querySelector<HTMLElement>('.sidebar-submenu');
        const isOpen = menuItem.classList.contains('dropdown-open');

        // Close all other dropdowns
        document.querySelectorAll('.sidebar-menu .dropdown').forEach((dropdown) => {
            if (dropdown !== menuItem) {
                dropdown.classList.remove('dropdown-open');
                dropdown.querySelector<HTMLElement>('.sidebar-submenu')!.style.display =
                    'none';
            }
        });

        // Toggle current dropdown
        if (submenu) {
            submenu.style.display = isOpen ? 'none' : 'block';
            menuItem.classList.toggle('dropdown-open');
        }
    };

    const toggleTheme = () => {
        isDarkTheme.value = !isDarkTheme.value;
        const colorMode = useColorMode();
        colorMode.preference = isDarkTheme.value ? 'dark' : 'light';
        // if (isDarkTheme.value) {
        //     document.documentElement.classList.add('dark');
        //     localStorage.setItem('color-theme', 'dark');
        // } else {
        //     document.documentElement.classList.remove('dark');
        //     localStorage.setItem('color-theme', 'light');
        // }
    };

    const highlightActivePage = () => {
        const currentURL = window.location.href;
        document.querySelectorAll('ul#sidebar-menu a').forEach((link) => {
            const parent = link.parentElement;
            if (link.href === currentURL) {
                link.classList.add('active-page');
                if (parent) parent.classList.add('active-page');
                let ancestor = parent;
                while (ancestor && ancestor.tagName !== 'BODY') {
                    if (ancestor.tagName === 'LI') {
                        ancestor.classList.add('show', 'open');
                    }
                    ancestor = ancestor.parentElement;
                }
            }
        });
    };

    return {
        isSidebarActive,
        isMobileSidebarOpen,
        isDarkTheme,
        toggleSidebar,
        openMobileSidebar,
        closeMobileSidebar,
        toggleDropdown,
        toggleTheme,
        highlightActivePage,
    };
});
