<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    .table-responsive {
        overflow-x: auto;
        scroll-behavior: smooth;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
        padding: 14px 18px;
        white-space: nowrap;
    }

    .dashboard-card {
        border-radius: 12px;
        transition: 0.2s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
    }
</style>

<?php

$totalAssets = $totalAssets ?? 0;

$availableAssets = $availableAssets ?? 0;

$assignedAssets = $assignedAssets ?? 0;

$damagedAssets = $damagedAssets ?? 0;

$maintenanceAssets = $maintenanceAssets ?? 0;

$recentAssets = $recentAssets ?? [];

?>

<div class="row mb-4">

    <div class="col-md-3 mb-3">

        <div class="card shadow border-0 dashboard-card h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Total Assets
                </h6>

                <h2 class="fw-bold">
                    <?= $totalAssets ?>
                </h2>

                <p class="text-muted mb-0">
                    All registered assets
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-0 dashboard-card h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Available
                </h6>

                <h2 class="fw-bold text-success">
                    <?= $availableAssets ?>
                </h2>

                <p class="text-muted mb-0">
                    Ready to use
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-0 dashboard-card h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Assigned
                </h6>

                <h2 class="fw-bold text-primary">
                    <?= $assignedAssets ?>
                </h2>

                <p class="text-muted mb-0">
                    Currently in use
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow border-0 dashboard-card h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Damaged
                </h6>

                <h2 class="fw-bold text-danger">
                    <?= $damagedAssets ?>
                </h2>

                <p class="text-muted mb-0">
                    Needs replacement
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row mb-4">

    <div class="col-md-12">

        <div class="card shadow border-0">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="mb-1">
                        Asset Management
                    </h5>

                    <p class="text-muted mb-0">
                        Manage and monitor company assets
                    </p>

                </div>

                <a href="/assets" class="btn btn-primary">

                    Open Assets

                </a>

            </div>

        </div>

    </div>

</div>

<div class="card shadow border-0">

    <div class="card-header bg-white">

        Recent Assets

    </div>

    <div class="card-body">

        <div class="table-responsive" id="tableScroll">

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

                    </tr>

                </thead>

                <tbody>

                    <?php if (count($recentAssets) > 0): ?>

                        <?php foreach ($recentAssets as $row): ?>

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

                                        <span class="badge bg-success">
                                            Available
                                        </span>

                                    <?php elseif ($row['status'] == 'Assigned'): ?>

                                        <span class="badge bg-primary">
                                            Assigned
                                        </span>

                                    <?php elseif ($row['status'] == 'Maintenance'): ?>

                                        <span class="badge bg-warning text-dark">
                                            Maintenance
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-danger">
                                            Damaged
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <?= esc($row['assigned_to']) ?>
                                </td>

                                <td>

                                    <?php

                                    $phTime = new DateTime(
                                        $row['purchase_date'],
                                        new DateTimeZone('Asia/Manila')
                                    );

                                    echo $phTime->format('F d, Y • h:i A');

                                    ?>

                                </td>


                            </tr>

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

<script>
    document.addEventListener(
        "DOMContentLoaded",
        function() {
            const tableContainer =
                document.getElementById('tableScroll');

            if (tableContainer) {
                tableContainer.addEventListener(
                    'wheel',
                    function(e) {
                        if (e.deltaY !== 0) {
                            e.preventDefault();

                            this.scrollLeft += e.deltaY;
                        }
                    }
                );
            }
        }
    );
</script>

<?= $this->endSection() ?>