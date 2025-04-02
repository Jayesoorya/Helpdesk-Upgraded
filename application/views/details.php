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

<script src="../assets/js/app/details.js"></script>
