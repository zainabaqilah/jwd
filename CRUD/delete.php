<?php
// Pastikan npm dikirimkan melalui parameter GET
if (!isset($_GET['npm'])) {
    // Redirect ke halaman index.php jika npm tidak ada
    header("Location: index.php");
    exit();
}

// Ambil npm dari parameter GET
$npm = $_GET['npm'];

// Lakukan koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "pelatihan_crud";

$connection = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query untuk menghapus data berdasarkan npm
$sql = "DELETE FROM data_mahasiswa WHERE npm = '$npm'";

if ($connection->query($sql) === TRUE) {
    // Jika penghapusan berhasil, redirect kembali ke halaman index.php dengan pesan sukses
    $successMessage = "Data Mahasiswa dengan NPM $npm berhasil dihapus.";
    header("Location: index.php?successMessage=" . urlencode($successMessage));
    exit();
} else {
    // Jika terjadi kesalahan dalam eksekusi query, tampilkan pesan error
    echo "Error: " . $sql . "<br>" . $connection->error;
}

// Tutup koneksi ke database
$connection->close();
?>
