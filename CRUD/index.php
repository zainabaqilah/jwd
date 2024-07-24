<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <script>
        function updateCopyrightYear() {
            const currentYear = new Date().getFullYear();
            document.getElementById("copyright-year").textContent = currentYear;
        }

        document.addEventListener("DOMContentLoaded", updateCopyrightYear);
    </script>
    <title>Document</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
        footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a class="text-xl font-semibold text-blue-600" href="#"> ‧₊˚ ☁️⋅♡ CRUD - Create Read Update Delete</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 content">
        <h1 class="text-3xl font-semibold text-gray-800 mt-8 mb-4">Data Mahasiswa Unila</h1>
        <figure class="mb-4">
            <blockquote class="text-gray-600">
                <p>Berisi data yang telah tersimpan di database</p>
            </blockquote>
            <figcaption class="text-sm text-gray-500">
                CRUD <cite title="Source Title">Create Read Update Delete</cite>
            </figcaption>
        </figure>
        <a href="create.php" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition mb-4">
            <i class="fa fa-plus mr-2"></i>
            Tambah data
        </a>

        <?php
        // Check for success message in the URL parameter
        $successMessage = isset($_GET['successMessage']) ? $_GET['successMessage'] : '';

        if (!empty($successMessage)) {
            echo "
            <div id='successMessage' class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4' role='alert'>
                <strong class='font-bold'>$successMessage</strong>
                <span class='absolute top-0 bottom-0 right-0 px-4 py-3'>
                    <svg class='fill-current h-6 w-6 text-green-500' role='button' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><title>Close</title><path d='M14.348 14.849a1 1 0 01-1.414 0L10 11.414l-2.934 2.935a1 1 0 01-1.414-1.414l2.935-2.934-2.935-2.934a1 1 0 111.414-1.414L10 8.586l2.934-2.935a1 1 0 011.414 1.414L11.414 10l2.935 2.934a1 1 0 010 1.415z'/></svg>
                </span>
            </div>
            ";
        }
        ?>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 bg-yellow-200 border-b border-gray-200 text-gray-800 text-left text-sm uppercase font-normal">NPM</th>
                        <th class="px-5 py-3 bg-yellow-200 border-b border-gray-200 text-gray-800 text-left text-sm uppercase font-normal">NIK</th>
                        <th class="px-5 py-3 bg-yellow-200 border-b border-gray-200 text-gray-800 text-left text-sm uppercase font-normal">Nama</th>
                        <th class="px-5 py-3 bg-yellow-200 border-b border-gray-200 text-gray-800 text-left text-sm uppercase font-normal">Jurusan</th>
                        <th class="px-5 py-3 bg-yellow-200 border-b border-gray-200 text-gray-800 text-left text-sm uppercase font-normal">Fakultas</th>
                        <th class="px-5 py-3 bg-yellow-200 border-b border-gray-200 text-gray-800 text-left text-sm uppercase font-normal">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $host = "localhost";
                $user = "root";
                $pass = "";
                $db = "pelatihan_crud";

                // Create connection
                $connection = new mysqli($host, $user, $pass, $db);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read all rows from database table
                $sql = "SELECT * FROM data_mahasiswa";
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td class='px-5 py-3 border-b border-gray-200 bg-white text-sm'>{$row['npm']}</td>
                            <td class='px-5 py-3 border-b border-gray-200 bg-white text-sm'>{$row['nik']}</td>
                            <td class='px-5 py-3 border-b border-gray-200 bg-white text-sm'>{$row['nama']}</td>
                            <td class='px-5 py-3 border-b border-gray-200 bg-white text-sm'>{$row['jurusan']}</td>
                            <td class='px-5 py-3 border-b border-gray-200 bg-white text-sm'>{$row['fakultas']}</td>
                            <td class='px-5 py-3 border-b border-gray-200 bg-white text-sm'>
                                <a href='update.php?npm={$row['npm']}' class='text-indigo-600 hover:text-indigo-900 mr-2'>
                                    <i class='fa fa-pencil'></i>
                                    Edit
                                </a>
                                <a href='delete.php?npm={$row['npm']}' class='text-red-600 hover:text-red-900' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data tersebut?');\">
                                    <i class='fa fa-trash'></i>
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center text-gray-500 py-4'>Tidak ada data</td></tr>";
                }

                // Close connection
                $connection->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // JavaScript to hide success message after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000);
            }
        });
    </script>

    <footer>
        <p>&copy; <span id="copyright-year"></span> zainabaqilah</p>
    </footer>
</body>
</html>
