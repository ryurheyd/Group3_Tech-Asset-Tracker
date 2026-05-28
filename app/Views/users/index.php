<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    .table-wrapper {
        overflow-x: auto;
        overflow-y: hidden;
        width: 100%;
        scroll-behavior: smooth;

        scrollbar-width: thin;
        scrollbar-color: #9ca3af #e5e7eb;
    }

    /* CHROME / EDGE / OPERA */

    .table-wrapper::-webkit-scrollbar {
        height: 14px;
    }

    .table-wrapper::-webkit-scrollbar-track {
        background: #e5e7eb;
        border-radius: 20px;
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: #9ca3af;
        border-radius: 20px;
        border: 3px solid #e5e7eb;
    }

    .table-wrapper::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }

    .table-wrapper::-webkit-scrollbar-button:horizontal:start:decrement {
        border-radius: 20px 0 0 20px;
    }

    .table-wrapper::-webkit-scrollbar-button:horizontal:end:increment {
        border-radius: 0 20px 20px 0;
    }

    .table th,
    .table td {
        white-space: nowrap;
        vertical-align: middle;
        text-align: center;
    }

    .badge-admin {
        background: #ef4444;
    }

    .badge-staff {
        background: #3b82f6;
    }

    .badge-technician {
        background: #22c55e;
    }

    .action-btn {
        background: #3b82f6;
        border: 1px solid #3b82f6;
        color: #fff;
        transition: all .25s ease;
    }

    .action-btn:hover {
        background: #ffffff;
        color: #3b82f6;
        border: 1px solid #3b82f6;
    }

    .btn-delete {
        background: #ef4444;
        border: 1px solid #ef4444;
        color: #fff;
        transition: all .25s ease;
    }

    .btn-delete:hover {
        background: #ffffff;
        color: #ef4444;
        border: 1px solid #ef4444;
    }

    .modal-content {
        background: #111827;
        color: #e5e7eb;
        border-radius: 10px;
        border: 1px solid #1f2937;
    }

    .btn-close {
        filter: invert(1);
        opacity: 1;
    }

    .action-group {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .password-toggle {
        position: absolute;
        right: 18px;
        top: 73%;
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

<h2 class="mb-4">

    User Management

</h2>

<!-- ADD USER MODAL -->

<div
    class="modal fade"
    id="addUserModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header justify-content-center">

                <h5 class="modal-title w-100 text-center">

                    Create User

                </h5>

                <button
                    type="button"
                    class="btn-close position-absolute end-0 me-3"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form
                method="post"
                action="/users/store">

                <?= csrf_field() ?>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3 position-relative">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            id="createPassword"
                            name="password"
                            class="form-control pe-5"
                            required
                            onfocus="showEye('toggleCreatePassword')">

                        <i
                            class="fa-solid fa-eye password-toggle"
                            id="toggleCreatePassword"
                            onclick="togglePassword('createPassword', this)">
                        </i>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Role
                        </label>

                        <select
                            name="role_id"
                            class="form-select"
                            required>

                            <option value="1">

                                Admin

                            </option>

                            <option value="2">

                                Staff

                            </option>

                            <option value="3">

                                Technician

                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer justify-content-center">

                    <button class="btn btn-primary w-100">

                        Create User

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <span>

            Registered Users

        </span>

        <button
            class="btn btn-primary btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#addUserModal">

            Add User

        </button>

    </div>

    <div class="card-body">

        <div class="table-wrapper">

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>

                        <th>Full Name</th>

                        <th>Email</th>

                        <th>Role</th>

                        <th>Created</th>

                        <th>Updated</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (isset($users) && count($users) > 0): ?>

                        <?php foreach ($users as $user): ?>

                            <tr>

                                <td>
                                    <?= esc($user['id']) ?>
                                </td>

                                <td>
                                    <?= esc($user['name']) ?>
                                </td>

                                <td>
                                    <?= esc($user['email']) ?>
                                </td>

                                <td>

                                    <?php if ($user['role_id'] == 1): ?>

                                        <span class="badge badge-admin">

                                            Admin

                                        </span>

                                    <?php elseif ($user['role_id'] == 2): ?>

                                        <span class="badge badge-staff">

                                            Staff

                                        </span>

                                    <?php elseif ($user['role_id'] == 3): ?>

                                        <span class="badge badge-technician">

                                            Technician

                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-secondary">

                                            User

                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <?= !empty($user['created_at'])
                                        ? date(
                                            'F d, Y • h:i A',
                                            strtotime($user['created_at'])
                                        )
                                        : 'N/A' ?>

                                </td>

                                <td>

                                    <?=
                                    (
                                        !empty($user['updated_at']) &&
                                        $user['updated_at'] != $user['created_at']
                                    )
                                        ? date(
                                            'F d, Y • h:i A',
                                            strtotime($user['updated_at'])
                                        )
                                        : ''
                                    ?>

                                </td>

                                <td>

                                    <div class="action-group">

                                        <button
                                            class="btn action-btn btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal<?= $user['id'] ?>">

                                            Edit

                                        </button>

                                        <button
                                            class="btn btn-delete btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $user['id'] ?>">

                                            Delete

                                        </button>

                                    </div>

                                </td>

                            </tr>

                            <!-- EDIT MODAL -->

                            <div
                                class="modal fade"
                                id="editModal<?= $user['id'] ?>"
                                tabindex="-1">

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content">

                                        <div class="modal-header justify-content-center">

                                            <h5 class="modal-title w-100 text-center">

                                                Update User Role

                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close position-absolute end-0 me-3"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <form
                                            method="post"
                                            action="/users/update/<?= $user['id'] ?>">

                                            <?= csrf_field() ?>

                                            <div class="modal-body">

                                                <div class="mb-3">

                                                    <label class="form-label">

                                                        Full Name

                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        value="<?= esc($user['name']) ?>"
                                                        readonly>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">

                                                        Role

                                                    </label>

                                                    <select
                                                        name="role_id"
                                                        class="form-select"
                                                        required>

                                                        <option
                                                            value="1"
                                                            <?= $user['role_id'] == 1 ? 'selected' : '' ?>>

                                                            Admin

                                                        </option>

                                                        <option
                                                            value="2"
                                                            <?= $user['role_id'] == 2 ? 'selected' : '' ?>>

                                                            Staff

                                                        </option>

                                                        <option
                                                            value="3"
                                                            <?= $user['role_id'] == 3 ? 'selected' : '' ?>>

                                                            Technician

                                                        </option>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="modal-footer justify-content-center">

                                                <button class="btn btn-primary w-100">

                                                    Update Role

                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                            <!-- DELETE MODAL -->

                            <div
                                class="modal fade"
                                id="deleteModal<?= $user['id'] ?>"
                                tabindex="-1">

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content">

                                        <div class="modal-header border-0 justify-content-center">

                                            <h5 class="modal-title w-100 text-center">

                                                Delete User

                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close position-absolute end-0 me-3"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <div class="modal-body text-center">

                                            <p class="mb-2">

                                                You are about to delete:

                                            </p>

                                            <h5 class="text-danger fw-bold">

                                                <?= esc($user['name']) ?>

                                            </h5>

                                            <p class="text-secondary">

                                                This action cannot be undone.

                                            </p>

                                        </div>

                                        <div class="modal-footer border-0 justify-content-center">

                                            <a
                                                href="/users/delete/<?= $user['id'] ?>"
                                                class="btn btn-danger px-4">

                                                Delete

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="8">

                                No users found

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

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

    function showEye(id)
    {
        document
            .getElementById(id)
            .classList
            .add("show");
    }

</script>

<?= $this->endSection() ?>