<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P-KNOW Login</title>
    <link rel="stylesheet" href="{{ asset('css/Login.css') }}">
    <link rel="preconnect" href="https://fonts.googleapi.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>
<body>
@include('backbone.header', [
    'showMenu' => false,  // Menyembunyikan menu pada halaman login
    'userProfile' => ['name' => 'User', 'role' => 'Guest', 'lastLogin' => ''],
    'menuItems' => [],
    'konfirmasi' => 'Konfirmasi',
    'pesanKonfirmasi' => 'Apakah Anda yakin ingin keluar?',
    'kelolaProgram' => false,
    'showConfirmation' => false, // Pastikan variabel ini ada untuk header
])

    <main>
        <section class="login-background">
            <div class="login-container">
                <div class="login-box">
                <img src="{{ asset('assets/pknow.png') }}" class="pknow" alt="Logo P-KNOW" title="Logo P-KNOW">
                    <form method="POST" action="" class="login-form">
                        <input type="text" class="login-input" name="username" placeholder="Nama Pengguna" class="login-input" required>
                        <input type="password" class="login-input" name="password" placeholder="Kata Sandi" class="login-input" required>
                        
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $username = $_POST['username'];
                            $password = $_POST['password'];

                            // Contoh validasi user
                            $userCredentials = [
                                'picpknow' => 'picpknow',
                                'pickk' => 'pickk',
                                'tenagapendidik' => 'tenagapendidik',
                                'tenagakependidikan' => 'tenagakependidikan',
                                'prodi' => 'prodi',
                                'mahasiswa' => 'mahasiswa'
                            ];

                            if (isset($userCredentials[$username]) && $userCredentials[$username] === $password) {
                                echo "<p class='success-text'>Login Berhasil!</p>";
                                // Redirect atau tampilkan modal sesuai role
                            } else {
                                echo "<p class='error-text'>Nama Pengguna atau Kata Sandi salah!</p>";
                            }
                        }
                        ?>

                        <button type="submit" class="login-button">Masuk</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    @include('backbone.footer')  <!-- Menambahkan footer -->
</body>
</html>
