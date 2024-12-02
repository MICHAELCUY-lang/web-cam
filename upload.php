<?php
$servername = "localhost";
$username = "root"; // Username default untuk XAMPP
$password = "";     // Password default untuk XAMPP
$dbname = "user_photos";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data gambar dari JSON POST
$data = json_decode(file_get_contents("php://input"));
$imageData = $data->image;

// Hapus prefix Base64 untuk mendapatkan data binary
$imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
$imageData = base64_decode($imageData);

// Buat nama file unik
$filename = 'uploads/' . uniqid() . '.jpg';

// Simpan file gambar di folder uploads
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}
file_put_contents($filename, $imageData);

// Simpan path gambar di database
$stmt = $conn->prepare("INSERT INTO photos (photo_path) VALUES (?)");
$stmt->bind_param("s", $filename);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Photo uploaded successfully", "file" => $filename]);
} else {
    echo json_encode(["success" => false, "message" => "Error uploading photo"]);
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
