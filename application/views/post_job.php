<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post a Job</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="<?php echo base_url('public/js/main.js'); ?>"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <a class="btn btn-outline-danger" href="<?= base_url('jobposter/dashboard') ?>">Back</a>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <h2 class="text-center mb-4">Post a Job</h2>
                    
                    <form id="jobForm">
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title:</label>
                            <input type="text" id="title" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea id="description" class="form-control" rows="4" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Post Job</button>
                    </form>
                    
                    <p id="message" class="text-center mt-3"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
