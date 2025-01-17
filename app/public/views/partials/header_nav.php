<nav class="navbar bg-body-tertiary bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">My Site</a>
        <a class="nav-item nav-link active" href="/">Home <span class="sr-only">(current)</span></a>
        
        <div>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="/profile" class="nav-link">Profile</a>
                <a href="/logout" class="btn btn-danger ml-2">Logout</a>
            <?php elseif (!empty($_SESSION['hairdresser_id'])): ?>
                <a href="/profile" class="nav-link">Profile</a>
                <a href="/logout" class="btn btn-danger ml-2">Logout</a>
            <?php else: ?>
                <a href="/login" class="btn btn-primary">Login/Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
