<div class="container" id="app">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
           <div class="card ">
           <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
           <h1 class="text-center" >HELPDESK</h1>
            <div class="card-body">
            <!-- <form > -->
                <h2 >Login</h2>
                   <label >Email</label>
                   <input class="form-control" v-model="email" placeholder="Enter Email" required>
                   <label >Password</label>
                <input class="form-control" type="password" v-model="password" placeholder="Enter Password" required >
                <button class="btn btn-info mt-4" type="submit" @click="login" >Login</button>
            <!-- </form> -->

            <p class="mt-3 text-center">
                Don't have an account?
                <a href="http://localhost/Helpdesk-Upgraded/register">Sign up here</a>
            </p>
        </div>
     </div>
 </div>
</div>


<!-- Vue.JS for AJAX Login -->

<script src="assets/js/app/login.js"></script>


