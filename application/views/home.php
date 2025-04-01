<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div id="app" class="container-fluid">
        <!-- Top Buttons -->
        <div class="text-right mt-4">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createTicketModal">Create Ticket</button>
            <button class="btn btn-info">
                <a class="text-white text-decoration-none" @click="logout">Logout</a>
            </button>
        </div>

        <h1>Helpdesk 2.0</h1>
        <h2 class="mt-4">Welcome,</h2>

        <!-- Ticket Table -->
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
                <tbody>
                    <tr v-for="(ticket, index) in tickets" :key="ticket.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ ticket.Ticket }}</td>
                        <td><a class="btn btn-info" :href="'http://localhost/Helpdesk_vue.js/details/' + ticket.id">Details</a></td>
                        <td>{{ ticket.Status }}</td>
                        <td><button class="btn btn-success" @click="openUpdateModal(ticket)">Update</button></td>
                        <td><button class="btn btn-danger" @click="deleteTicket(ticket.id)">Delete</button></td>
                    </tr>
                </tbody>
            </table>
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
                        <form @submit.prevent="createTicket">
                            <div class="form-group">
                                <label for="ticket">Ticket:</label>
                                <input class="form-control" v-model="newTicket.Ticket" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <input class="form-control" v-model="newTicket.Description">
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" v-model="newTicket.Status">
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
                        <form @submit.prevent="updateTicket">
                            <div class="form-group">
                                <label for="updateTicket">Ticket:</label>
                                <input class="form-control" v-model="updateTicketData.Ticket" required>
                            </div>
                            <div class="form-group">
                                <label for="updateDescription">Description:</label>
                                <input class="form-control" v-model="updateTicketData.Description">
                            </div>
                            <div class="form-group">
                                <label for="updateStatus">Status:</label>
                                <select class="form-control" v-model="updateTicketData.Status">
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
    </div>

    <!-- Axios Calls with Vue.js -->
    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    tickets: [], // List of tickets
                    newTicket: { Ticket: '', Description: '', Status: 'Open' }, // New ticket data
                    updateTicketData: { id: '', Ticket: '', Description: '', Status: 'Open' }, // Update ticket data
                };
            },
            created() {
                this.loadTickets();
            },
            methods: {
                loadTickets() {
                    const token = localStorage.getItem("token");
                    if (!token) {
                        alert("Authentication required. Please log in.");
                        return;
                    }
                    axios.get("http://localhost/Helpdesk_vue.js/getTickets", {
                        headers: {
                            "Authorization": `Bearer ${token}`,
                            "X-API-KEY": "api123",
                        }
                    })
                    .then(response => {
                        if (response.data.status && response.data.tickets) {
                            this.tickets = response.data.tickets;
                        } else {
                            alert("Failed to load tickets.");
                        }
                    })
                    .catch(error => {
                        console.error("Error loading tickets:", error);
                    });
                },

                createTicket() {
                        const token = localStorage.getItem("token");
                        if (!token) {
                            alert("Authentication required. Please log in.");
                            return;
                        }

                        let formData = new FormData();
                        formData.append("Ticket", this.newTicket.Ticket);
                        formData.append("Description", this.newTicket.Description);
                        formData.append("Status", this.newTicket.Status);

                        axios.post("http://localhost/Helpdesk_vue.js/create", formData, {
                            headers: {
                                "Authorization": `Bearer ${token}`,
                                "X-API-KEY": "api123",
                                "Content-Type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(response => {
                            if (response.data.status) {
                                alert("Ticket created successfully!");
                                this.newTicket = { Ticket: '', Description: '', Status: 'Open' }; // Reset form
                                $('#createTicketModal').modal('hide');
                                this.loadTickets(); // Refresh the ticket list
                            } else {
                                alert("Error: " + response.data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error creating ticket:", error);
                            alert("An error occurred while creating the ticket.");
                        });
                },

                openUpdateModal(ticket) {
                    this.updateTicketData = { ...ticket }; // Load ticket data into the update form
                    $('#updateTicketModal').modal('show');
                },

                updateTicket() {
                    const token = localStorage.getItem("token");
                    if (!token) {
                        alert("Authentication required. Please log in.");
                        return;
                    }

                    axios.post(`http://localhost/Helpdesk_vue.js/index.php/dashboard/update/${this.updateTicketData.id}`, this.updateTicketData, {
                        headers: {
                            "Authorization": `Bearer ${token}`,
                            "X-API-KEY": "api123",
                            "Content-Type": "application/x-www-form-urlencoded"
                        }
                    })
                    .then(response => {
                        if (response.data.status) {
                            alert("Ticket updated successfully!");
                            $('#updateTicketModal').modal('hide');
                            this.loadTickets(); // Refresh ticket list
                        } else {
                            alert("Error: " + response.data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error updating ticket:", error);
                        alert("An unexpected error occurred.");
                    });
                },

                deleteTicket(ticketId) {
                    const token = localStorage.getItem("token");
                    if (!token) {
                        alert("Authentication required. Please log in.");
                        return;
                    }

                    if (!confirm("Are you sure you want to delete this ticket?")) {
                        return;
                    }

                    axios.delete(`http://localhost/Helpdesk_vue.js/index.php/dashboard/delete/${ticketId}`, {
                        headers: {
                            "Authorization": `Bearer ${token}`,
                            "X-API-KEY": "api123"
                        }
                    })
                    .then(response => {
                        if (response.data.status) {
                            alert("Ticket deleted successfully!");
                            this.loadTickets(); // Refresh ticket list
                        } else {
                            alert("Error: " + response.data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error deleting ticket:", error);
                        alert("An error occurred while deleting the ticket.");
                    });
                },
                
                logout() {
                    axios.post("http://localhost/Helpdesk_vue.js/index.php/dashboard/logout", {}, {
                        headers: {
                            "X-API-KEY": "api123"
                        }
                    })
                    .then(response => {
                        console.log("Logout Response:", response.data); // Debugging

                        if (response.data.status) {
                            alert("Logged out successfully!");
                            localStorage.removeItem("token"); // Remove token
                            window.location.href = "http://localhost/Helpdesk_vue.js/loginview"; // Redirect to login page
                        } else {
                            alert("Logout failed: " + (response.data.message || "Unknown error"));
                        }
                    })
                    .catch(error => {
                        console.error("Logout Error:", error);
                        alert("An unexpected error occurred.");
                    });
                }

            }
        });
    </script>

    <!-- Bootstrap and jQuery for Modals -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
