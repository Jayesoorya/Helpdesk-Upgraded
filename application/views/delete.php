<!DOCTYPE html>
<html>
<head>
    <title>Delete Ticket</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css'); ?>">
</head>
<body>
    <h2>Delete Ticket</h2>
    <p>Are you sure you want to delete this ticket?</p>
    <p><strong>Title:</strong> <?php echo $ticket->title; ?></p>
    <p><strong>Description:</strong> <?php echo $ticket->description; ?></p>
    <form method="post" action="<?php echo site_url('dashboard/delete/'.$ticket->id); ?>">
        <button type="submit">Delete</button>
    </form>
    <a href="<?php echo site_url('dashboard'); ?>">Cancel</a>
</body>
</html>
