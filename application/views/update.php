<!DOCTYPE html>
<html>
<head>
    <title>Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="card">
        <div class="card-header">Edit Page</div> 
        <div class="card-body">
    <form method="post" action="<?php echo site_url('dashboard/update/'.$ticket->id); ?>">
        <label for="ticket">Ticket:</label>
        <input class="form-control" type="text"  name="ticket"  value="<?php echo $ticket->Ticket; ?>" required><br>
        <label>Description:</label>
        <input class="form-control" type="text"  name="description"  value="<?php echo $ticket->Description; ?>"><br>
        <label >Status:</label>
        <select  style=" width: 140px; height:40px; border-radius:10px; margin-bottom:30px;" name="status">
            <option value="Open" <?php echo ($ticket->Status == 'Open') ? 'selected' : ''; ?>>Open</option>
            <option value="In Progress" <?php echo ($ticket->Status == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
            <option value="Closed" <?php echo ($ticket->Status == 'Closed') ? 'selected' : ''; ?>>Closed</option>
        </select><br>
        <button class=" btn bg-success text-white" type="submit">Update </button>
    </form>
    <a class=" btn btn-secondary mt-4" href="<?php echo site_url('dashboard'); ?>">Back to Dashboard</a>
</div>
</body>
</html>
