<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="p-4 mb-6 rounded-lg alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4">
                <!-- Stats Cards -->
                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-teal-100 dark:bg-teal-900">
                                <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Students</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">1,234</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Programs</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">24</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed Evaluations
                                </p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">1,245</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Upcoming Sessions</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">12</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Recent Activities -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Activities</h3>
                        </div>
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Student</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Activity</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-300">
                                            Time</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 w-10 h-10">
                                                        <div
                                                            class="flex items-center justify-center w-10 h-10 rounded-full bg-teal-100 dark:bg-teal-900">
                                                            <span
                                                                class="font-medium text-teal-800 dark:text-teal-200">S{{ $i }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            Student {{ $i }}</div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">Program
                                                            {{ $i }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">Completed evaluation
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">Surah
                                                    {{ $i }}:1-10</div>
                                            </td>
                                            <td
                                                class="px-6 py-4 text-sm text-right text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $i }}h ago
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @if (auth()->user()->role === 'admin')
                                    <a href="#"
                                        class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg class="w-5 h-5 mr-3 text-teal-600 dark:text-teal-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add New User
                                    </a>
                                    <a href="#"
                                        class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg class="w-5 h-5 mr-3 text-teal-600 dark:text-teal-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                        Manage Programs
                                    </a>
                                @endif

                                @if (in_array(auth()->user()->role, ['teacher', 'admin']))
                                    <a href="#"
                                        class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg class="w-5 h-5 mr-3 text-teal-600 dark:text-teal-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        Create Evaluation
                                    </a>
                                    <a href="#"
                                        class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg class="w-5 h-5 mr-3 text-teal-600 dark:text-teal-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                        View Students
                                    </a>
                                @endif

                                @if (auth()->user()->role === 'student')
                                    <a href="#"
                                        class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg class="w-5 h-5 mr-3 text-teal-600 dark:text-teal-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                        View Progress
                                    </a>
                                    <a href="#"
                                        class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg class="w-5 h-5 mr-3 text-teal-600 dark:text-teal-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Schedule Session
                                    </a>
                                @endif

                                <a href="#"
                                    class="flex items-center p-3 text-sm font-medium text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-teal-600 dark:text-teal-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Generate Report
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="mt-6 card">
                        <div class="card-header">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Upcoming Events</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @for ($i = 1; $i <= 3; $i++)
                                    <div class="relative pl-8">
                                        <div
                                            class="absolute left-0 flex items-center justify-center w-6 h-6 rounded-full bg-teal-100 dark:bg-teal-900">
                                            <div class="w-2 h-2 rounded-full bg-teal-600 dark:bg-teal-400"></div>
                                        </div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Evaluation
                                            Session</h4>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Today,
                                            {{ $i }}:00 PM - {{ $i + 1 }}:00 PM</p>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">With Student
                                            {{ $i }}</p>
                                    </div>
                                @endfor
                            </div>
                            <div class="mt-4">
                                <a href="#"
                                    class="text-sm font-medium text-teal-600 hover:text-teal-500 dark:text-teal-400 dark:hover:text-teal-300">
                                    View all events
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
