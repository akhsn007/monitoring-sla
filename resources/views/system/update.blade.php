<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Update System') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Success Notification --}}
            @if (session('success'))
                <div class="p-4 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Unified Actions --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                {{-- Git Pull --}}
                <div class="p-4 bg-white border rounded shadow">
                    <h3 class="mb-2 text-lg font-semibold">📥 Git Pull</h3>
                    <button id="gitPullBtn" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Run Git
                        Pull</button>
                    <div id="gitLog" class="mt-4 text-sm text-gray-700 whitespace-pre-line">Status: Waiting...</div>
                </div>

                {{-- Composer Install --}}
                <div class="p-4 bg-white border rounded shadow">
                    <h3 class="mb-2 text-lg font-semibold">📦 Composer Install</h3>
                    <button id="composerBtn" class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">Run
                        Composer Install</button>
                    <div id="composerLog" class="mt-4 text-sm text-gray-700 whitespace-pre-line">
                        Status: Waiting...
                    </div>


                </div>

                {{-- Migrate --}}
                <div class="p-4 bg-white border rounded shadow">
                    <h3 class="mb-2 text-lg font-semibold">🗃️ Database Migration</h3>
                    <button id="migrateBtn" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Run
                        Migrate</button>
                    <div id="migrateLog" class="mt-4 text-sm text-gray-700 whitespace-pre-line">Status: Waiting...</div>
                    Status: Waiting...
                </div>
            </div>

            {{-- Script --}}
            <script>
                // Git Pull
                $('#gitPullBtn').on('click', function() {
                    $('#gitLog').text('⏳ Running git stash...');
                    $.get('{{ route('git.stash') }}', function(data) {
                        $('#gitLog').text('✅ Git stash output:\n' + data.output);
                    }).fail(function(xhr) {
                        $('#gitLog').text('❌ Git stash failed:\n' + xhr.responseText);
                    });

                    $('#gitLog').append('\n⏳ Running git pull...');
                    $.get('{{ route('git.pull') }}', function(data) {
                        $('#gitLog').append('<br>\n✅ Git pull output:\n' + data.output);
                    }).fail(function(xhr) {
                        $('#gitLog').append('\n❌ Git pull failed:\n' + xhr.responseText);
                    });
                });

                // Composer Install
                $('#composerBtn').on('click', function() {
                    $('#composerLog').text('⏳ Running composer install...');
                    $.get('{{ route('composer.install') }}', function(data) {
                        $('#composerLog').text('✅ Composer output:\n' + data.output);
                    }).fail(function(xhr) {
                        $('#composerLog').text('❌ Composer failed:\n' + xhr.responseText);
                    });
                });

                // Migrate
                $('#migrateBtn').on('click', function() {
                    $('#migrateLog').text('⏳ Running migration...');
                    $.get('{{ route('migrate') }}', function(data) {
                        $('#migrateLog').text('✅ Migration output:\n' + data.output);
                    }).fail(function(xhr) {
                        $('#migrateLog').text('❌ Migration failed:\n' + xhr.responseText);
                    });
                });
            </script>
        </div>
    </div>
</x-app-layout>
