new Vue({
    el: "#app",
    data: {
        user: {},
        current_password: '',
        new_password: '',
        message: '',
        error: ''
    },
    created() {
        this.loadProfile();
    },
    methods: {
        loadProfile() {
            const token = localStorage.getItem("token");
            axios.get("http://localhost/Helpdesk-Upgraded/get_profile", {

                headers: { "Authorization": `Bearer ${token}`,
                        "Content-Type": "application/x-www-form-urlencoded" }
            })
            .then(response => {
                if (response.data.status) {
                    this.user = response.data.user;
                } else {
                    this.error = response.data.message;
                }
            });
        },
        changePassword() {
            const token = localStorage.getItem("token");
            const form = new URLSearchParams();
            form.append('current_password', this.current_password);
            form.append('new_password', this.new_password);

            axios.post("http://localhost/Helpdesk-Upgraded/change", form, {
                headers: { "Authorization": `Bearer ${token}` }
            })
            .then(response => {
                if (response.data.status) {
                    this.message = response.data.message;
                    this.error = '';
                    this.current_password = '';
                    this.new_password = '';
                    window.location.href = 'loginview';
                } else {
                    this.message = '';
                    this.error = response.data.message;
                }
            });
        }
    }
});
