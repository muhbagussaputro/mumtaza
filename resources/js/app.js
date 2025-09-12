import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import 'flowbite';

// Initialize Alpine.js
window.Alpine = Alpine;

// Add persist plugin
Alpine.plugin(persist);

// Initialize store
document.addEventListener('alpine:init', () => {
    // Theme store
    Alpine.store('theme', {
        dark: window.matchMedia('(prefers-color-scheme: dark)').matches,
        
        init() {
            // Check for saved theme preference or fallback to system preference
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                this.dark = true;
            } else {
                document.documentElement.classList.remove('dark');
                this.dark = false;
            }
        },
        
        toggle() {
            this.dark = !this.dark;
            if (this.dark) {
                localStorage.theme = 'dark';
                document.documentElement.classList.add('dark');
            } else {
                localStorage.theme = 'light';
                document.documentElement.classList.remove('dark');
            }
        }
    });
});

// Start Alpine
Alpine.start();

// Initialize tooltips
const initTooltips = () => {
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-tooltip-target]')
    );
    tooltipTriggerList.forEach((tooltipTriggerEl) => {
        return new window.Flowbite.tooltip(tooltipTriggerEl);
    });
};

// Initialize dropdowns
const initDropdowns = () => {
    const dropdowns = [].slice.call(
        document.querySelectorAll('[data-dropdown-toggle]')
    );
    dropdowns.forEach((dropdownToggleEl) => {
        return new window.Flowbite.dropdown(dropdownToggleEl);
    });
};

// Initialize modals
const initModals = () => {
    const modals = [].slice.call(
        document.querySelectorAll('[data-modal-toggle]')
    );
    modals.forEach((modalToggleEl) => {
        return new window.Flowbite.modal(modalToggleEl);
    });
};

// Initialize drawer
const initDrawer = () => {
    const drawerElements = [].slice.call(
        document.querySelectorAll('[data-drawer-toggle]')
    );
    drawerElements.forEach((drawerToggleEl) => {
        return new window.Flowbite.drawer(drawerToggleEl);
    });
};

// Initialize all components when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize all components
    initTooltips();
    initDropdowns();
    initModals();
    initDrawer();

    // Close mobile menu when clicking on a nav link
    document.querySelectorAll('.sidebar-nav a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
                const sidebar = document.querySelector('[x-data]');
                if (sidebar && sidebar.__x.$data.sidebarOpen) {
                    sidebar.__x.$data.sidebarOpen = false;
                }
            }
        });
    });

    // Close mobile menu when route changes
    window.addEventListener('popstate', () => {
        if (window.innerWidth < 1024) {
            const sidebar = document.querySelector('[x-data]');
            if (sidebar && sidebar.__x.$data.sidebarOpen) {
                sidebar.__x.$data.sidebarOpen = false;
            }
        }
    });
});

// Reinitialize components when Livewire updates the DOM
document.addEventListener('livewire:load', () => {
    initTooltips();
    initDropdowns();
    initModals();
    initDrawer();
});

// Export for use in other files
window.initTooltips = initTooltips;
window.initDropdowns = initDropdowns;
window.initModals = initModals;
window.initDrawer = initDrawer;
