
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_photos";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tambahkan tombol "Hapus Semua Foto"
echo "<form action='delete_all_photos.php' method='POST' style='margin-bottom: 20px;'>";
echo "<button type='submit' onclick='return confirm(\"Are you sure you want to delete all photos?\")'>Hapus Semua Foto</button>";
echo "</form>";

// Query untuk mengambil foto dari database
$sql = "SELECT id, photo_path, uploaded_at FROM photos ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

// Tampilkan foto
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='margin-bottom: 20px;'>";
        echo "<p><strong>Photo ID:</strong> " . $row["id"] . "</p>";
        echo "<p><strong>Uploaded At:</strong> " . $row["uploaded_at"] . "</p>";
        echo "<img src='" . $row["photo_path"] . "' alt='User Photo' style='max-width: 300px; max-height: 300px;'/>";
        
        // Tambahkan tombol Hapus untuk setiap foto
        echo "<form action='delete_photo.php' method='POST' style='margin-top: 10px;'>";
        echo "<input type='hidden' name='photo_id' value='" . $row["id"] . "'>";
        echo "<input type='hidden' name='photo_path' value='" . $row["photo_path"] . "'>";
        echo "<button type='submit'>Hapus</button>";
        echo "</form>";
        
        echo "</div>";
    }
} else {
    echo "No photos found in the database.";
}

// Tutup koneksi
$conn->close();
?>
