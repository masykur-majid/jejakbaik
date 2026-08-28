<?php

/**
 * Script Migrasi: Cluster → Panel
 * 
 * Jalankan dari root proyek Laravel:
 * php migrate_clusters.php --dry-run   (preview saja)
 * php migrate_clusters.php             (eksekusi)
 */

$migrations = [
    [
        'from_dir'       => 'app/Filament/Clusters/Parapoint/Resources',
        'to_dir'         => 'app/Filament/Parapoint/Resources',
        'from_namespace' => 'App\\Filament\\Clusters\\Parapoint\\Resources',
        'to_namespace'   => 'App\\Filament\\Parapoint\\Resources',
        'remove_imports' => [
            'App\\Filament\\Clusters\\Parapoint\\ParapointCluster',
        ],
    ],
    [
        'from_dir'       => 'app/Filament/Clusters/MorningLiteracy/Resources',
        'to_dir'         => 'app/Filament/Reading/Resources',
        'from_namespace' => 'App\\Filament\\Clusters\\MorningLiteracy\\Resources',
        'to_namespace'   => 'App\\Filament\\Reading\\Resources',
        'remove_imports' => [
            'App\\Filament\\Clusters\\MorningLiteracy\\MorningLiteracyCluster',
        ],
    ],
    [
        'from_dir'       => 'app/Filament/Clusters/Academic/Resources',
        'to_dir'         => 'app/Filament/Resources',
        'from_namespace' => 'App\\Filament\\Clusters\\Academic\\Resources',
        'to_namespace'   => 'App\\Filament\\Resources',
        'remove_imports' => [
            'App\\Filament\\Clusters\\Academic\\AcademicCluster',
        ],
    ],
];

// ─── Helper Functions ────────────────────────────────────────────────────────

function copyDirectory(string $src, string $dst): void
{
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }

    $items = scandir($src);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $srcPath = $src . DIRECTORY_SEPARATOR . $item;
        $dstPath = $dst . DIRECTORY_SEPARATOR . $item;

        if (is_dir($srcPath)) {
            copyDirectory($srcPath, $dstPath);
        } else {
            copy($srcPath, $dstPath);
        }
    }
}

function processFile(string $filePath, array $migration): void
{
    $content = file_get_contents($filePath);
    $original = $content;

    // 1. Update namespace deklarasi
    $content = str_replace(
        'namespace ' . $migration['from_namespace'],
        'namespace ' . $migration['to_namespace'],
        $content
    );

    // 2. Update semua use/import statements
    $content = str_replace(
        $migration['from_namespace'],
        $migration['to_namespace'],
        $content
    );

    // 3. Hapus baris use yang merujuk cluster
    foreach ($migration['remove_imports'] as $import) {
        $content = preg_replace(
            '/^use\s+' . preg_quote($import, '/') . '[^;]*;\n?/m',
            '',
            $content
        );
    }

    // 4. Hapus $cluster property (aktif maupun dicomment)
    $content = preg_replace(
        '/^\s*\/\/.*protected static \?string \$cluster\s*=.*;\n?/m',
        '',
        $content
    );
    $content = preg_replace(
        '/^\s*protected static \?string \$cluster\s*=.*;\n?/m',
        '',
        $content
    );

    // 5. Hapus $navigationGroup property
    $content = preg_replace(
        '/^\s*protected static string\|UnitEnum\|null \$navigationGroup\s*=.*;\n?/m',
        '',
        $content
    );

    // 6. Bersihkan multiple blank lines
    $content = preg_replace('/\n{3,}/', "\n\n", $content);

    if ($content !== $original) {
        file_put_contents($filePath, $content);
    }
}

function getAllPhpFiles(string $dir): array
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir)
    );

    foreach ($iterator as $file) {
        if ($file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }

    return $files;
}

// ─── Main ────────────────────────────────────────────────────────────────────

$dryRun = in_array('--dry-run', $argv ?? []);

if ($dryRun) {
    echo "🔍 DRY RUN MODE — tidak ada file yang diubah\n\n";
}

foreach ($migrations as $migration) {
    $from = $migration['from_dir'];
    $to   = $migration['to_dir'];

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📦 Migrasi: {$from}\n";
    echo "       →  {$to}\n\n";

    if (!is_dir($from)) {
        echo "  ⚠️  Folder sumber tidak ditemukan, skip.\n\n";
        continue;
    }

    if (!$dryRun) {
        copyDirectory($from, $to);
        echo "  ✅ Folder berhasil dicopy\n";

        $files = getAllPhpFiles($to);
        echo "  📝 Memproses " . count($files) . " file PHP...\n\n";

        foreach ($files as $file) {
            $relative = str_replace(getcwd() . DIRECTORY_SEPARATOR, '', $file);
            processFile($file, $migration);
            echo "     ✓ {$relative}\n";
        }
    } else {
        $files = getAllPhpFiles($from);
        echo "  📝 Akan memproses " . count($files) . " file PHP:\n";
        foreach ($files as $file) {
            $relative = str_replace(getcwd() . DIRECTORY_SEPARATOR, '', $file);
            echo "     - {$relative}\n";
        }
    }

    echo "\n";
}

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

if (!$dryRun) {
    echo "✅ Migrasi selesai!\n\n";
    echo "Langkah selanjutnya:\n";
    echo "  1. Jalankan: php artisan optimize:clear\n";
    echo "  2. Test aplikasi di /parapoint dan /reading\n";
    echo "  3. Jika aman, hapus folder app/Filament/Clusters/\n";
} else {
    echo "Jalankan tanpa --dry-run untuk eksekusi.\n";
}