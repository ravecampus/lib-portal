<template>
     <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-login-image-cus"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><strong>{{ title }}</strong></h1>
                                <h3 class="h4 text-gray-900 mb-4">Create an Account!</h3>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="post.first_name" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="First Name">
                                     <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" v-model="post.last_name" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Last Name">
                                     <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" v-model="post.email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address">
                                     <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" v-model="post.password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                        <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" v-model="post.password_confirmation" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Password Confirmation">
                                        <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>

                                    </div>
                                </div>
                                <button type="button" :disabled="btndis" @click="register()" class="btn btn-primary btn-user btn-block">
                                    {{ btn }}
                                </button>
                            </form>
                            <hr>
                            <!-- <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div> -->
                            <div class="text-center">
                                <router-link class="small" :to="{name:'login'}">Already have an account? Login!</router-link>
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
        return{
            title:"",
            post:{},
            errors:[],
            btn:'Register Account',
            btndis: false,
        }
    },
    methods: {
         register(){
            this.$axios.get('sanctum/csrf-cookie').then(res=>{
                this.btn = 'Processing...'
                this.btndis = true
                this.$axios.post('api/register', this.post).then(res=>{
                    this.btndis = false
                    this.btn = 'Register Account'
                    this.$router.push({name:'login'});
                    this.post = {}
                }).catch(err=>{
                    this.btndis = false
                    this.btn = 'Register Account'
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
