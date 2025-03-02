<!DOCTYPE html>
<html>
<head>
    <title>Job Moderation Board</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .btn.active {
            background-color: #0056b3 !important;
            border-color: #004085 !important;
            color: white !important;
        }
    </style>
</head>
<body>
<?php $status = $_GET['status'] ?? 'pending'; ?>
<div class="container mt-5">
    <h2>Job Moderator Board</h2>
    
    <div class="mb-3">
        <a href="<?= base_url('jobmoderator/dashboard?status=pending') ?>" class="btn <?= ($status == 'pending') ? 'active' : '' ?>">Notification</a>
        <a href="<?= base_url('jobmoderator/dashboard?status=approved') ?>" class="btn <?= ($status == 'approved') ? 'active' : '' ?>">Show Approved</a>
        <a href="<?= base_url('jobmoderator/dashboard?status=spam') ?>" class="btn <?= ($status == 'spam') ? 'active' : '' ?>">Show Spam</a>
        <a href="<?= base_url('jobmoderator/dashboard?status=all') ?>" class="btn <?= ($status == 'all') ? 'active' : '' ?>">Show All</a>
        <a href="<?= base_url('auth/logout') ?>" class="btn">Logout</a>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?= htmlspecialchars($job->title) ?></td>
                    <td><?= htmlspecialchars($job->description) ?></td>
                    <td><?= htmlspecialchars($job->email) ?></td>
                    <?php if($job->status == 'pending'){ ?>
                    <td>
                        <a href="<?= base_url('jobs/approve/' . $job->id) ?>" class="btn btn-success">Approve</a>
                        <a href="<?= base_url('jobs/spam/' . $job->id) ?>" class="btn btn-danger">Mark as Spam</a>
                    </td>
                    <?php } ?>
                    <?php if($job->status == 'approved'){ ?>
                    <td>
                        <a href="<?= base_url('jobs/spam/' . $job->id) ?>" class="btn btn-danger">Mark as Spam</a>
                    </td>
                    <?php } ?>
                    <?php if($job->status == 'spam'){ ?>
                    <td>
                        <a href="<?= base_url('jobs/approve/' . $job->id) ?>" class="btn btn-success">Approve</a>
                    </td>
                    <?php } ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>