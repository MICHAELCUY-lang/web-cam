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

// Ambil photo_id dan photo_path dari permintaan POST
$photo_id = $_POST['photo_id'];
$photo_path = $_POST['photo_path'];

// Hapus data foto dari database
$stmt = $conn->prepare("DELETE FROM photos WHERE id = ?");
$stmt->bind_param("i", $photo_id);
$stmt->execute();

// Cek apakah data dihapus dari database
if ($stmt->affected_rows > 0) {
    // Hapus file gambar dari folder uploads
    if (file_exists($photo_path)) {
        unlink($photo_path);
        echo "Photo deleted successfully!";
    } else {
        echo "File not found.";
    }
} else {
    echo "Error: Photo not found in database.";
}

// Tutup koneksi
$stmt->close();
$conn->close();
