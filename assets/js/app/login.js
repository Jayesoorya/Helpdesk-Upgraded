new Vue({
    el: "#app",
    data() {
        return {
            email: '',
            password: '',
            errorMessage: ''
        };
    },
    methods: {
        login() {
            if (!this.email || !this.password) {
                this.errorMessage = "Email and password are required!";
                return;
            }

            axios.post("http://localhost/Helpdesk-Upgraded/login", 
            {
                email: this.email,
                password: this.password
            }, 
            {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-Requested-With": "XMLHttpRequest",
                    //"X-API-KEY": "api123"
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