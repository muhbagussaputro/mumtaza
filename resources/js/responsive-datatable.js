// Responsive DataTable Initialization
function initializeResponsiveDataTable(tableId, options = {}) {
    const defaultOptions = {
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        },
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        order: [[0, "asc"]],
        responsive: true,
        scrollX: true,
        autoWidth: false,
        dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2"<"flex-shrink-0"l><"flex-grow"f>>rtip',
        columnDefs: [
            {
                targets: -1,
                orderable: false,
                searchable: false,
                className: "text-center",
                width: "120px"
            }
        ],
        initComplete: function() {
            // Style the search input
            $('.dataTables_filter input').addClass('px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 text-sm w-full sm:w-auto');
            $('.dataTables_filter input').attr('placeholder', 'Cari data...');
            
            // Style the length select
            $('.dataTables_length select').addClass('px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 text-sm');
            
            // Style pagination
            $('.dataTables_paginate .paginate_button').addClass('px-3 py-2 mx-1 text-sm border border-gray-300 rounded hover:bg-gray-50 transition-colors');
            $('.dataTables_paginate .paginate_button.current').addClass('bg-teal-500 text-white border-teal-500 hover:bg-teal-600');
            $('.dataTables_paginate .paginate_button.disabled').addClass('opacity-50 cursor-not-allowed');
            
            // Make table responsive on window resize
            const table = $('#' + tableId).DataTable();
            $(window).on('resize', function() {
                table.columns.adjust().responsive.recalc();
            });
        }
    };

    // Merge options
    const config = { ...defaultOptions, ...options };

    // Initialize DataTable only for desktop view
    if (window.innerWidth >= 640 && $('#' + tableId).length) {
        $('#' + tableId).DataTable(config);
    }
}

// Mobile search functionality
function initializeMobileSearch(tableId) {
    $('#mobile-search-' + tableId).on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#mobile-cards-' + tableId + ' .mobile-card').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
}

// Auto-initialize all responsive datatables
$(document).ready(function() {
    // Initialize all tables with class 'responsive-datatable'
    $('.responsive-datatable').each(function() {
        const tableId = $(this).attr('id');
        if (tableId) {
            initializeResponsiveDataTable(tableId);
            initializeMobileSearch(tableId);
        }
    });
});

// Handle window resize for responsive behavior
$(window).on('resize', function() {
    if (window.innerWidth >= 640) {
        $('.mobile-view').addClass('hidden');
        $('.desktop-view').removeClass('hidden');
    } else {
        $('.desktop-view').addClass('hidden');
        $('.mobile-view').removeClass('hidden');
    }
});

// Export functions for manual initialization
window.ResponsiveDataTable = {
    init: initializeResponsiveDataTable,
    initMobileSearch: initializeMobileSearch
};