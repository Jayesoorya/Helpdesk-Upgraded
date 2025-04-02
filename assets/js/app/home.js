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

            axios.post(`http://localhost/Helpdesk_vue.js/update/${this.updateTicketData.id}`, this.updateTicketData, {
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
