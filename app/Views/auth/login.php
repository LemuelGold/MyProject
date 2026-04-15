<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; }
        .login-card { border: 2px solid #000; border-radius: 12px; max-width: 340px; }
        .form-control { border: 2px solid #ddd; background-color: #f0f0f0; font-size: 0.9rem; }
        .form-control:focus { border-color: #666; box-shadow: none; background-color: white; }
        .btn-signin { background-color: #333; font-size: 0.95rem; }
        .btn-signin:hover { background-color: #555; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="login-card bg-white p-4 w-100 mx-3">
        <h1 class="fs-5 fw-bold text-center text-dark mb-1">Students And Conference Record</h1>
        <p class="text-center text-secondary mb-4" style="font-size:0.85rem;">Welcome back — sign in</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2" style="font-size:0.85rem;"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/authenticate') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold text-secondary" style="font-size:0.85rem;">Email or Username</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold text-secondary" style="font-size:0.85rem;">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-signin text-white fw-semibold w-100 mt-1 mb-3">Sign in</button>
        </form>
        <p class="text-center text-secondary mb-0" style="font-size:0.85rem;">
            Don't have an account? <a href="<?= base_url('auth/register') ?>" class="text-dark fw-semibold text-decoration-none">Register</a>
        </p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
