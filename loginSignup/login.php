<?php
session_start();
include "koneksi.php";
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./output.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <title>Login</title>
  </head>
  <body>
    <nav class="mt-6 border-gray-200 bg-white dark:bg-gray-900">
      <div
        class="mx-auto flex max-w-screen-xl flex-wrap items-center justify-between p-4"
      >
        <span
          class="self-center whitespace-nowrap text-2xl font-semibold dark:text-white"
          >Corals</span
        >
      </div>
    </nav>
    <div class="grid grid-cols-2 px-18">
      <div class="px-32">
          <h1 class="flex justify-center items-center mt-8 px-10 text-2xl font-bold">Selamat Datang</h1>
          <p class=" flex justify-center mt-2 text-gray-400">
            Silahkan Masuk
          </p>
        
        <?php
          if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);

            $query = mysqli_query($koneksi, "SELECT * FROM user where username='$username' and password='$password'");

            if(mysqli_num_rows($query) > 0) {
                $data = mysqli_fetch_array($query);
                $_SESSION['user'] = $data;
                echo '<script>alert("Selamat datang, '.$data['nama'].'"); location.href = "index.php"; </script>';
            } else {
                echo '<script>alert("Username/password tidak sesuai.");</script>';
            }
          }
        ?>
        <form class="px-8 items-center mt-7" method="post">
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username <span class="text-red-600">*</span></label>
            <div class="flex">
              <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                </svg>
              </span>
              <input type="text" id="username" name="username" class="rounded-none rounded-e-lg border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Zainab" required/>
            </div>
          
          <div class="mt-5 mb-5">
            <label
              for="password"
              class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
              >Password <span class="text-red-600">*</span></label
            >
            <input
              type="password"
              id="password"
              name="password"
              class="dark:shadow-sm-light block w-full rounded-full border border-gray-300 p-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              placeholder="Enter your password"
              required
            />
          </div>

          <button 
            class="bg-black hover:bg-primary-700 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 w-full rounded-full border px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
          >
            Log in
          </button>
          <p class="mt-2 text-sm font-bold">
            Do'nt have an account?
            <a
              href="signup.php"
              class="text-primary-600 dark:text-primary-500 font-medium hover:underline"
              >Sign Up</a
            >
          </p>
        </form>
      </div>
      <div>
        <img src="image/fotologin.jpg" alt="foto-pertama" class="rounded-3xl h-auto max-w-lg"/>
      </div>
    </div>

    
  </body>
</html>
