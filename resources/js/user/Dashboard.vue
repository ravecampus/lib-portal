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

                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <h5>{{ title }}</h5>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <router-link class="nav-link" :to="{name:'userhome'}">
                                <span class="mr-2 d-none d-lg-inline text-gray-600">About</span>
                            </router-link>
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600">Resources / Collection</span>
                               
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-book fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Books
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-newspaper fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Journals
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                   Magazines
                                </a>
                                <!-- <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a> -->
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Services </span></a>
                        </li>
                        <!-- <li class="nav-item dropdown no-arrow">
                            <a class="nav-link">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Faculties </span></a>
                        </li> -->
                         <li class="nav-item dropdown no-arrow">
                            <a class="nav-link">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Gallery </span></a>
                        </li>
                         <li class="nav-item dropdown no-arrow">
                            <a class="nav-link">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Linkage</span></a>
                        </li>
                         <li class="nav-item dropdown no-arrow">
                            <a class="nav-link">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Contact</span></a>
                        </li>
         
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow" v-if="auth">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ user.first_name+" "+user.last_name }}</span>
                                <img class="img-profile rounded-circle"
                                    :src="'../img/undraw_profile.svg'">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <router-link class="dropdown-item" :to="{name:'userprofile'}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" @click="logout()">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                 <flashmessage :message="message" :status="status"></flashmessage>
                <div class="container h-div">
                    <router-view @show="flashMessage"></router-view>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import FlashMessage from '../page/FlashMessage.vue';
export default {
    components:{
        flashmessage: FlashMessage
    },
    data(){
        return{
            user:{},
            auth:false,
            message:'',
            status:0,
            title:'',
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
        flashMessage(data){
             this.showMessage(data)
        },
        showMessage(data){
            this.message = data.message;
            if(data.status == 1){
                this.status = 'alert-success';
            }else if(data.status == 2){
                this.status = 'alert-warning';
            }else if(data.status == 3){
                this.status = 'alert-danger';
            }else if(data.status == 4){
                this.status = 'alert-secondary';
            }else if(data.status == 5){
                this.status = 'alert-dark';
            }else if(data.status == 6){
                this.status = 'alert-light';
            }else if(data.status == 7){
                this.status = 'alert-primary';
            }
            $('.fm-body').show();
            setTimeout(() => {
                $('.fm-body').fadeOut("slow");
            }, 500);
        },
    },
    mounted(){
        if(window.Laravel.isLoggedin){
            this.user = window.Laravel.user;
            this.auth = true;
        }

        this.title = window.Title.app_name;
    }
}
</script>

<style>

</style>
