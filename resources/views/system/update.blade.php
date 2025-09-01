<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Update System') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="p-4 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Navigation --}}
            <nav class="flex gap-4 mb-6 text-sm font-medium">
                <a data-target="git" class="text-gray-600 cursor-pointer nav-tab hover:text-blue-600">Git Pull</a>
                <a data-target="composer" class="text-gray-600 cursor-pointer nav-tab hover:text-blue-600">Composer
                    Install</a>
                <a data-target="migrate" class="text-gray-600 cursor-pointer nav-tab hover:text-blue-600">Migrate</a>
            </nav>

            {{-- Git Pull Section --}}
            <section id="git" class="active">
                <h3 class="mb-2 text-lg font-semibold">📥 Git Pull</h3>
                <button id="gitPullBtn" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Run Git
                    Pull</button>
                <div id="gitLog" class="p-4 mt-4 text-sm text-gray-700 bg-white border rounded shadow">Status:
                    Waiting...</div>
            </section>

            {{-- Composer Install Section --}}
            <section id="composer" class="hidden">
                <h3 class="mb-2 text-lg font-semibold">📦 Composer Install</h3>
                <button id="composerBtn" class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">Run
                    Composer Install</button>
                <div id="composerLog" class="p-4 mt-4 text-sm text-gray-700 bg-white border rounded shadow">Status:
                    Waiting...</div>
            </section>

            {{-- Migrate Section --}}
            <section id="migrate" class="hidden">
                <h3 class="mb-2 text-lg font-semibold">🗃️ Database Migration</h3>
                <button id="migrateBtn" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Run
                    Migrate</button>
                <div id="migrateLog" class="p-4 mt-4 text-sm text-gray-700 bg-white border rounded shadow">Status:
                    Waiting...</div>
            </section>

            {{-- Script --}}
            <script>
                // Navigation logic
                $('nav a').on('click', function() {
                    $('nav a').removeClass('text-blue-600 font-bold');
                    $(this).addClass('text-blue-600 font-bold');

                    const target = $(this).data('target');
                    $('section').addClass('hidden').removeClass('active');
                    $('#' + target).removeClass('hidden').addClass('active');
                });

                // Git Pull
                $('#gitPullBtn').on('click', function() {
                    $('#gitLog').text('⏳ Running git pull...');
                    $.post('/api/git-pull', function(data) {
                        $('#gitLog').text('✅ Git pull output:\n' + data.output);
                    }).fail(function(xhr) {
                        $('#gitLog').text('❌ Git pull failed:\n' + xhr.responseText);
                    });
                });

                // Composer Install
                $('#composerBtn').on('click', function() {
                    $('#composerLog').text('⏳ Running composer install...');
                    $.post('/api/composer-install', function(data) {
                        $('#composerLog').text('✅ Composer output:\n' + data.output);
                    }).fail(function(xhr) {
                        $('#composerLog').text('❌ Composer failed:\n' + xhr.responseText);
                    });
                });

                // Migrate
                $('#migrateBtn').on('click', function() {
                    $('#migrateLog').text('⏳ Running migration...');
                    $.post('/api/migrate', function(data) {
                        $('#migrateLog').text('✅ Migration output:\n' + data.output);
                    }).fail(function(xhr) {
                        $('#migrateLog').text('❌ Migration failed:\n' + xhr.responseText);
                    });
                });
            </script>
        </div>
    </div>
</x-app-layout>
