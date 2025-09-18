@props([
    'id' => 'dataTable',
    'headers' => [],
    'title' => 'Data'
])

<div class="w-full">
    <!-- Table Container -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Mobile Search (Visible only on mobile) -->
        <div class="block sm:hidden p-4 border-b border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
            </div>
            <input type="text" id="mobile-search-{{ $id }}" placeholder="Cari data..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 text-sm">
        </div>

        <!-- Mobile Card View (Hidden on larger screens) -->
        <div class="block sm:hidden divide-y divide-gray-200" id="mobile-cards-{{ $id }}">
            {{ $mobileCards ?? '' }}
        </div>

        <!-- Desktop Table View (Hidden on mobile) -->
        <div class="hidden sm:block">
            <div class="overflow-x-auto">
                <table id="{{ $id }}" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach($headers as $header)
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{ $slot }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom responsive styles */
@media (max-width: 639px) {
    .dataTables_wrapper {
        display: none !important;
    }
}

/* Custom DataTable styles */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin: 0.5rem 0;
}

.dataTables_wrapper .dataTables_filter {
    text-align: left;
}

.dataTables_wrapper .dataTables_filter label {
    font-weight: normal;
    white-space: nowrap;
    text-align: left;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5rem;
    display: inline-block;
    width: auto;
}

/* Responsive table styles */
table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before {
    background-color: #14b8a6;
    color: white;
}

table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td.dtr-control:before {
    background-color: #dc2626;
    color: white;
}

/* Mobile card styles */
.mobile-card {
    transition: all 0.2s ease-in-out;
    padding: 1rem;
}

.mobile-card:hover {
    background-color: #f9fafb;
}

/* Scrollbar styling for table */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* DataTable responsive adjustments */
@media (max-width: 768px) {
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        float: none;
        text-align: left;
        margin-bottom: 1rem;
    }
    
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        float: none;
        text-align: center;
        margin-top: 1rem;
    }
}

/* Table cell responsive behavior */
table.dataTable tbody td {
    word-wrap: break-word;
    word-break: break-word;
    max-width: 200px;
}

table.dataTable tbody td.no-wrap {
    white-space: nowrap;
    max-width: none;
}
</style>