<template>
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <!-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button> -->

                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <h5>{{ title }}</h5>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto user">
                        <li class="nav-item dropdown no-arrow">
                            <router-link class="nav-link" :to="{name:'userdashboard'}">
                                <span class="mr-2 d-none d-lg-inline text-gray-600">Dashboard</span>
                            </router-link>
                        </li>
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
                                <router-link class="dropdown-item" :to="{name:'userbook'}">
                                    <i class="fas fa-book fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Books
                                </router-link>
                                <router-link class="dropdown-item" :to="{name:'userjournal'}">
                                    <i class="fas fa-newspaper fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Journals
                                </router-link>
                                <router-link class="dropdown-item"  :to="{name:'usermagazine'}">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                   Magazines
                                </router-link>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <router-link class="nav-link" :to="{name:'userservice'}">
                                <span class="mr-2 d-none d-lg-inline text-gray-600">Services </span>
                            </router-link>
                        </li>
                        <!-- <li class="nav-item dropdown no-arrow">
                            <a class="nav-link">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Faculties </span></a>
                        </li> -->
                         <li class="nav-item dropdown no-arrow">
                            <router-link class="nav-link" :to="{name:'usergallery'}">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Gallery </span>
                            </router-link>
                        </li>
                         <li class="nav-item dropdown no-arrow">
                            <router-link class="nav-link" :to="{name:'userlinkage'}">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Linkage</span>
                            </router-link>
                        </li>
                         <li class="nav-item dropdown no-arrow">
                            <router-link class="nav-link" :to="{name:'usercontact'}">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">Contact</span>
                            </router-link>
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
h2 {
	color: #000;
	font-size: 26px;
	font-weight: 300;
	text-align: center;
	text-transform: uppercase;
	position: relative;
	margin: 30px 0 60px;
}
h2::after {
	content: "";
	width: 100px;
	position: absolute;
	margin: 0 auto;
	height: 4px;
	border-radius: 1px;
	background: #cf05cf;
	left: 0;
	right: 0;
	bottom: -20px;
}
.carousel {
	margin: 50px auto;
	padding: 0 70px;
}
.carousel .item {
	color: #747d89;
	min-height: 325px;
	text-align: center;
	overflow: hidden;
}
.carousel .thumb-wrapper {
	padding: 25px 15px;
	background: #fff;
	border-radius: 6px;
	text-align: center;
	position: relative;
	box-shadow: 0 2px 3px rgba(0,0,0,0.2);
}
.carousel .item .img-box {
	height: 200px;
	margin-bottom: 20px;
	width: 100%;
	position: relative;
}
.carousel .item img {	
	max-width: 100%;
	max-height: 100%;
	display: inline-block;
	position: absolute;
	bottom: 0;
	margin: 0 auto;
	left: 0;
	right: 0;
}
.carousel .item h4 {
	font-size: 18px;
}
.carousel .item h4, .carousel .item p, .carousel .item ul {
	margin-bottom: 5px;
}
.carousel .thumb-content .btn {
	color: #cf05cf;
	font-size: 11px;
	text-transform: uppercase;
	font-weight: bold;
	background: none;
	border: 1px solid #cf05cf;
	padding: 6px 14px;
	margin-top: 5px;
	line-height: 16px;
	border-radius: 20px;
}
.carousel .thumb-content .btn:hover, .carousel .thumb-content .btn:focus {
	color: #fff;
	background: #cf05cf;
	box-shadow: none;
}
.carousel .thumb-content .btn i {
	font-size: 14px;
	font-weight: bold;
	margin-left: 5px;
}
.carousel .item-price {
	font-size: 13px;
	padding: 2px 0;
}
.carousel .item-price strike {
	opacity: 0.7;
	margin-right: 5px;
}
.carousel-control-prev, .carousel-control-next {
	height: 44px;
	width: 40px;
	background: #cf05cf;	
	margin: auto 0;
	border-radius: 4px;
	opacity: 0.8;
}
.carousel-control-prev:hover, .carousel-control-next:hover {
	background: #ff4dff;
	opacity: 1;
}
.carousel-control-prev i, .carousel-control-next i {
	font-size: 36px;
	position: absolute;
	top: 50%;
	display: inline-block;
	margin: -19px 0 0 0;
	z-index: 5;
	left: 0;
	right: 0;
	color: #fff;
	text-shadow: none;
	font-weight: bold;
}
.carousel-control-prev i {
	margin-left: -2px;
}
.carousel-control-next i {
	margin-right: -4px;
}		
.carousel-indicators {
	bottom: -50px;
}
.carousel-indicators li, .carousel-indicators li.active {
	width: 10px;
	height: 10px;
	margin: 4px;
	border-radius: 50%;
	border: none;
}
.carousel-indicators li {	
	background: rgba(0, 0, 0, 0.2);
}
.carousel-indicators li.active {	
	background: rgba(0, 0, 0, 0.6);
}
.carousel .wish-icon {
	position: absolute;
	right: 10px;
	top: 10px;
	z-index: 99;
	cursor: pointer;
	font-size: 16px;
	color: #abb0b8;
}
.carousel .wish-icon .fa-heart {
	color: #ff6161;
}
.star-rating li {
	padding: 0;
}
.star-rating i {
	font-size: 14px;
	color: #ffc000;
}
</style>
