<div class="header" style="height: 60px;">
    <!-- Logo Section -->
    <div class="logo" style="margin: 20px 50px;">
        <img src="{{ asset('assets/logoAstratech.png') }}" alt="Logo ASTRAtech" title="Logo ASTRAtech" width="170px" height="40px">
    </div>

    <!-- Check if the user is logged in -->
    @auth
        <!-- User Profile Section (Visible only when logged in) -->
        <div class="user-profile">
            <!-- User Profile Image -->
            <img src="{{ asset('assets/maskotUser.png') }}" alt="User Profile" />
            <p>{{ auth()->user()->name }} - {{ auth()->user()->role }}</p>
            <p>Last Login: {{ \Carbon\Carbon::parse(auth()->user()->last_login_at)->format('d-m-Y H:i') }}</p>
        </div>
        
        <!-- Dropdown Menu -->
        <div class="dropdown-menu">
            <button onclick="showConfirmation()">Logout</button>
        </div>
    @endauth
</div>

<!-- Konfirmasi Logout Modal -->
@if ($showConfirmation)
    <div class="konfirmasi-modal">
        <div class="modal-content">
            <h3>{{ $konfirmasi }}</h3>
            <p>{{ $pesanKonfirmasi }}</p>
            <button onclick="handleLogout()">Yes</button>
            <button onclick="closeConfirmation()">No</button>
        </div>
    </div>
@endif

<script>
    function showConfirmation() {
        document.querySelector('.konfirmasi-modal').style.display = 'block';
    }

    function closeConfirmation() {
        document.querySelector('.konfirmasi-modal').style.display = 'none';
    }

    function handleLogout() {
        window.location.href = "/logout"; // Direct to logout route
    }
</script>
