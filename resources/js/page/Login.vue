<template>
    
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image-cus"></div>
                            <div class="col-lg-6">
                            
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><strong>{{ title }} </strong></h1>
                                        <h3 class="h4 text-gray-900 mb-4">Welcome Back!</h3>
                                    </div>
                                    <div class="alert alert-danger p-0" v-if="errors.main">
                                        <div class="alert errors-material m-0">
                                            <div v-if="errors.main"><strong>*</strong>{{errors.main[0]}}</div>
                                        </div>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" v-model="post.email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                                  <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" v-model="post.password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                                  <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="button" :disabled="btndis" @click="login()" class="btn btn-primary btn-user btn-block">
                                           {{btn}}
                                        </button>
                                        
                                    </form>
                                    <hr>
                                    <!-- <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div> -->
                                    <div class="text-center">
                                        <router-link class="small" :to="{name:'register'}">Create an Account!</router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</template>

<script>
export default {
    data(){
        return {
            title:"",
            post:{},
            errors:[],
            btn:'Login',
            btndis:false
        }
    },
    methods:{
        login(){
            let route = this.$route.query;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btndis = true
                this.btn = "Logging..."
                this.$axios.post('api/login', this.post).then(res=>{
                    this.btndis = false
                    this.btn = "Login"
                    // window.location.href = "/"
                    if(route.redir == undefined){
                        window.location.href = "/";
                    }
                    // else{
                    //     window.location.href = route.redir;
                    // }
                    this.post = {};
                }).catch(err=>{
                    this.btndis = false
                    this.btn = 'Login'
                    this.errors = err.response.data.errors
                });
            });
        }
    },
    mounted() {
        this.title = window.Title.app_name;
    },
}
</script>

<style>

</style>
