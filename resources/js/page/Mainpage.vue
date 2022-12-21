<template>
    <div id="wrapper">

       

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <h5>Library Portal</h5>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <router-link class="nav-link" :to="{name:'login'}">
                                <span class="mr-2 d-none d-lg-inline text-gray-600">Login</span>
                            </router-link>
                        </li>
                       
                        <li class="nav-item dropdown no-arrow">
                            <router-link class="nav-link" :to="{name:'register'}">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Register </span>
                            </router-link>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>

                    </ul>

                </nav>
                <div class="container h-div text-center">
                        <h1>LIBRARY PORTAL OF KABACAN PILOT CENTRAL ELEMENTARY SCHOOL</h1>
                        <h4>KABACAN, COTABATO</h4>
                    
                    <div class="d-flex justify-content-center mb-4">
                       
                       <img class="w-50" :src="'../img/logo.png'" />
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            user:{},
            auth:false,
        }
    },
    methods: {
        logout(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } 
                    })
                    .catch(function (error) {
                     
                    });
            })
        },
    },
    mounted(){
        if(window.Laravel.isLoggedin){
            this.user = window.Laravel.user;
            this.auth = true;
        }

          if(window.Laravel.isLoggedin){
                let user = window.Laravel.user;
                if(user.role == 3){
                    this.$router.push({name:'admindashboard'})
                }else if(user.role == 1 || user.role == 0 || user.role == 2){
                     this.$router.push({name:'userdashboard'})
                }
            }
        
    }
}
</script>

<style>

</style>
