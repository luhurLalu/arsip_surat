<?php
// migrate_uploads.php
// Script untuk memindahkan file lama ke folder suratmasuk/suratkeluar sesuai data di database

// Konfigurasi database sesuai permintaan user
$db = new mysqli('localhost', 'root', '', 'pengarsipan');
if ($db->connect_errno) {
    die('Koneksi database gagal: ' . $db->connect_error . "\n");
}


function migrateFiles($db, $table, $folder, $fileColumn) {
    $res = $db->query("SELECT `$fileColumn` FROM $table WHERE `$fileColumn` IS NOT NULL AND `$fileColumn` != ''");
    if (!$res) {
        echo "Query gagal untuk tabel $table: " . $db->error . "\n";
        return;
    }
    while ($row = $res->fetch_assoc()) {
        $file = $row[$fileColumn];
        $src = __DIR__ . "/public/uploads/$file";
        $dst = __DIR__ . "/public/uploads/$folder/$file";
        if (file_exists($src)) {
            if (!file_exists(dirname($dst))) {
                mkdir(dirname($dst), 0777, true);
            }
            if (rename($src, $dst)) {
                echo "$table: $file dipindahkan ke $folder.\n";
            } else {
                echo "$table: Gagal memindahkan $file.\n";
            }
        } else {
            // echo "$table: $file tidak ditemukan di uploads/.\n";
        }
    }
}

migrateFiles($db, 'surat_masuk', 'suratmasuk', 'file_surat');
migrateFiles($db, 'surat_keluar', 'suratkeluar', 'file_surat');

echo "Selesai.\n";
