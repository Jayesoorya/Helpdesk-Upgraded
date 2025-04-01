<div class="container" id="app">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
           <div class="card ">
           <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
           <h1 class="text-center" >HELPDESK</h1>
            <div class="card-body">
            <!-- <form > -->
                <h2 >Login</h2>
                   <label >User Name</label>
                   <input class="form-control" v-model="username" placeholder="Username" required>
                   <label >Password</label>
                <input class="form-control" type="password" v-model="password" placeholder="Password" required >
                <button class="btn btn-info mt-4" type="submit" @click="login" >Login</button>
            <!-- </form> -->
        </div>
     </div>
 </div>
</div>

<!-- Vue.JS for AJAX Login -->

<script src="assets/js/app/login.js"></script>


