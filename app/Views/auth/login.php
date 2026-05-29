<!-- User Authentication Page -->
<!DOCTYPE html>
<html>

<head>

    <title>Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        /* Login page layout and appearance */
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0b0f19;
            font-family: Segoe UI;
            color: #e5e7eb;
        }

        /* Authentication card container */
        .auth-card {
            width: 480px;
            background: #111827;
            border: 1px solid #2d3748;
            border-radius: 24px;
            padding: 48px;
            box-shadow:
                0 25px 50px rgba(0, 0, 0, .35),
                inset 0 1px 0 rgba(255, 255, 255, .02);
        }

        .auth-title {
            font-size: 30px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 6px;
            letter-spacing: -.5px;
        }

        .auth-subtitle {
            font-size: 14px;
            text-align: center;
            color: #94a3b8;
            margin-bottom: 38px;
        }

        /* Floating label input fields */
        .input-group-custom {
            position: relative;
            margin-bottom: 24px;
        }

        .form-control {
            width: 100%;
            height: 72px;

            background: rgba(31, 41, 55, 0.9);

            border: 1.5px solid #334155;
            border-radius: 18px;

            color: #e5e7eb;

            font-size: 15px;
            font-weight: 500;

            padding: 34px 18px 12px 18px;

            transition:
                border-color .25s ease,
                box-shadow .25s ease,
                background .25s ease,
                transform .2s ease;

            backdrop-filter: blur(6px);
        }

        .form-control:focus {
            background: rgba(30, 41, 59, 0.98);

            border-color: #3b82f6;

            box-shadow:
                0 0 0 4px rgba(59, 130, 246, .14),
                0 8px 20px rgba(0, 0, 0, .18);

            color: #fff;

            transform: translateY(-1px);
        }

        .floating-label {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
            transition: .2s ease;
        }

        .form-control:focus+.floating-label,
        .form-control:not(:placeholder-shown)+.floating-label {
            top: 10px;
            transform: translateY(0);
            font-size: 10px;
            letter-spacing: .4px;
            color: #60a5fa;
            font-weight: 600;
        }

        .form-control::placeholder {
            color: transparent;
        }

        .btn-primary {
            background: linear-gradient(135deg,
                    #3b82f6,
                    #2563eb);

            border: none;
            height: 56px;
            border-radius: 16px;

            font-weight: 600;
            font-size: 15px;

            transition: .25s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg,
                    #4f8df7,
                    #2563eb);

            transform: translateY(-2px);

            box-shadow:
                0 12px 20px rgba(37, 99, 235, .22);
        }

        .alert-danger {
            background: #ef4444;
            border: none;
            color: white;
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #22c55e;
            border: none;
            color: white;
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .register-link {
            text-align: center;
            margin-top: 22px;
            color: #94a3b8;
            font-size: 14px;
        }

        .register-link a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 600;
            transition: .2s ease;
        }

        .register-link a:hover {
            color: #93c5fd;
        }

        .password-wrapper {
            position: relative;
        }

        /* Password visibility toggle button */
        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);

            color: #60a5fa;

            cursor: pointer;

            transition: .2s ease;

            z-index: 10;

            opacity: 0;
            visibility: hidden;

            border: none;
            outline: none;
            box-shadow: none;
        }

        .password-toggle.show {
            opacity: 1;
            visibility: visible;
        }

        .password-toggle:hover {
            color: #93c5fd;
            background: transparent !important;
        }

        .password-toggle::before {
            background: transparent !important;
        }

        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        input[type="password"]::-webkit-textfield-decoration-container {
            display: none !important;
        }

    </style>

</head>

<body>

    <!-- Login form container -->
    <div class="auth-card">

        <!-- System title and login instructions -->
        <div class="auth-title">
            Welcome Back
        </div>

        <div class="auth-subtitle">
            Login to Tech Asset Tracker
        </div>

        <!-- Display authentication error messages -->
        <?php if (session()->getFlashdata('error')): ?>

            <div class="alert alert-danger">

                <?= session()->getFlashdata('error') ?>

            </div>

        <?php endif; ?>

        <!-- Display success messages -->
        <?php if (session()->getFlashdata('success')): ?>

            <div class="alert alert-success">

                <?= session()->getFlashdata('success') ?>

            </div>

        <?php endif; ?>

        <!-- User login form -->
        <form method="post" action="/login">

            <!-- CSRF protection token -->
            <?= csrf_field() ?>

            <!-- User email input -->
            <div class="input-group-custom">

                <input
                    type="email"
                    name="login"
                    class="form-control"
                    placeholder=" "
                    required>

                <label class="floating-label">
                    Email Address
                </label>

            </div>

            <!-- User password input -->
            <div class="input-group-custom password-wrapper">

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder=" "
                    required
                    onfocus="showEye('togglePassword')">

                <label class="floating-label">
                    Password
                </label>

                <!-- Password visibility toggle -->
                <i
                    class="fa-solid fa-eye password-toggle"
                    id="togglePassword"
                    onclick="togglePassword('password', this)">
                </i>

            </div>

            <!-- Submit login credentials -->
            <button class="btn btn-primary w-100">

                Login

            </button>

        </form>

    </div>

    <script>

        // Toggle password visibility
        function togglePassword(id, icon)
        {
            const input = document.getElementById(id);

            if (input.type === "password") {

                input.type = "text";

                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");

            } else {

                input.type = "password";

                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // Show password toggle icon when password field gains focus
        function showEye(id)
        {
            document
                .getElementById(id)
                .classList
                .add("show");
        }

    </script>

</body>

</html>