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
        <button class="btn btn-info">
            <a class="text-white text-decoration-none" href="<?php echo site_url('auth/logout'); ?>">Logout</a>
        </button>
    </div>

    <h1>Helpdesk 2.0</h1>
    <h2 class="mt-4">Welcome, <?php echo $this->session->userdata('user'); ?></h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover mt-5">
            <thead class="thead-dark">
                <tr>
                    <th>S.No</th>
                    <th>Ticket</th>
                    <th>View Details</th>
                    <th>Status</th>
                    <th>Update</th>
                    <th>Delete</th> 
                </tr>
            </thead>
            <tbody id="ticketsBody">
              <!--  <tr><td colspan="6" class="text-center">Loading tickets...</td></tr> -->
            </tbody>
        </table>
    </div>
</div>

<!-- Create Ticket Modal -->
<div class="modal fade" id="createTicketModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Ticket</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createTicketForm">
                    <div class="form-group">
                        <label for="ticket">Ticket:</label>
                        <input class="form-control" type="text" name="Ticket" id="ticket" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input class="form-control" type="text" name="description" id="description">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" name="Status" id="status">
                            <option value="Open">Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Closed">Closed</option>
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

<!-- Update Ticket Modal -->
<div class="modal fade" id="updateTicketModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Ticket</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateTicketForm">
                    <input type="hidden" id="updateTicketId">

                    <div class="form-group">
                        <label for="updateTicket">Ticket:</label>
                        <input class="form-control" type="text" id="updateTicket" required>
                    </div>
                    <div class="form-group">
                        <label for="updateDescription">Description:</label>
                        <input class="form-control" type="text" id="updateDescription">
                    </div>
                    <div class="form-group">
                        <label for="updateStatus">Status:</label>
                        <select class="form-control" id="updateStatus">
                            <option value="Open">Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Handle AJAX Calls -->
<script>
const apiUrl = "http://localhost/restapi-helpdesk/index.php/dashboard";

// 🔹 Load Tickets via AJAX
async function loadTickets() {
    try {
        const response = await fetch(apiUrl + "/getTickets", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        const data = await response.json();
        let ticketsHtml = "";

        if (data.status) {
            data.tickets.forEach((ticket, index) => {
                ticketsHtml += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${ticket.Ticket}</td>
                        <td><a class="btn btn-info" href="${apiUrl}/details/${ticket.id}">Details</a></td>
                        <td>${ticket.Status}</td>
                        <td><button class="btn btn-success update-ticket" data-id="${ticket.id}" data-toggle="modal" data-target="#updateTicketModal">Update</button></td>
                        <td><button class="btn btn-danger delete-ticket" data-id="${ticket.id}">Delete</button></td>
                    </tr>`;
            });
        } else {
            ticketsHtml = `<tr><td colspan="6" class="text-center">No tickets found.</td></tr>`;
        }

        document.getElementById("ticketsBody").innerHTML = ticketsHtml;
    } catch (error) {
        console.error("Error fetching tickets:", error);
    }
}

// 🔹 Create Ticket AJAX
document.getElementById("createTicketForm").addEventListener("submit", async function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    const response = await fetch(apiUrl + "/store", {
        method: "POST",
        body: formData
    });

    const result = await response.json();
    alert(result.message);
    loadTickets();
});

// 🔹 Logout AJAX
document.getElementById("logoutBtn").addEventListener("click", async function() {
    const response = await fetch(apiUrl + "/logout", {
        method: "POST"
    });

    if (response.ok) {
        window.location.href = "<?php echo site_url('auth/login'); ?>";
    } else {
        alert("Logout failed!");
    }
});

// Load tickets on page load
document.addEventListener("DOMContentLoaded", loadTickets);
</script>

</body>
</html>
