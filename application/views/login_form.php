<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
           <div class="card ">
           <div id="errorMessage" class="alert alert-danger d-none"></div>
            <h1 class="text-center" >HELPDESK</h1>
            <div class="card-body">
            <form id='loginForm'>
                <h2 >Login</h2>
                   <label >User Name</label>
                   <input class="form-control" name="username" placeholder="Username" >
                   <label >Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password"  >
                <button class="btn btn-info mt-4" type="submit"  >Login</button>
            </form>
        </div>
     </div>
 </div>
</div>

<!-- JavaScript for AJAX Login -->

    <script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    let username = document.querySelector('input[name="username"]').value.trim();
    let password = document.querySelector('input[name="password"]').value.trim();

    if (!username || !password) {
        alert("Username and password are required!");
        return;
    }

    let formData = new URLSearchParams();
    formData.append("username", username);
    formData.append("password", password);

    fetch("http://localhost/restapi-helpdesk/index.php/auth/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest",
            "X-API-KEY": "api123" 
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        console.log("Response:", data);
        if (data.status) {
            localStorage.setItem("token", data.token);
            window.location.href = "dashboard";
        } else {
            alert("Login failed: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});
</script>
</body>
</html>
