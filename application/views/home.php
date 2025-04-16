    <div id="app" class="container-fluid">
        <!-- Top Buttons -->
        <div class="text-right mt-4">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createTicketModal">Create Ticket</button>
            <button class="btn btn-info">
                <a class="text-white text-decoration-none" @click="logout">Logout</a>
            </button>
            <button class="btn btn-outline-primary" @click="goToProfile">
                <i class="fas fa-user-circle"></i> Profile
            </button>
        </div>

        <h1>Helpdesk Upgraded</h1>
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
                        <td>{{ ticket.ticket }}</td>
                        <td><a class="btn btn-info" :href="'http://localhost/Helpdesk-Upgraded/details/' + ticket.id">Details</a></td>
                        <td>{{ ticket.status }}</td>
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
                                <input class="form-control" v-model="updateTicketData.ticket" required>
                            </div>
                            <div class="form-group">
                                <label for="updateDescription">Description:</label>
                                <input class="form-control" v-model="updateTicketData.description">
                            </div>
                            <div class="form-group">
                                <label for="updateStatus">Status:</label>
                                <select class="form-control" v-model="updateTicketData.status">
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

    <!-- Bootstrap and jQuery for Modals -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app/home.js"></script>

