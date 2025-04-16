new Vue({
    el: '#app',
    data: {
        form: {
            username: '',
            password: '',
            email: '',
            phone_number: ''
        },
        message: ''
    },
    methods: {
        register() {
            const formData = new FormData();
            formData.append('username', this.form.username);
            formData.append('password', this.form.password);
            formData.append('email', this.form.email);
            formData.append('phone_number', this.form.phone_number);

            axios.post('http://localhost/Helpdesk-Upgraded/sign_up', formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => {
                if (response.data.status) {
                    this.message = response.data.message;
                    this.form = { username: '', password: '', email: '', phone_number: '' };
                    window.location.href = 'loginview'; // redirect to login after success
                } else {
                    this.message = response.data.message;
                }
            })
            .catch(error => {
                this.message = "Error: " + error;
                console.error(error);
            });
        }
    }
});
