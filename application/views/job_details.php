<!DOCTYPE html>
<html>
<head>
    <title>Job Details - <?= htmlspecialchars($job['title']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2><?= htmlspecialchars($job['title']) ?></h2>

    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($job['description'])) ?></p>

    <?php if (!empty($job['is_external']) && $job['is_external'] === true): ?>
        <hr>
        <p><strong>Company:</strong> <?= htmlspecialchars($job['company']) ?></p>
        <p><strong>Office:</strong> <?= htmlspecialchars($job['office']) ?></p>
        <p><strong>Department:</strong> <?= htmlspecialchars($job['department']) ?></p>
        <p><strong>Category:</strong> <?= htmlspecialchars($job['category']) ?></p>
        <p><strong>Employment Type:</strong> <?= htmlspecialchars($job['employmentType']) ?></p>
        <p><strong>Seniority:</strong> <?= htmlspecialchars($job['seniority']) ?></p>
        <p><strong>Schedule:</strong> <?= htmlspecialchars($job['schedule']) ?></p>
        <p><strong>Experience Required:</strong> <?= htmlspecialchars($job['experience']) ?> years</p>
        <p><strong>Keywords:</strong> <?= htmlspecialchars($job['keywords']) ?></p>
        <p><strong>Posted On:</strong> <?= htmlspecialchars($job['createdAt']) ?></p>
        <hr>
    <?php endif; ?>

    <a href="<?= site_url('jobseeker/dashboard') ?>" class="btn btn-secondary">Back to Jobs</a>
</div>
</body>
</html>
