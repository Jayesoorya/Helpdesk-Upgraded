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
            <a class="text-white text-decoration-none" id="logout">Logout</a>
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
                        <input class="form-control" type="text" name="Description" id="description">
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

//  Load Tickets via AJAX
async function loadTickets() {
    try {
        let response = await fetch("http://localhost/restapi-helpdesk/getTickets", {
            method: "GET",
            headers: {
                "X-API-KEY": "api123"
            }
        });

        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }

        let result = await response.json();
        console.log("Parsed JSON:", result); //  Debugging - Check if JSON is valid

        let ticketsHtml = "";

        if (result.status && result.tickets.length > 0) {
            result.tickets.forEach((ticket, index) => {
                ticketsHtml += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${ticket.Ticket}</td>
                        <td><a class="btn btn-info" href="http://localhost/restapi-helpdesk/details/${ticket.id}">Details</a></td>
                        <td>${ticket.Status}</td>
                        <td><button class="btn btn-success update-ticket" data-id="${ticket.id}">Update</button></td>
                        <td><button class="btn btn-danger delete-ticket" data-id="${ticket.id}">Delete</button></td>
                    </tr>`;
            });
        } else {
            console.warn("No tickets found!"); //  Debugging
            ticketsHtml = `<tr><td colspan="6" class="text-center">No tickets found.</td></tr>`;
        }

        document.getElementById("ticketsBody").innerHTML = ticketsHtml;
    } catch (error) {
        console.error("Error fetching tickets:", error);
    }
}

// Load tickets when the page loads
document.addEventListener("DOMContentLoaded", loadTickets);

//  Create Ticket AJAX
document.getElementById("createTicketForm").addEventListener("submit", async function(event) {
    event.preventDefault(); 

    const formData = new FormData(this);

    try {
        const response = await fetch("http://localhost/restapi-helpdesk/create", {
            method: "POST",
            headers: {
                "X-API-KEY": "api123"
            },
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }

        const result = await response.json();
        console.log("Parsed JSON:", result); // Debugging

        if (result.status) {
            alert(result.message);
            document.getElementById("createTicketForm").reset(); // Clear form
            loadTickets(); // Refresh tickets
        } else {
            alert("Error: " + result.message);
        }
    } catch (error) {
        console.error("Error creating ticket:", error);
        alert("An unexpected error occurred.");
    }
});

 // for update 
document.addEventListener("DOMContentLoaded", function () {
    // Open Update Modal and Fill Data
    document.getElementById("ticketsBody").addEventListener("click", async function (event) {
        if (event.target.classList.contains("update-ticket")) {
            let ticketId = event.target.getAttribute("data-id");

            try {
                let response = await fetch(`http://localhost/restapi-helpdesk/index.php/dashboard/details/${ticketId}`, {
                    method: "GET",
                    headers: { "X-API-KEY": "api123" }
                });

                let result = await response.json();
                console.log("Fetched Ticket for Update:", result); // Debugging

                if (result.status) {
                    document.getElementById("updateTicketId").value = ticketId;
                    document.getElementById("updateTicket").value = result.ticket.Ticket;
                    document.getElementById("updateDescription").value = result.ticket.Description;
                    document.getElementById("updateStatus").value = result.ticket.Status;

                    // Show Bootstrap modal
                    let modal = new bootstrap.Modal(document.getElementById("updateTicketModal"));
                    modal.show();
                } else {
                    alert("Ticket not found.");
                }
            } catch (error) {
                console.error("Error fetching ticket details:", error);
                alert("Failed to load ticket details.");
            }
        }
    });

    // Submit Update Form
    document.getElementById("updateTicketForm").addEventListener("submit", async function (event) {
        event.preventDefault(); // Prevent page reload

        let ticketId = document.getElementById("updateTicketId").value;
        let formData = new URLSearchParams();
        formData.append("Ticket", document.getElementById("updateTicket").value);
        formData.append("Description", document.getElementById("updateDescription").value);
        formData.append("Status", document.getElementById("updateStatus").value);

        try {
            let response = await fetch(`http://localhost/restapi-helpdesk/index.php/dashboard/update/${ticketId}`, {
                method: "POST",
                headers: {
                    "X-API-KEY": "api123",
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: formData
            });

            let result = await response.json();
            console.log("Update Response:", result); // Debugging

            if (response.ok && result.status) {
                alert("Ticket updated successfully!");

                loadTickets(); // Refresh ticket list
            } else {
                alert("Error updating ticket: " + (result.message || "Unknown error"));
            }
        } catch (error) {
            console.error("Error updating ticket:", error);
            alert("An unexpected error occurred.");
        }
    });
});

//delete ticket
document.addEventListener("DOMContentLoaded", function () {
    // Event Listener for Delete Button
    document.getElementById("ticketsBody").addEventListener("click", async function (event) {
        if (event.target.classList.contains("delete-ticket")) {
            let ticketId = event.target.getAttribute("data-id");

            // Confirm before deleting
            if (!confirm("Are you sure you want to delete this ticket?")) {
                return;
            }

            try {
                let response = await fetch(`http://localhost/restapi-helpdesk/index.php/dashboard/delete/${ticketId}`, {
                    method: "DELETE",
                    headers: {
                        "X-API-KEY": "api123"
                    }
                });

                let result = await response.json();
                console.log("Delete Response:", result); // Debugging

                if (response.ok && result.status) {
                    alert("Ticket deleted successfully!");
                    loadTickets(); // Refresh ticket list
                } else {
                    alert("Error deleting ticket: " + (result.message || "Unknown error"));
                }
            } catch (error) {
                console.error("Error deleting ticket:", error);
                alert("An unexpected error occurred.");
            }
        }
    });
});

//  Logout AJAX
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("logout").addEventListener("click", async function () {
        try {
            let response = await fetch("http://localhost/restapi-helpdesk/index.php/dashboard/logout", {
                method: "POST",
                headers: {
                    "X-API-KEY": "api123"
                }
            });

            let result = await response.json();
            console.log("Logout Response:", result); // Debugging

            if (response.ok && result.status) {
                alert("Logged out successfully!");
                window.location.href = "http://localhost/restapi-helpdesk/loginview"; // Redirect to login page
            } else {
                alert("Logout failed: " + (result.message || "Unknown error"));
            }
        } catch (error) {
            console.error("Logout Error:", error);
            alert("An unexpected error occurred.");
        }
    });
});

</script>

</body>
</html>
