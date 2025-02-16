<!DOCTYPE html>
<html>
<head>
    <title>Create Ticket</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <div class="card">
        <div class="card-header">Create New Ticket</div>
    <div class="card-body">
    <form method="post" action="<?php echo site_url('dashboard/store'); ?>">
        <label>Ticket:</label>
        <input class="form-control" type="text" name="Ticket"  required><br>
        <label>Description:</label>
        <input class="form-control" type="text" name="description" ><br>
        <label>Status:</label>
        <select name="status" style=" width: 140px; height:40px; border-radius:10px; margin-bottom:30px;">
            <option value="Open">Open</option>
            <option value="In Progress">In Progress</option>
            <option value="Closed">Closed</option>
        </select><br>
        <button class="btn btn-info" type="submit">Create</button>
    </form>
    <a class="btn btn-secondary mt-4" href="<?php echo site_url('dashboard'); ?>">Back to Dashboard</a>
</div>
</body>
</html>
