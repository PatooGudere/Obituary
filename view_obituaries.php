<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "obituary_platform";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$query = "SELECT id, name, date_of_birth, date_of_death, content, author, slug FROM obituaries ORDER BY date_of_death DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Obituaries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #28a745;
            color: white;
        }
        .social-buttons a {
            display: inline-block;
            margin: 5px;
            padding: 8px 12px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .facebook { background: #3b5998; }
        .twitter { background: #1da1f2; }
        .whatsapp { background: #25d366; }
    </style>
</head>
<body>

<div class="container">
    <h2>Obituaries</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Date of Death</th>
                <th>Submitted By</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><a href="obituary.php?slug=<?= htmlspecialchars($row['slug']) ?>">
                        <?= htmlspecialchars($row['name']) ?>
                    </a></td>
                    <td><?= htmlspecialchars($row['date_of_birth']) ?></td>
                    <td><?= htmlspecialchars($row['date_of_death']) ?></td>
                    <td><?= htmlspecialchars($row['author']) ?></td>
                    <td>
                        <div class="social-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=yourwebsite.com/obituary.php?slug=<?= urlencode($row['slug']) ?>" class="facebook" target="_blank">Facebook</a>
                            <a href="https://twitter.com/intent/tweet?url=yourwebsite.com/obituary.php?slug=<?= urlencode($row['slug']) ?>" class="twitter" target="_blank">Twitter</a>
                            <a href="https://api.whatsapp.com/send?text=yourwebsite.com/obituary.php?slug=<?= urlencode($row['slug']) ?>" class="whatsapp" target="_blank">WhatsApp</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No obituaries found.</p>
    <?php endif; ?>

</div>

</body>
</html>
