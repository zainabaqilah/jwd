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

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
        echo "Sorry, there was an error uploading your file.";
        }
    }

    if (empty($npm) || empty($nik) || empty($nama) || empty($jurusan) || empty($fakultas)) {
        $errorMessage = "Semua bidang wajib diisi";
    } else {
        if (strlen($nik) == 16 && ctype_digit($nik)) {
            $sql = "INSERT INTO data_mahasiswa(npm, nik, nama, jurusan, fakultas, fileToUpload) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ssssss", $npm, $nik, $nama, $jurusan, $fakultas, $target_file);
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

        <form id="myForm" method="post" class="space-y-4" action="create.php" enctype="multipart/form-data">
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

            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
           
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
