<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
</head>
<body>

<div id="app" class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center">Ticket Details</h2>
            
            <table class="table table-bordered">
                <tbody v-if="ticket">
                    <tr><th>Ticket</th><td>{{ ticket.Ticket }}</td></tr>
                    <tr><th>Description</th><td>{{ ticket.Description }}</td></tr>
                    <tr><th>Status</th><td>{{ ticket.Status }}</td></tr>
                    <tr><th>Created On</th><td>{{ ticket.Created_On }}</td></tr>
                </tbody>
                <tbody v-else>
                    <tr><td colspan="2" class="text-center text-danger">Loading ticket details...</td></tr>
                </tbody>
            </table>

            <a class="btn btn-secondary" href="http://localhost/Helpdesk_vue.js/dashboard">Back to Dashboard</a>
        </div>
    </div>
</div>

<!-- Vue.js and axios  -->
<script>
new Vue({
    el: "#app",
    data() {
        return {
            ticket: null, // stores details
            ticketId: null
        };
    },
    created() {
        this.getTicketIdFromURL();
        this.fetchTicketDetails();
    },
    methods: {
        // extract ID from URL
        getTicketIdFromURL() {
            let urlParts = window.location.pathname.split("/");
            this.ticketId = urlParts[urlParts.length - 1]; // get last part of URL
            console.log("Extracted Ticket ID:", this.ticketId);
        },

        // Fetch Ticket Details using Axios
        fetchTicketDetails() {
            const token = localStorage.getItem("token");
            if (!token) {
                alert("Authentication required. Please log in.");
                return;
            }

            if (!this.ticketId || isNaN(this.ticketId)) {
                alert("Invalid Ticket ID!");
                return;
            }

            axios.get(`http://localhost/Helpdesk_vue.js/index.php/dashboard/details/${this.ticketId}`, {
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "X-API-KEY": "api123"
                }
            })
            .then(response => {
                console.log("API Response:", response.data);
                if (response.data.status) {
                    this.ticket = response.data.ticket; // get ticket details
                } else {
                    alert("Ticket not found.");
                }
            })
            .catch(error => {
                console.error("Error fetching ticket:", error);
                alert("An error occurred while loading the ticket details.");
            });
        },
    }
});
</script>

</body>
</html>
