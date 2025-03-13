<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="text-right mt-4">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createTicketModal">Create Ticket</button>
    <button class="btn btn-info"><a class="text-white text-decoration-none" href="<?php echo site_url('auth/logout'); ?>" >Logout</a></button>
</div>
    <h1>Helpdesk 2.0</h1>
    <h2 class="mt-4">Welcome, <?php echo $this->session->userdata('user'); ?></h2>
    <div class="table-responsive">
    <table class="table table-bordered table-hover mt-5 " >
        <thead class="thead-dark">
        <tr>
            <th>S.No</th>
            <th>Ticket</th>
            <th>View Details</th>
            <th>Status</th>
            <th>Update</th>
            <th>Delete</th> 
        </tr>
        
        <tbody id="ticketsBody">
        <?php  $id=1; ?>
        <?php if (!empty($tickets)): ?> 
        <?php foreach ($tickets as $index => $ticket): ?>

            <tr>
            <?php if (isset($ticket->id)): ?>
            <td ><?php echo $id++; ?></td>
            <td ><?php echo $ticket->Ticket; ?></td>
            <td ><a class="btn btn-info" href="<?php echo site_url('dashboard/details/'.$ticket->id); ?>">Details</a></td>
            <td ><?php echo $ticket->Status; ?></td>
            <td ><button type="button" class="btn btn-success" data-id="<?php echo $ticket->id; ?>" data-toggle="modal" data-target="#updateModal<?php echo $ticket->id; ?>">Update</button></td>
            <td ><a class="btn btn-danger" href="<?php echo site_url('dashboard/delete/'.$ticket->id); ?>" onclick="return confirm('Are you sure you want to delete this ticket ?')">Delete</a> </td>
            <?php else: ?>
                    <span>No ID Found</span>
                <?php endif; ?>
            </td>
        </tr>
        <div class="modal fade" id="updateModal<?php echo $ticket->id; ?>" tabindex="-1" aria-labelledby="updateModalLabel<?php echo $ticket->id; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel<?php echo $ticket->id; ?>">Edit Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo site_url('dashboard/update/'.$ticket->id); ?>">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket->id; ?>">

                        <div class="form-group">
                            <label for="ticket_<?php echo $ticket->id; ?>">Ticket:</label>
                            <input class="form-control" type="text" name="ticket" id="ticket_<?php echo $ticket->id; ?>" value="<?php echo $ticket->Ticket; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description_<?php echo $ticket->id; ?>">Description:</label>
                            <input class="form-control" type="text" name="description" id="description_<?php echo $ticket->id; ?>" value="<?php echo $ticket->Description; ?>">
                        </div>
                        <div class="form-group">
                            <label for="status_<?php echo $ticket->id; ?>">Status:</label>
                            <select class="form-control" name="status" id="status_<?php echo $ticket->id; ?>">
                                <option value="Open" <?php echo ($ticket->Status == 'Open') ? 'selected' : ''; ?>>Open</option>
                                <option value="In Progress" <?php echo ($ticket->Status == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Closed" <?php echo ($ticket->Status == 'Closed') ? 'selected' : ''; ?>>Closed</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--Bootsrap modal for update -->  
<div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTicketModalLabel">Create New Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo site_url('dashboard/store'); ?>">
                    <div class="form-group">
                        <label for="ticket">Ticket:</label>
                        <input class="form-control" type="text" name="Ticket" id="ticket" value="<?php echo set_value('Ticket'); ?>" required>
                        <small class="text-danger"><?php echo form_error('Ticket'); ?></small>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input class="form-control" type="text" name="description" id="description" value="<?php echo set_value('Description'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" name="Status" id="status">
                            <option value="Open" <?php echo set_select('Status', 'Open'); ?>>Open</option>
                            <option value="In Progress" <?php echo set_select('Status', 'In Progress'); ?>>In Progress</option>
                            <option value="Closed" <?php echo set_select('Status', 'Closed'); ?>>Closed</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No tickets found.</td>
        </tr>
    <?php endif; ?>
       
    </table>
    </div>
    </div>
</body>
</html>
