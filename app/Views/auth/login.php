<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .login-container {
            background: white;
            border: 2px solid #000;
            border-radius: 12px;
            padding: 25px 35px;
            max-width: 340px;
            width: 100%;
        }
        .login-title {
            font-size: 1.6rem;
            font-weight: 700;
            text-align: center;
            color: #333;
            margin-bottom: 3px;
        }
        .login-subtitle {
            text-align: center;
            color: #999;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            color: #555;
            font-size: 0.85rem;
            margin-bottom: 6px;
        }
        .form-control {
            border: 2px solid #ddd;
            border-radius: 5px;
            padding: 8px 10px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .form-control:focus {
            border-color: #666;
            box-shadow: none;
        }
        .btn-signin {
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            width: 100%;
            margin-top: 3px;
            margin-bottom: 15px;
        }
        .btn-signin:hover {
            background-color: #555;
        }
        .register-link {
            text-align: center;
            color: #999;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }
        .register-link a {
            color: #333;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .home-link {
            text-align: center;
            color: #999;
            font-size: 0.85rem;
        }
        .home-link a {
            color: #999;
            text-decoration: none;
        }
        .home-link a:hover {
            color: #666;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Students And Conference Record</h1>
        <p class="login-subtitle">Welcome back — sign in</p>
        
        <form action="<?= base_url('auth/authenticate') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email or Username</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-signin">Sign in</button>
        </form>
        
        <p class="register-link">Don't have an account? <a href="<?= base_url('auth/register') ?>">Register</a></p>
       
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
