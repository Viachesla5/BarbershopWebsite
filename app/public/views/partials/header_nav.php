<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="/">My Site</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active text-white" href="/">Home</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php if (!empty($_SESSION['is_admin'])): ?>
                    <a href="/admin" class="btn btn-outline-light me-2">Admin Panel</a>
                    <a href="/profile" class="btn btn-outline-light me-2">My Profile</a>
                    <a href="/logout" class="btn btn-danger">Logout</a>
                <?php elseif (!empty($_SESSION['hairdresser_id'])): ?>
                    <a href="/profile" class="btn btn-outline-light me-2">My Profile</a>
                    <a href="/appointments" class="btn btn-outline-light me-2">My Appointments</a>
                    <a href="/logout" class="btn btn-danger">Logout</a>
                <?php elseif (!empty($_SESSION['user_id'])): ?>
                    <a href="/profile" class="btn btn-outline-light me-2">My Profile</a>
                    <a href="/appointments/calendar" class="btn btn-outline-light me-2">Appointments</a>
                    <a href="/hairdressers" class="btn btn-outline-light me-2">View Hairdressers</a>
                    <a href="/logout" class="btn btn-danger">Logout</a>
                <?php else: ?>  
                    <a href="/login" class="btn btn-primary me-2">Login</a>
                    <a href="/register" class="btn btn-outline-primary">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>