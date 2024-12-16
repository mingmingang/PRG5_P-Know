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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
@include('backbone.header', [
    'showMenu' => false,
    'userProfile' => ['name' => 'User', 'role' => 'Guest', 'lastLogin' => ''],
    'menuItems' => [],
    'konfirmasi' => 'Konfirmasi',
    'pesanKonfirmasi' => 'Apakah Anda yakin ingin keluar?',
    'kelolaProgram' => false,
    'showConfirmation' => false,
])

<main>
    <section class="login-background">
        <div class="login-container">
            <div class="login-box">
                <img src="{{ asset('assets/pknow.png') }}" class="pknow" alt="Logo P-KNOW" title="Logo P-KNOW" width="300px">
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
                    <input type="text" class="login-input" name="username" placeholder="Nama Pengguna" required>
                    <input type="password" class="login-input" name="password" placeholder="Kata Sandi" required>

                    @if (session('error'))
                        <p class="error-text">{{ session('error') }}</p>
                    @endif

                    <button type="submit" class="login-button">Masuk</button>
                </form>

                <!-- Modal for Role Selection -->
                <div id="roleModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul id="roleList" class="list-group">
                                    <!-- Roles will be inserted dynamically -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('backbone.footer')

<script>
    // Check if roles exist in session and show modal if true
    @if(session('roles') && session('showRoleSelectionModal'))
        const roles = @json(session('roles'));
        if (roles && roles.length > 0) {
            let roleList = document.getElementById('roleList');
            roles.forEach(role => {
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                listItem.innerHTML = `Login as ${role.name}`;
                listItem.addEventListener('click', function() {
                    // Redirect to role-specific dashboard after selection
                    window.location.href = `/dashboard/${role.id}`;  // Use the role ID for specific routing
                });
                roleList.appendChild(listItem);
            });

            // Show the modal
            $('#roleModal').modal('show');
        }
    @endif
</script>

</body>
</html>
