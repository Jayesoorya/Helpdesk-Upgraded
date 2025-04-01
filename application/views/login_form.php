<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-light">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<div class="container" id="app">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
           <div class="card ">
           <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
           <h1 class="text-center" >HELPDESK</h1>
            <div class="card-body">
            <form @submit.prevent="login">
                <h2 >Login</h2>
                   <label >User Name</label>
                   <input class="form-control" v-model="username" placeholder="Username" required>
                   <label >Password</label>
                <input class="form-control" type="password" v-model="password" placeholder="Password" required >
                <button class="btn btn-info mt-4" type="submit"  >Login</button>
            </form>
        </div>
     </div>
 </div>
</div>

<!-- Vue.JS for AJAX Login -->

<script>
new Vue({
    el: "#app",
    data() {
        return {
            username: '',
            password: '',
            errorMessage: ''
        };
    },
    methods: {
        login() {
            if (!this.username || !this.password) {
                this.errorMessage = "Username and password are required!";
                return;
            }

            axios.post("http://localhost/Helpdesk_vue.js/index.php/auth/login", 
            {
                username: this.username,
                password: this.password
            }, 
            {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-API-KEY": "api123"
                }
            })
            .then(response => {
                if (response.data.status) {
                    localStorage.setItem("token", response.data.token);
                    window.location.href = "dashboard";
                } else {
                    this.errorMessage = "Login failed: " + response.data.message;
                }
            })
            .catch(error => {
                this.errorMessage = "Error connecting to server.";
                console.error("Error:", error);
            });
        }
    }
});
</script>

</body>
</html>
