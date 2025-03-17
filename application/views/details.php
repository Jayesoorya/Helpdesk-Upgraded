<!DOCTYPE html>
<html>
<head>
    <title>Ticket Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center">Ticket Details</h2>
            <table class="table table-bordered">
                <tbody id="ticketDetails">
                   
                </tbody>
            </table>
            <a class="btn btn-secondary" href="<?php echo site_url('dashboard'); ?>">Back to Dashboard</a>
        </div>
    </div>
</div>

<!--  JavaScript for Fetching Ticket Details -->
<script>
document.addEventListener("DOMContentLoaded", async function () {
    console.log("Page Loaded"); //  Debugging - Check if script runs

    // Extract ticket ID from the URL
    let urlParts = window.location.pathname.split("/");
    let ticketId = urlParts[urlParts.length - 1]; // Get last part of URL

    console.log("Extracted Ticket ID:", ticketId); //  Debugging - Check extracted ID

    if (!ticketId || isNaN(ticketId)) {
        document.getElementById("ticketDetails").innerHTML = `<tr><td colspan="2" class="text-center text-danger">Ticket ID is missing!</td></tr>`;
        return;
    }

    try {
        let response = await fetch(`http://localhost/restapi-helpdesk/index.php/dashboard/details/${ticketId}`, {
            method: "GET",
            headers: { "X-API-KEY": "api123" }
        });

        console.log("Raw Response:", response); // Debugging - Check response object

        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }

        let result = await response.json();
        console.log("Parsed JSON:", result); //  Debugging - Check parsed JSON

        if (result.status) {
            document.getElementById("ticketDetails").innerHTML = `
                <tr><th>Ticket</th><td>${result.ticket.Ticket}</td></tr>
                <tr><th>Description</th><td>${result.ticket.Description}</td></tr>
                <tr><th>Status</th><td>${result.ticket.Status}</td></tr>
                 <tr><th>Created On</th><td>${new Date(result.ticket.Created_On).toLocaleString()}</td></tr>
            `;
        } else {
            document.getElementById("ticketDetails").innerHTML = `<tr><td colspan="2" class="text-center text-danger">Ticket not found.</td></tr>`;
        }
    } catch (error) {
        console.error("Error fetching ticket details:", error);
        document.getElementById("ticketDetails").innerHTML = `<tr><td colspan="2" class="text-center text-danger">An error occurred while loading ticket details.</td></tr>`;
    }
});
</script>

</body>
</html>
