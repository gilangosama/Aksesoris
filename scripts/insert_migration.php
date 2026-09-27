<?php

$dbPath = __DIR__ . '/../database/database.sqlite';
if (!file_exists($dbPath)) {
    echo "database file not found: $dbPath\n";
    exit(1);
}

$pdo = new PDO('sqlite:' . $dbPath);
$max = 0;
try {
    $row = $pdo->query("SELECT MAX(batch) as maxb FROM migrations")->fetch(PDO::FETCH_ASSOC);
    $max = isset($row['maxb']) ? (int)$row['maxb'] : 0;
} catch (Exception $e) {
    // migrations table might not exist
}

$stmt = $pdo->prepare('INSERT INTO migrations (migration, batch) VALUES (:migration, :batch)');
$stmt->execute([':migration' => '2026_01_04_000000_create_addresses_table', ':batch' => $max + 1]);

echo "inserted\n";
