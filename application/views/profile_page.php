<div class="container mt-5" id="app">
    <div class="card">
        <div class="card-header">My Profile</div>
        <div class="card-body">
            <p><strong>Username:</strong> {{ user.username }}</p>
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p><strong>Phone:</strong> {{ user.phone_number }}</p>

            <h5 class="mt-4">Change Password</h5>
            <input type="password" class="form-control" v-model="current_password" placeholder="Current Password"><br>
            <input type="password" class="form-control" v-model="new_password" placeholder="New Password"><br>
            <button class="btn btn-success" @click="changePassword">Change Password</button>
            <a class="btn btn-secondary" href="http://localhost/Helpdesk-Upgraded/dashboard">Back</a>
            <p class="text-success mt-2" v-if="message">{{ message }}</p>
            <p class="text-danger mt-2" v-if="error">{{ error }}</p>
        </div>
    </div>
</div>

<script src="assets/js/app/profile.js"></script>
