<template>
     <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Library Profile</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-1 shadow-sm">
                    <div class="card-body">
                        <h5>School History</h5>
                        <textarea class="form-control" v-model="post.school_history" rows="5" placeholder="Description..."></textarea>
                    </div>
                </div>
                 <div class="card mb-1 shadow-sm">
                  
                    <div class="card-body">
                        <h5>Vission</h5>
                        <textarea class="form-control" v-model="post.vision" placeholder="Content..." rows="3"></textarea>
                    </div>
                  
                </div>
                 <div class="card mb-1 shadow-sm">
                     <div class="card-body">
                        <h5>Mission</h5>
                        <textarea class="form-control" v-model="post.mission" placeholder="Content..." rows="3"></textarea>
                    </div>
                </div>
                <div class="card mb-3 shadow-sm">
                     <div class="card-body">
                        <h5>Rules and Regulations</h5>
                        <textarea class="form-control" v-model="post.rules_regulation" placeholder="Content..." rows="2"></textarea>
                    </div>
                </div>
                <div class="btn-group mb-5">
                    <button type="button" :disabled="btndis" @click="saveProfile()" class="btn btn-primary pull-right">{{btncap}}</button>
                </div>
            </div>
        </div>
     </div>
</template>

<script>
import DataTable from '../table/DataTable';
import PaginationVue from '../table/Pagination';

export default {
    components:{
        dataTable:DataTable,
        pagination:PaginationVue
    },
    data(){
        
        return{
            post:{},
            btncap:"Save",
            btndis: false,
        }
    },
    methods: {
        loadProfile(){
            this.$axios.get("sanctum/csrf-cookie").then(response=>{
                this.$axios.get('api/lib-profile/'+ 1).then(res=>{
                   this.post = res.data;
                });
            });
        },
        saveProfile(){
            if(this.post.id > 0){
                this.$axios.get("sanctum/csrf-cookie").then(response=>{
                    this.btncap ="Saving...";
                    this.btndis = true;
                    this.$axios.put('api/lib-profile/'+ 1, this.post).then(res=>{
                        this.$emit('show',{'message':'Library Profile has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.btndis = false;
                        this.loadProfile();
                    }).catch(err=>{
                        this.btndis = false;
                        this.btncap = "Save";
                    });
                });
            }else{
                this.$axios.get("sanctum/csrf-cookie").then(response=>{
                    this.btncap ="Saving...";
                    this.btndis = true;
                    this.$axios.post('api/lib-profile/', this.post).then(res=>{
                        this.$emit('show',{'message':'Library Profile has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.btndis = false;
                        this.loadProfile();
                    }).catch(err=>{
                        this.btndis = false;
                        this.btncap = "Save";
                    });
                }); 
            }
            
        }
    },
    mounted() {
        this.loadProfile();
    },
}
</script>

<style>

</style>
