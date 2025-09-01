{{-- resources/views/log-entry/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Daftar Log Gangguan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="p-4 mb-4 text-green-800 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <nav>
                <a data-target="git">Git Pull</a>
                <a data-target="composer">Composer Install</a>
                <a data-target="migrate">Migrate</a>
            </nav>

            <section id="git" class="active">
                <h2>📥 Git Pull</h2>
                <button id="gitPullBtn">Run Git Pull</button>
                <div id="gitLog">Status: Waiting...</div>
            </section>

            <section id="composer">
                <h2>📦 Composer Install</h2>
                <button id="composerBtn">Run Composer Install</button>
                <div id="composerLog">Status: Waiting...</div>
            </section>

            <section id="migrate">
                <h2>🗃️ Database Migration</h2>
                <button id="migrateBtn">Run Migrate</button>
                <div id="migrateLog">Status: Waiting...</div>
            </section>

            <script>
                // Navigation logic
                $('nav a').on('click', function() {
                    $('nav a').removeClass('active');
                    $(this).addClass('active');
                    const target = $(this).data('target');
                    $('section').removeClass('active');
                    $('#' + target).addClass('active');
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
