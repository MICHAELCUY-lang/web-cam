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

// Ambil semua photo_path dari database
$sql = "SELECT photo_path FROM photos";
$result = $conn->query($sql);

// Hapus setiap file foto di folder uploads
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $photo_path = $row['photo_path'];
        if (file_exists($photo_path)) {
            unlink($photo_path); // Hapus file gambar
        }
    }
}

// Hapus semua data foto dari database
$sql = "DELETE FROM photos";
$conn->query($sql);

// Tutup koneksi
$conn->close();

// Redirect kembali ke halaman view_photos.php setelah penghapusan
header("Location: view_photos.php");
exit();
?>

