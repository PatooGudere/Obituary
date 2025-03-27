<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obituary_platform";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $dob = $_POST['date_of_birth'];
    $dod = $_POST['date_of_death'];
    $content = trim($_POST['content']);
    $author = trim($_POST['author']);

    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));

    $originalSlug = $slug;
    $count = 1;
    while (slugExists($conn, $slug)) {
        $slug = $originalSlug . '-' . $count;
        $count++;
    }

    $stmt = $conn->prepare("INSERT INTO obituaries (name, date_of_birth, date_of_death, content, author, slug) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $dob, $dod, $content, $author, $slug);

    if ($stmt->execute()) {
        echo "Obituary submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

function slugExists($conn, $slug) {
    $stmt = $conn->prepare("SELECT id FROM obituaries WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}
?>
