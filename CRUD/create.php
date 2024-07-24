<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pelatihan_crud";

$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$npm = "";
$nik ="";
$nama = "";
$jurusan = "";
$fakultas = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $npm = $_POST["npm"];
    $nik = $_POST["nik"];
    $nama = $_POST["nama"];
    $jurusan = $_POST["jurusan"];
    $fakultas = $_POST["fakultas"];

    if (empty($npm) || empty($nik) || empty($nama) || empty($jurusan) || empty($fakultas)) {
        $errorMessage = "Semua bidang wajib diisi";
    } else {
        if (strlen($nik) == 16 && ctype_digit($nik)) {
        $sql = "INSERT INTO data_mahasiswa(npm, nik, nama, jurusan, fakultas) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssss", $npm, $nik, $nama, $jurusan, $fakultas);
        }
        if ($stmt->execute()) {
            $successMessage = "Data Mahasiswa Berhasil Ditambahkan";
            $npm = "";
            $nik ="";
            $nama = "";
            $jurusan = "";
            $fakultas = "";
            header("Location: index.php");
            exit;
        } else {
            if ($connection->errno == 1062) { // Duplicate entry error code
                $errorMessage = "NPM sudah ada, masukkan NPM yang berbeda.";
            } else {
                $errorMessage = "Query Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Tambah Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a class="text-xl font-semibold text-blue-600" href="#"> ‧₊˚ ☁️⋅♡ CRUD - Create Read Update Delete</a>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold text-center mb-4">Tambah Data Mahasiswa</h1>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='bg-red-500 text-white p-4 mb-4 rounded'>
                <strong>$errorMessage</strong>
            </div>
            ";
        }

        if (!empty($successMessage)) {
            echo "
            <div class='bg-green-500 text-white p-4 mb-4 rounded'>
                <strong>$successMessage</strong>
            </div>
            ";
        }
        ?>

        <form id="myForm" method="post" action="" class="space-y-4">
            <div>
                <label for="npm" class="block text-sm font-medium text-gray-700">NPM</label>
                <input type="text" id="npm" name="npm" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="NPM" required />
            </div>
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" maxlength="16" minlength="16" id="nik" name="nik" pattern="\d{16}" title="NIK harus terdiri dari 16 digit" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="NIK" required />
            </div>
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Nama" required />
            </div>
            <div>
                <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                <input type="text" id="jurusan" name="jurusan" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Jurusan" required />
            </div>
            <div>
                <label for="fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                <input type="text" id="fakultas" name="fakultas" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Fakultas" required />
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" disabled id="submitButton" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Tambah
                </button>
                <a href="index.php" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Batal
                </a>
            </div>
        </form>
    </div>
    <script>
    const form = document.getElementById('myForm');
        const submitButton = document.getElementById('submitButton');
        
        form.addEventListener('input', () => {
            // Check if all required fields are filled
            const isValid = form.checkValidity();
            submitButton.disabled = !isValid;
        });
    </script>
</body>

</html>
