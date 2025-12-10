<?php
// generate_data.php
// -----------------
// Script που διαβάζει τη βάση (PDO) και γράφει το data.json
// Αναλυτικά σχόλια στο κεφάλαιο README.md
//
// ΣΗΜΕΙΩΣΗ: Πρόσεξε να μην αφήσεις credentials σε δημόσιο repo.
// Τροποποίησε τις παρακάτω μεταβλητές για τη σύνδεση στη βάση σου.

require_once __DIR__ . "/assets/mySchoolsConfig.php";
$host = dbServerName;
$db   = dbName;
$user = dbUser;
$pass = dbPwd;
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Σε production περιβάλλον, κάνε logging στο αρχείο και μη βγάζεις ευαίσθητες πληροφορίες στο browser.
    echo "PDO connection failed: " . $e->getMessage();
    exit;
}

// ΠΡΟΣΑΡΜΟΣΕ ΤΟ SQL ΣΤΗΝ ΔΟΜΗ ΤΟΥ ΠΙΝΑΚΑ ΣΟΥ
$sql = "SELECT * FROM mySchools ORDER BY mySchType, mySchDimos";
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Γράψε το JSON στο αρχείο data.json στην ίδια θέση με αυτό το script
file_put_contents(__DIR__ . '/data.json', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo "data.json has been generated with " . count($data) . " records.\n";
