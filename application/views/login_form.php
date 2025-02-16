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
               <div class="bg-danger text-white text-center"><?php  echo validation_errors() ?></div>
<h1 class="text-center" >HELPDESK</h1>
<div class="card-body">
        <form  method="post" action="<?php echo site_url('auth/do_login'); ?>">
        <h2 >Login</h2>
            <label >User Name</label>
            <input class="form-control" name="username" placeholder="Username" >
            <label >Password</label>
            <input class="form-control" type="password" name="password" placeholder="Password"  >
            <button class="btn btn-info mt-4" type="submit" >Login</button>
        </form>
</div>
</body>
</html>
