<template>
     
    <div class="mb-4">
        <h1 class="h3 text-gray-800 text-center mt-5">Profile</h1>
        <div class="text-center">
            <a class="text-primary" @click="showPassword()">Change Password?</a>
        </div>
        <div class="row mt-3">
            
            <div class="col-md-6 offset-md-3  card card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>First Name</label>
                        <input type="text" v-model="post.first_name" class="form-control form-control-user" placeholder="Enter First Name">
                        <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                        
                    </div>
                    <div class="form-group col-md-6">
                        <label>Last Name</label>
                        <input type="text" v-model="post.last_name" class="form-control form-control-user" placeholder="Enter Last Name">
                        <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                    </div>
                </div>
                 <div class="row">
                    <div class="form-group col-md-6">
                        <label>Contact Number</label>
                        <input type="text" v-model="post.contact_number" class="form-control form-control-user" placeholder="Enter Contact Number">
                        <span class="errors-material" v-if="errors.contact_number">{{errors.contact_number[0]}}</span>
                        
                    </div>
                    <div class="form-group col-md-6">
                        <label>Grade Level (Optional)</label>
                        <select class="form-control" v-model="post.grade_level">
                            <option value="1">Grade 1</option>
                            <option value="2">Grade 2</option>
                            <option value="3">Grade 3</option>
                            <option value="4">Grade 4</option>
                            <option value="5">Grade 5</option>
                            <option value="6">Grade 6</option>
                        </select>
                        <span class="errors-material" v-if="errors.grade_level">{{errors.grade_level[0]}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" v-model="post.email" class="form-control form-control-user" placeholder="Enter Email Address">
                    <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                </div>
                <button type="button" @click="updateProfile()" class="btn btn-primary mt-3">Save</button>
            </div>
        </div>

          <div class="modal fade password" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4>Account Setting</h4>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" v-model="post.password" class="form-control form-control-user" placeholder="Enter Password">
                                        <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span> 
                                    </div>
                                    <div class="form-group">
                                        <label>Password Confirmation</label>
                                        <input type="password" v-model="post.password_confirmation" class="form-control form-control-user" placeholder="Enter Password Confirmation">
                                        <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span> 
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" @click="savePassword()" class="btn btn-primary">Save</button>
                            <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
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
            post:{},
            errors:[],
        }
    },
    methods: {
        showPassword(){
            $('.password').modal('show');
        },
        savePassword(){
            this.$axios.get("sanctum/csrf-cookie").then(response=>{
                this.$axios.post('api/change-password', this.post).then(res=>{
                    this.post = res.data;
                    this.errors = [];
                     this.$emit('show',{'message':'Pasword has been change!', 'status':4});
                     $('.password').modal('hide');
                }).catch(err=>{
                    this.errors = err.response.data.errors
                });
            });
        },
        updateProfile(){
            this.$axios.get("sanctum/csrf-cookie").then(response=>{
                this.$axios.post('api/update-profile', this.post).then(res=>{
                    this.$emit('show',{'message':'Profile has been modified!', 'status':4});
                    this.post = res.data;
                    this.errors = [];
                }).catch(err=>{
                    this.errors = err.response.data.errors
                });
            });
        }
    },
    mounted(){
        if(window.Laravel.isLoggedin){
            this.post = window.Laravel.user;
            this.auth = true;
        }

        console.log(this.post)
    }
}
</script>

<style>

</style>
