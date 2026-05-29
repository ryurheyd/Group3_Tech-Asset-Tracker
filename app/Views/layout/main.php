<!DOCTYPE html>
<html>

<head>

    <title>Tech Asset Tracker</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome Icons -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap JavaScript Bundle -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

    <style>
        /* Global application styling */
        body {
            background: #0f172a;
            color: #e5e7eb;
            font-family: system-ui;
        }

        /* Sidebar navigation */
        .sidebar {
            height: 100vh;
            background: #111827;
            color: #e5e7eb;
            padding: 12px;
            border-right: 1px solid #1f2937;
        }

        .sidebar h4 {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #e5e7eb;
            display: block;
            padding: 10px;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 6px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #1f2937;
        }

        .sidebar a.active {
            background: #1f2937;
        }

        /* Main content area */
        .content-area {
            background: #ffffff;
            color: #1e293b;
            min-height: 100vh;
        }

        .table {
            color: #1e293b;
        }

        .table-dark {
            background: #1f2937;
        }

        /* System buttons */
        .btn {
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-primary {
            background: #3b82f6;
            border: none;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-danger {
            background: #ef4444;
            border: none;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-success {
            background: #22c55e;
            border: none;
        }

        .btn-success:hover {
            background: #16a34a;
        }

        /* Card components */
        .card {
            border: none;
            border-radius: 10px;
        }

        /* Modal styling */
        .modal-content {
            background: #111827;
            color: #e5e7eb;
            border-radius: 10px;
            border: 1px solid #1f2937;
        }

        /* Form controls */
        .form-control,
        .form-select {
            background: #1f2933;
            border: 1px solid #2d3748;
            color: #e5e7eb;
        }

        .form-control:focus,
        .form-select:focus {
            background: #1f2933;
            border-color: #3b82f6;
            box-shadow: none;
            color: #e5e7eb;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* System footer */
        .footer {
            text-align: center;
            margin-top: 60px;
            color: #94a3b8;
            font-size: 14px;
        }

        /* Success and error alerts */
        .alert-success {
            background: #22c55e;
            border: none;
            color: white;
        }

        .alert-danger {
            background: #ef4444;
            border: none;
            color: white;
        }

        .btn-close {
            filter: invert(1);
            opacity: 1;
        }

        .btn-close:hover {
            filter: invert(1) brightness(0.7);
        }

        /* Custom scrollbar */

        body::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        body::-webkit-scrollbar-track {
            background: #0f172a;
        }

        body::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        body::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        /* Modal animation */

        .modal.fade .modal-dialog {
            transform: scale(.95);
            transition: all .2s ease;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
        }
    </style>

</head>

<body>

    <!-- Main application container -->
    <div class="container-fluid">

        <div class="row">

            <?php

            // Determine current page and user role

            $current = uri_string();

            $role_id = (int) session()->get('role_id');

            $roleName = match ($role_id) {

                1 => 'Admin',

                2 => 'Staff',

                3 => 'Technician',

                default => 'User'
            };

            ?>

            <!-- Sidebar navigation menu -->
            <div class="col-2 sidebar">

                <h4>Tech Asset Tracker</h4>

                <hr>

                <!-- Dashboard navigation link -->
                <a href="/dashboard"
                    class="<?= $current == 'dashboard' ? 'active' : '' ?>">

                    <i class="bi bi-grid-1x2-fill me-2"></i>

                    Dashboard

                </a>

                <!-- Asset Management navigation link -->
                <a href="/assets"
                    class="<?= $current == 'assets' ? 'active' : '' ?>">

                    <i class="bi bi-box-seam-fill me-2"></i>

                    Assets

                </a>

                <!-- Administrator-only navigation -->
                <?php if ($role_id == 1): ?>

                    <a href="/users"
                        class="<?= $current == 'users' ? 'active' : '' ?>">

                        <i class="bi bi-people-fill me-2"></i>

                        Users

                    </a>

                <?php endif; ?>

                <!-- User logout -->
                <a href="/logout">

                    <i class="bi bi-box-arrow-right me-2"></i>

                    Logout

                </a>

            </div>

            <!-- Main content section -->
            <div class="col-10 content-area p-4">

                <!-- Display success notifications -->
                <?php if (session()->getFlashdata('success')): ?>

                    <div class="alert alert-success alert-dismissible fade show">

                        <i class="bi bi-check-circle-fill me-2"></i>

                        <?= session()->getFlashdata('success') ?>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                        </button>

                    </div>

                <?php endif; ?>

                <!-- Display error notifications -->
                <?php if (session()->getFlashdata('error')): ?>

                    <div class="alert alert-danger alert-dismissible fade show">

                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                        <?= session()->getFlashdata('error') ?>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                        </button>

                    </div>

                <?php endif; ?>

                <!-- Display authenticated user information -->
                <h3 class="text-dark mb-4 fw-bold">

                    Welcome,
                    <?= esc(session()->get('name')) ?>

                    (<?= $roleName ?>)

                </h3>

                <!-- Dynamic page content -->
                <?= $this->renderSection('content') ?>

                <!-- System footer -->
                <div class="footer">

                    <hr>

                    <p class="mb-0 fw-semibold">
                        Tech Asset Tracker System
                    </p>

                    <p class="mb-0 small text-muted">
                        Developed and Maintained by Group 3
                    </p>

                    <p class="mb-0 small text-muted">
                        © <?= date('Y') ?> All Rights Reserved
                    </p>

                </div>

            </div>

        </div>

    </div>

</body>

</html>