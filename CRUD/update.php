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
$nik = "";
$nama = "";
$jurusan = "";
$fakultas = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the data of the client

    if (!isset($_GET["npm"])) {
        header("location: index.php");
        exit;
    }
    
    $npm = $_GET["npm"];

    // Fetch the selected client's row from the database table
    $sql = "SELECT * FROM data_mahasiswa WHERE npm='$npm'";
    $result = $connection->query($sql);

    if (!$result) {
        $errorMessage = "Invalid query: " . $connection->error;
    } else {
        $row = $result->fetch_assoc();
        if (!$row) {
            header("location: index.php");
            exit;
        }

        $nik = $row["nik"];
        $nama = $row["nama"];
        $jurusan = $row["jurusan"];
        $fakultas = $row["fakultas"];
    }
} else {
    // POST method: Update data mahasiswa
    $npm = $_POST["npm"];
    $nik = $_POST["nik"];
    $nama = $_POST["nama"];
    $jurusan = $_POST["jurusan"];
    $fakultas = $_POST["fakultas"];

    do {
        if (empty($npm) || empty($nik) || empty($nama) || empty($jurusan) || empty($fakultas)) {
            $errorMessage = "Semua bidang wajib diisi";
            break;
        }

        $sql = "UPDATE data_mahasiswa SET nama='$nama', nik='$nik', jurusan='$jurusan', fakultas='$fakultas' WHERE npm='$npm'";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        
        $successMessage = "Data Mahasiswa Berhasil di Update!";

        // Redirect back to index.php with success message
        header("location: index.php?successMessage=" . urlencode($successMessage));
        exit;

        break;
    } while (true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <title>Document</title>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a class="text-xl font-semibold text-blue-600" href="#"> ‧₊˚ ☁️⋅♡ CRUD - Create Read Update Delete</a>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold text-center mb-4">Edit Data Mahasiswa</h1>

        <?php if (!empty($errorMessage)): ?>
            <div class="bg-red-500 text-white p-3 mb-4 rounded">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="npm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NPM</label>
                    <input type="text" name="npm" value="<?= htmlspecialchars($npm) ?>" id="npm" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="NPM" readonly />
                </div>
                <div>
                    <label for="nik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                    <input type="text" name="nik" value="<?= htmlspecialchars($nik) ?>" id="nik" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="NIK" readonly />
                </div>
                <div>
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                    <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama" required />
                </div>
                <div>
                    <label for="jurusan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan</label>
                    <input type="text" name="jurusan" value="<?= htmlspecialchars($jurusan) ?>" id="jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Jurusan" required />
                </div>  
                <div>
                    <label for="fakultas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fakultas</label>
                    <input type="text" name="fakultas" value="<?= htmlspecialchars($fakultas) ?>" id="fakultas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fakultas" required />
                </div>

                <div class="items-center justify-between">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Edit
                    </button>
                    <a href="index.php" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
