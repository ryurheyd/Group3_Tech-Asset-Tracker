<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php date_default_timezone_set('Asia/Manila'); ?>

<style>
    .action-btn {
        background: #3b82f6;
        border: 1px solid #3b82f6;
        color: #fff;
        transition: all .25s ease;
        transform: scale(1);
    }

    .action-btn:hover {
        background: #ffffff;
        color: #3b82f6;
        border: 1px solid #3b82f6;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
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
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .modal-body {
        max-height: 680px;
        overflow-y: auto;
    }

    .action-group {
        display: flex;
        gap: 5px;
        justify-content: center;
        align-items: center;
    }

    .table-wrapper {
        overflow-x: auto;
        overflow-y: hidden;
        width: 100%;
        scroll-behavior: smooth;

        padding-bottom: 8px;

        scrollbar-width: thin;
        scrollbar-color: #9ca3af #e5e7eb;
    }

    .table-wrapper::-webkit-scrollbar {
        height: 16px;
    }

    .table-wrapper::-webkit-scrollbar-track {
        background: #e5e7eb;
        border-radius: 999px;
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: #9ca3af;
        border-radius: 999px;
        border: 4px solid #e5e7eb;
    }

    .table-wrapper::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }

    .table-wrapper::-webkit-scrollbar-button {
        display: none;
    }

    .table th,
    .table td {
        white-space: nowrap;
        vertical-align: middle;
        text-align: center;
    }

    .table {
        min-width: max-content;
    }

    .btn-close {
        filter: invert(1);
        opacity: 1;
    }

    .badge-available {
        background: #22c55e;
    }

    .badge-assigned {
        background: #3b82f6;
    }

    .badge-maintenance {
        background: #f59e0b;
    }

    .badge-damaged {
        background: #ef4444;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }
</style>

<!-- Asset Management Page -->
<h2 class="mb-4">

    Asset Management

</h2>

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        Assets

        <!-- Hide asset creation feature from technician accounts -->
        <?php if (session()->get('role_id') != 3): ?>

            <button
                class="btn btn-primary btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#addAssetModal">

                Add Asset

            </button>

        <?php endif; ?>

    </div>

    <div class="card-body">

        <div class="table-wrapper">

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th>Asset Code</th>

                        <th>Asset Name</th>

                        <th>Category</th>

                        <th>Brand</th>

                        <th>Serial Number</th>

                        <th>Status</th>

                        <th>Assigned To</th>

                        <th>Purchase Date</th>

                        <?php if (session()->get('role_id') != 3): ?>

                            <th>Action</th>

                        <?php endif; ?>

                    </tr>

                </thead>

                <tbody>

                    <?php if (count($assets ?? []) > 0): ?>

                        <?php foreach ($assets ?? [] as $row): ?>

                            <tr>

                                <td>
                                    <?= esc($row['asset_code']) ?>
                                </td>

                                <td>
                                    <?= esc($row['asset_name']) ?>
                                </td>

                                <td>
                                    <?= esc($row['category']) ?>
                                </td>

                                <td>
                                    <?= esc($row['brand']) ?>
                                </td>

                                <td>
                                    <?= esc($row['serial_number']) ?>
                                </td>

                                <td>

                                    <?php if ($row['status'] == 'Available'): ?>

                                        <span class="badge badge-available">
                                            Available
                                        </span>

                                    <?php elseif ($row['status'] == 'Assigned'): ?>

                                        <span class="badge badge-assigned">
                                            Assigned
                                        </span>

                                    <?php elseif ($row['status'] == 'Maintenance'): ?>

                                        <span class="badge badge-maintenance">
                                            Maintenance
                                        </span>

                                    <?php else: ?>

                                        <span class="badge badge-damaged">
                                            Damaged
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <?= esc($row['assigned_to']) ?>
                                </td>

                                <td>

                                    <?= !empty($row['created_at'])
                                        ? date(
                                            'F d, Y • h:i A',
                                            strtotime($row['created_at'])
                                        )
                                        : '' ?>

                                </td>

                                <?php if (session()->get('role_id') != 3): ?>

                                    <td>

                                        <div class="action-group">

                                            <button
                                                class="btn action-btn btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal<?= $row['id'] ?>">

                                                Edit

                                            </button>

                                            <button
                                                class="btn btn-delete btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?= $row['id'] ?>">

                                                Delete

                                            </button>

                                        </div>

                                    </td>

                                <?php endif; ?>

                            </tr>

                            <!-- EDIT MODAL -->

                            <div
                                class="modal fade"
                                id="editModal<?= $row['id'] ?>"
                                tabindex="-1">

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content">

                                        <div class="modal-header justify-content-center">

                                            <h5 class="modal-title w-100 text-center">

                                                Edit Asset

                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close position-absolute end-0 me-3"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <form method="post" action="/assets/update/<?= $row['id'] ?>">

                                            <?= csrf_field() ?>

                                            <div class="modal-body">

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Asset Code
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="asset_code"
                                                        class="form-control"
                                                        value="<?= esc($row['asset_code']) ?>"
                                                        readonly>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Asset Name
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="asset_name"
                                                        class="form-control"
                                                        value="<?= esc($row['asset_name']) ?>"
                                                        required>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Category
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="category"
                                                        class="form-control"
                                                        value="<?= esc($row['category']) ?>"
                                                        required>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Brand
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="brand"
                                                        class="form-control"
                                                        value="<?= esc($row['brand']) ?>"
                                                        required>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Serial Number
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="serial_number"
                                                        class="form-control"
                                                        value="<?= esc($row['serial_number']) ?>"
                                                        readonly>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Status
                                                    </label>

                                                    <select
                                                        name="status"
                                                        class="form-select"
                                                        required>

                                                        <option
                                                            value="Available"
                                                            <?= $row['status'] == 'Available' ? 'selected' : '' ?>>

                                                            Available

                                                        </option>

                                                        <option
                                                            value="Assigned"
                                                            <?= $row['status'] == 'Assigned' ? 'selected' : '' ?>>

                                                            Assigned

                                                        </option>

                                                        <option
                                                            value="Maintenance"
                                                            <?= $row['status'] == 'Maintenance' ? 'selected' : '' ?>>

                                                            Maintenance

                                                        </option>

                                                        <option
                                                            value="Damaged"
                                                            <?= $row['status'] == 'Damaged' ? 'selected' : '' ?>>

                                                            Damaged

                                                        </option>

                                                    </select>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Assigned To
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="assigned_to"
                                                        class="form-control"
                                                        value="<?= esc($row['assigned_to']) ?>">

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">

                                                        Purchase Date

                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        value="<?= date('F d, Y', strtotime($row['purchase_date'])) ?>"
                                                        readonly
                                                        readonly>

                                                    <input
                                                        type="hidden"
                                                        name="purchase_date"
                                                        value="<?= date('F d, Y', strtotime($row['purchase_date'])) ?>">

                                                </div>

                                            </div>

                                            <div class="modal-footer justify-content-center">

                                                <button class="btn btn-primary w-100">

                                                    Update Asset

                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                            <!-- DELETE MODAL -->

                            <div
                                class="modal fade"
                                id="deleteModal<?= $row['id'] ?>"
                                tabindex="-1">

                                <div
                                    class="modal-dialog modal-dialog-centered"
                                    style="max-width: 620px;">

                                    <div
                                        class="modal-content border-0"
                                        style="
                                            background: #081229;
                                            border-radius: 16px;
                                            overflow: hidden;
                                            max-width: 620px;
                                            margin: auto;
                                        ">

                                        <div
                                            class="modal-header border-bottom"
                                            style="
                                                background: #0b1730;
                                                border-color: rgba(255,255,255,.08) !important;
                                                padding: 18px 22px;
                                            ">

                                            <h4
                                                class="modal-title w-100 text-center fw-bold text-white">

                                                Delete Asset

                                            </h4>

                                            <button
                                                type="button"
                                                class="btn-close position-absolute end-0 me-4"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>

                                        <div
                                            class="modal-body text-center"
                                            style="
                                                padding: 18px 20px 14px;
                                                overflow: hidden;
                                            ">

                                            <div
                                                style="
                                                    width: 58px;
                                                    height: 58px;
                                                    margin: auto;
                                                    border-radius: 50%;
                                                    border: 2px solid rgba(239,68,68,.45);
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    margin-bottom: 16px;
                                                    background: rgba(239,68,68,.05);
                                                    box-shadow: 0 0 25px rgba(239,68,68,.12);
                                                ">

                                                <i
                                                    class="bi bi-trash3-fill"
                                                    style="
                                                        font-size: 24px;
                                                        color: #ef4444;
                                                    ">
                                                </i>

                                            </div>

                                            <h2
                                                style="
                                                    color: #ef4444;
                                                    font-weight: 800;
                                                    font-size: 24px;
                                                    margin-bottom: 8px;
                                                ">

                                                Delete Asset?

                                            </h2>

                                            <p
                                                style="
                                                    color: rgba(255,255,255,.72);
                                                    font-size: 14px;
                                                    line-height: 1.5;
                                                    max-width: 520px;
                                                    margin: auto;
                                                    margin-bottom: 18px;
                                                ">

                                                This action will permanently remove the selected asset
                                                from the system database.

                                            </p>

                                            <div
                                                style="
                                                    background: rgba(255,255,255,.03);
                                                    border: 1px solid rgba(255,255,255,.06);
                                                    border-radius: 14px;
                                                    padding: 12px 14px;
                                                    margin-bottom: 14px;
                                                    max-width: 100%;
                                                    margin-left: auto;
                                                    margin-right: auto;
                                                ">

                                                <div class="w-100 text-start">

                                                    <h3
                                                        style="
                                                            color: #ffffff;
                                                            font-weight: 700;
                                                            margin-bottom: 14px;
                                                            font-size: 18px;
                                                            text-align: center;
                                                        ">

                                                        <?= esc($row['asset_name']) ?>

                                                    </h3>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center py-2"
                                                        style="
                                                            border-bottom: 1px solid rgba(255,255,255,.05);
                                                        ">

                                                        <span
                                                            style="
                                                                color: rgba(255,255,255,.6);
                                                                font-size: 14px;
                                                                font-weight: 500;
                                                            ">

                                                            Asset Code

                                                        </span>

                                                        <span
                                                            style="
                                                                color: #ffffff;
                                                                font-size: 15px;
                                                                font-weight: 700;
                                                            ">

                                                            <?= esc($row['asset_code']) ?>

                                                        </span>

                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center py-2">

                                                        <span
                                                            style="
                                                                color: rgba(255,255,255,.6);
                                                                font-size: 14px;
                                                                font-weight: 500;
                                                            ">

                                                            Serial Number

                                                        </span>

                                                        <span
                                                            style="
                                                                color: #ffffff;
                                                                font-size: 15px;
                                                                font-weight: 700;
                                                            ">

                                                            <?= esc($row['serial_number']) ?>

                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div
                                                style="
                                                    background: rgba(239,68,68,.08);
                                                    border: 1px solid rgba(239,68,68,.22);
                                                    border-radius: 14px;
                                                    padding: 10px 14px;
                                                    display: flex;
                                                    align-items: center;
                                                    gap: 12px;
                                                    margin-bottom: 16px;
                                                ">

                                                <i
                                                    class="bi bi-exclamation-triangle-fill"
                                                    style="
                                                        color: #ef4444;
                                                        font-size: 20px;
                                                    ">
                                                </i>

                                                <span
                                                    style="
                                                        color: #ff6b6b;
                                                        font-size: 14px;
                                                        font-weight: 600;
                                                    ">

                                                    This action cannot be undone after deletion.

                                                </span>

                                            </div>

                                            <a
                                                href="/assets/delete/<?= $row['id'] ?>"
                                                class="btn w-100"
                                                style="
                                                    background: #ef4444;
                                                    color: #ffffff;
                                                    border-radius: 14px;
                                                    padding: 11px;
                                                    font-size: 16px;
                                                    font-weight: 700;
                                                    transition: .25s ease;
                                                    border: none;
                                                "
                                                onmouseover="
                                                    this.style.transform='translateY(-2px)';
                                                    this.style.boxShadow='0 12px 24px rgba(239,68,68,.28)';
                                                "
                                                onmouseout="
                                                    this.style.transform='translateY(0)';
                                                    this.style.boxShadow='none';
                                                ">

                                                <i class="bi bi-trash3-fill me-2"></i>

                                                Delete Asset

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="9">

                                No assets found

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php if (session()->get('role_id') != 3): ?>

    <div
        class="modal fade"
        id="addAssetModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header justify-content-center">

                    <h5 class="modal-title w-100 text-center">

                        Add Asset

                    </h5>

                    <button
                        type="button"
                        class="btn-close position-absolute end-0 me-3"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <form method="post" action="/assets/store">

                    <?= csrf_field() ?>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Asset Name
                            </label>

                            <input
                                type="text"
                                name="asset_name"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Category
                            </label>

                            <input
                                type="text"
                                name="category"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Brand
                            </label>

                            <input
                                type="text"
                                name="brand"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select"
                                required>

                                <option value="Available">

                                    Available

                                </option>

                                <option value="Assigned">

                                    Assigned

                                </option>

                                <option value="Maintenance">

                                    Maintenance

                                </option>

                                <option value="Damaged">

                                    Damaged

                                </option>

                            </select>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Assigned To
                            </label>

                            <input
                                type="text"
                                name="assigned_to"
                                class="form-control">

                        </div>

                    </div>

                    <div class="modal-footer justify-content-center">

                        <button class="btn btn-primary w-100">

                            Save Asset

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

<?php endif; ?>

<script>
    const tableWrapper = document.querySelector('.table-wrapper');

    if (tableWrapper) {

        tableWrapper.addEventListener('wheel', function(e) {

            if (tableWrapper.scrollWidth > tableWrapper.clientWidth) {

                e.preventDefault();

                tableWrapper.scrollLeft += e.deltaY;

            }

        }, {
            passive: false
        });

    }

    document.querySelectorAll('.modal-body').forEach(function(modalBody) {

        modalBody.addEventListener('wheel', function(e) {

            e.stopPropagation();

            this.scrollTop += e.deltaY;

        });

    });
</script>

<?= $this->endSection() ?>