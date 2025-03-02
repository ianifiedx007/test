<!DOCTYPE html>
<html>
<head>
    <title>Job Poster Board</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php $status = $_GET['status'] ?? 'all'; ?>
<div class="container mt-5">
    <h2>Job Poster Board</h2>
    
    <!-- Filter Buttons -->
    <div class="mb-3">
        <a href="<?= base_url('jobs/job_form') ?>" class="btn btn-primary">Post a Job</a>
        <a href="<?= base_url('auth/logout') ?>" class="btn">Logout</a>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?= htmlspecialchars($job->title) ?></td>
                    <td><?= htmlspecialchars($job->description) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>