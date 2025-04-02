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

            axios.get("http://localhost/Helpdesk_vue.js/index.php/dashboard/details/" + this.ticketId, {
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