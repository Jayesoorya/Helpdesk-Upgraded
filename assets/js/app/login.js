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

            axios.post("http://localhost/Helpdesk_vue.js/login", 
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