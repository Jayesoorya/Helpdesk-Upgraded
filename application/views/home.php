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
    <script>
document.addEventListener("DOMContentLoaded", function () {
    loadTickets(); // Load all tickets when page loads

    // 🔹 Helper function for AJAX requests
    function makeRequest(method, url, data, callback) {
        let xhr = new XMLHttpRequest();
        xhr.open(method, url, true);

        if (method === "POST") {
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        }

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    callback(JSON.parse(xhr.responseText));
                } else {
                    console.error("Error:", xhr.status);
                }
            }
        };

        xhr.send(data);
    }

    // 🔹 Load all tickets (GET)
    function loadTickets() {
        makeRequest("GET", "<?php echo site_url('dashboard/index_get'); ?>", null, function (data) {
            let ticketsTable = document.getElementById("ticketsBody");
            ticketsTable.innerHTML = "";

            if (data.status) {
                let id = 1;
                data.tickets.forEach(ticket => {
                    let row = `
                        <tr>
                            <td>${id++}</td>
                            <td>${ticket.Ticket}</td>
                            <td><button class="btn btn-info viewDetails" data-id="${ticket.id}">View Details</button></td>
                            <td>${ticket.Status}</td>
                            <td><button class="btn btn-success editTicket" data-id="${ticket.id}" data-ticket="${ticket.Ticket}" data-description="${ticket.Description}" data-status="${ticket.Status}">Update</button></td>
                            <td><button class="btn btn-danger deleteTicket" data-id="${ticket.id}">Delete</button></td>
                        </tr>
                    `;
                    ticketsTable.innerHTML += row;
                });

                attachDeleteEvent();
                attachUpdateEvent();
                attachViewDetailsEvent();
            } else {
                ticketsTable.innerHTML = `<tr><td colspan="6">No tickets found.</td></tr>`;
            }
        });
    }

    // 🔹 Create Ticket (POST)
    document.getElementById("createTicketForm").addEventListener("submit", function (event) {
        event.preventDefault();
        let formData = new FormData(this);
        let encodedData = new URLSearchParams(formData).toString();

        makeRequest("POST", "<?php echo site_url('dashboard/store_post'); ?>", encodedData, function (data) {
            alert(data.message);
            document.getElementById("createTicketForm").reset();
            $("#createTicketModal").modal("hide");
            loadTickets();
        });
    });

    // 🔹 Attach update event
    function attachUpdateEvent() {
        document.querySelectorAll(".editTicket").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("updateTicketId").value = this.dataset.id;
                document.getElementById("updateTicketTitle").value = this.dataset.ticket;
                document.getElementById("updateTicketDescription").value = this.dataset.description;
                document.getElementById("updateTicketStatus").value = this.dataset.status;
            });
        });

        document.getElementById("updateTicketForm").addEventListener("submit", function (event) {
            event.preventDefault();
            let ticketId = document.getElementById("updateTicketId").value;
            let formData = new FormData(this);
            let encodedData = new URLSearchParams(formData).toString();

            makeRequest("POST", "<?php echo site_url('dashboard/update_post/'); ?>" + ticketId, encodedData, function (data) {
                alert(data.message);
                $("#updateTicketModal").modal("hide");
                loadTickets();
            });
        });
    }

    // 🔹 Attach delete event
    function attachDeleteEvent() {
        document.querySelectorAll(".deleteTicket").forEach(button => {
            button.addEventListener("click", function () {
                let ticketId = this.dataset.id;
                if (confirm("Are you sure you want to delete this ticket?")) {
                    makeRequest("DELETE", "<?php echo site_url('dashboard/delete_delete/'); ?>" + ticketId, null, function (data) {
                        alert(data.message);
                        loadTickets();
                    });
                }
            });
        });
    }

    // 🔹 View Ticket Details (GET)
    function attachViewDetailsEvent() {
        document.querySelectorAll(".viewDetails").forEach(button => {
            button.addEventListener("click", function () {
                let ticketId = this.dataset.id;
                fetchTicketDetails(ticketId);
            });
        });
    }

    function fetchTicketDetails(ticketId) {
        makeRequest("GET", "<?php echo site_url('dashboard/details_get/'); ?>" + ticketId, null, function (data) {
            if (data.status) {
                let ticket = data.ticket;
                alert(`Ticket Details:\n\nTicket: ${ticket.Ticket}\nDescription: ${ticket.Description}\nStatus: ${ticket.Status}`);
            } else {
                alert("Error: " + data.message);
            }
        });
    }
});
</script>

</body>
</html>
