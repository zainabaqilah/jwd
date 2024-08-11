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
    <title>Sign Up</title>
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
          <h1 class="flex justify-center items-center px-10 text-2xl font-bold">Create your account</h1>
          <p class=" flex justify-center mt-2 text-gray-400">
            Let's get started with your 30 days free trial
          </p>
        
          <?php
          if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            
            $duplicate = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' OR email = '$email'");

            if(mysqli_num_rows($duplicate) > 0) {
              echo '<script>alert("Username or Email Has Already Taken");</script>';
            } else {
              // masukkan data ke dalam database
              $query = mysqli_query($koneksi, "INSERT INTO user(nama, username, email, password) values('$name', '$username', '$email', '$password')");
            
              // cek jika queri berjalan maka tampilkan pesan pendaftaran berhasil, silahkan login 
              if($query) {
                
                echo '<script>alert("Sign Up berhasil, silahkan login"); window.location.href="login.php";</script>';
              } else {
                echo '<script>alert("Sign Up gagal, silahkan coba lagi")</script>';
              }
            }
          }
        ?>
        <form class="px-8 items-center mt-7" method="post" action="">
          <div class="mb-5">
            <label
              for="name"
              class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
              >Name <span class="text-red-600">*</span></label
            >
            <input
              type="name"
              id="name"
              name="name"
              class="dark:shadow-sm-light block w-full rounded-full border border-gray-300 p-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              placeholder="Enter your name"
              required
            />
          </div>
          <div class="mb-5">
            <label
              for="username"
              class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
              >Username <span class="text-red-600">*</span></label
            >
            <input
              type="username"
              id="username"
              name="username"
              class="dark:shadow-sm-light block w-full rounded-full border border-gray-300 p-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              placeholder="create your username"
              required
            />
          </div>
          <div class="mb-5">
            <label
              for="email"
              class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
              >Email <span class="text-red-600">*</span></label
            >
            <input
              type="email"
              id="email"
              name="email"
              class="dark:shadow-sm-light block w-full rounded-full border border-gray-300 p-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              placeholder="Enter your email"
              required
            />
          </div>
          <div class="mb-5">
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
          <div class="mb-5 flex items-start">
            <div class="flex h-5 items-center">
              <input
                id="terms"
                type="checkbox"
                value=""
                class="focus:ring-3 h-4 w-4 rounded border border-gray-300 bg-gray-50 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                required
              />
            </div>
            <label
              for="terms"
              class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
              >I agree with to all Them, Privacy Policy and Fees</label
            >
          </div>

          <div class="bg-black rounded-full">
            <button
              type="submit"
              name="submit"
              class="w-full rounded-full border px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
              Sign up
            </button>
          </div>

          <p class="mt-2 text-sm font-bold">
            Already have an account?
            <a
              href="login.php"
              class="text-primary-600 dark:text-primary-500 font-medium hover:underline"
              >Log in</a
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
