<!DOCTYPE html>
<html>
<head>
    <title>Job Listings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Job Listings</h2>
    <div class="mb-3">
        <a href="<?= base_url('auth/logout') ?>" class="btn">Logout</a>
    </div>
    <div class="row">
        <?php foreach ($jobs as $job): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($job['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($job['description']) ?></p>
                        <a href="<?= site_url($job['is_external'] ?? false ? 'jobs/details_xml/' : 'jobs/details/') . $job['id'] ?>" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
