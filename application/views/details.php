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
                    <tr><td colspan="2">Loading ticket details...</td></tr>
                </tbody>
            </table>
            <a class="btn btn-secondary" href="<?php echo site_url('dashboard'); ?>">Back to Dashboard</a>
        </div>
    </div>
</div>

<!-- ✅ JavaScript for Fetching Ticket Details -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const ticketId = urlParams.get("id");

    if (!ticketId) {
        document.getElementById("ticketDetails").innerHTML = "<tr><td colspan='2' class='text-danger'>Invalid Ticket ID.</td></tr>";
        return;
    }

    function fetchTicketDetails(ticketId) {
        let xhr = new XMLHttpRequest();
        let apiUrl = "<?php echo site_url('dashboard/details_get/'); ?>" + ticketId;
        
        xhr.open("GET", apiUrl, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        let data = JSON.parse(xhr.responseText);
                        if (data.status) {
                            let ticket = data.ticket;
                            document.getElementById("ticketDetails").innerHTML = `
                                <tr><th>Ticket ID:</th><td>${ticket.id}</td></tr>
                                <tr><th>Ticket:</th><td>${ticket.Ticket}</td></tr>
                                <tr><th>Description:</th><td>${ticket.Description}</td></tr>
                                <tr><th>Created On:</th><td>${ticket.Created_On}</td></tr>
                                <tr><th>Status:</th><td>${ticket.Status}</td></tr>
                            `;
                        } else {
                            document.getElementById("ticketDetails").innerHTML = `<tr><td colspan='2' class='text-danger'>${data.message}</td></tr>`;
                        }
                    } catch (error) {
                        console.error("JSON Parse Error:", error, xhr.responseText);
                        document.getElementById("ticketDetails").innerHTML = `<tr><td colspan='2' class='text-danger'>Invalid API response.</td></tr>`;
                    }
                } else {
                    document.getElementById("ticketDetails").innerHTML = `<tr><td colspan='2' class='text-danger'>Error loading ticket details.</td></tr>`;
                }
            }
        };

        xhr.send();
    }

    fetchTicketDetails(ticketId);
});
</script>

</body>
</html>
