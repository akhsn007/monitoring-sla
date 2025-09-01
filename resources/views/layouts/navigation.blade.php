<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Logo PT -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.PNG') }}" alt="Logo PT" class="block w-auto h-9">
                    </a>
                </div>



                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('log-entry.index')" :active="request()->routeIs('log-entry.index')">
                        Log Entry
                    </x-nav-link>
                    <x-nav-link :href="route('client-data')" :active="request()->routeIs('client-data')">
                        Client Data
                    </x-nav-link>
                    <x-nav-link :href="route('monthly-sla')" :active="request()->routeIs('monthly-sla')">
                        Monthly SLA
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('log-viewer.index')">
                            {{ __('Log Viewer') }}
                        </x-dropdown-link>

                        <!-- Update System Modal Trigger -->
                        <x-dropdown-link href="#"
                            onclick="event.preventDefault(); document.getElementById('updateSystemModal').classList.remove('hidden');">
                            {{ __('Update System') }}
                        </x-dropdown-link>


                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Current Date and Time Zone (Realtime) -->
            <div class="flex items-center px-4 text-sm text-gray-600" id="datetime">
                {{ now()->format('Y-m-d H:i:s') }} ({{ config('app.timezone') }})
            </div>
            <script>
                function updateDateTime() {
                    const dt = new Date();
                    const pad = n => n.toString().padStart(2, '0');
                    const formatted =
                        `${dt.getFullYear()}-${pad(dt.getMonth()+1)}-${pad(dt.getDate())} ${pad(dt.getHours())}:${pad(dt.getMinutes())}:${pad(dt.getSeconds())}`;
                    document.getElementById('datetime').innerHTML = `${formatted} ({{ config('app.timezone') }})`;
                }
                setInterval(updateDateTime, 1000);
                updateDateTime();
            </script>

            <!-- Hamburger (mobile menu) -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Update System Modal -->
    <div id="updateSystemModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="max-w-md p-6 bg-white rounded-lg shadow-lg w-25">
            <h2 class="mb-4 text-lg font-semibold">Update System</h2>
            <p class="mb-4 text-gray-700">Are you sure you want to update the system? This will pull
                the latest code and run migrations.</p>
            <form method="GET" action="{{ route('system.update') }}">
                @csrf
                <div class="flex justify-end space-x-2">
                    <button type="button"
                        onclick="document.getElementById('updateSystemModal').classList.add('hidden')"
                        class="px-4 py-2 m-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 m-2 text-white bg-blue-600 rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Responsive Navigation Menu (Mobile) -->
    <div>
