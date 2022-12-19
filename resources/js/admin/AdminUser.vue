<template>
<div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Administrator</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        </div>

        <div class="row card">
            <div class="col-md-12 card-body">
                <h4>--</h4>
                <hr>
                <button type="button" @click="showAddModal()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> ADD</button>
                <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in users" :key="idx">
                        <tr class="tr-shadow">
                            <!-- <td>
                                <img class="img-thumbnail logo-sc" :src="list.image == null ? '../img/logo.png' :'../storage/gallery/'+list.image" />
                                    <div class="">
                                        <a href="#" @click="showUpload(list)" >Edit </a>
                                </div>
                            </td> -->
                            <td><strong>{{ list.first_name }}</strong>
                            </td>
                            <td><span>{{ list.last_name }}</span></td>
                            <td><span>{{ list.email }}</span></td>
                            <td><span>{{ list.contact_number }}</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning"  @click="setAccount(list)">
                                        <span class="fa fa-edit"></span>
                                        Account Setup
                                    </button>
                                    <button class="btn btn-sm btn-success"  @click="editUser(list)">
                                        <span class="fa fa-edit"></span>
                                        Edit
                                    </button>
                                    <button class="btn btn-sm btn-secondary" @click="deleteUser(list)">
                                        <span class="fa fa-trash"></span>
                                        Delete
                                    </button>
                                </div>
                                
                            </td>
                        </tr>
                        <tr class="spacer"></tr>
                        
                    </tbody>
                </data-table>
                <div class="col-md-12">
                    <div class="pull-right">
                        <pagination :pagination="pagination"
                            @prev="listUser(pagination.prevPageUrl)"
                            @next="listUser(pagination.nextPageUrl)"
                            v-show="noData(users)">
                        </pagination>
                    </div>
                    
                </div>

            </div>

            <div class="modal fade user" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4>Administrator</h4>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
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
                                    <div class="form-group">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" v-model="post.contact_number" rows="5" placeholder="Enter Contact Number">
                                        <span class="errors-material" v-if="errors.contact_number">{{errors.contact_number[0]}}</span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" @click="saveUser()" class="btn btn-success">{{ btncap }}</button>
                            <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade delete-user">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h6>Users</h6>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    Do you want to delete <strong>{{ post.title }}</strong> ?
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <div class="btn-group">
                                <button type="button" @click="confirmDeleteUser(post)" class="btn btn-danger btn-sm">Yes</button>
                                <button type="button"  data-dismiss="modal" class="btn btn-secondary btn-sm">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="modal fade" id="upload-img" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Image</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="logo-view text-center">
                                        <img class="logo-upload" :src="upload.image == null ? '../img/logo.png' :'../storage/gallery/'+upload.image">
                                        <!-- <a href="#" @click="resetLogo()">Reset Default</a> -->
                                    </div>
                                </div>
                                <input type="file" id="uploader" accept="image/gif, image/jpeg" @change="uploadImage" class="hidden">
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" @click="browseImg()" class="btn btn-success mt-3">Browse Image</button>
                        </div>
                        
                    </div>
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
                                        <label>Email</label>
                                        <input type="text" v-model="post.email" class="form-control form-control-user" placeholder="Enter Email">
                                        <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span> 
                                    </div>

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
                            <button type="button" @click="saveConfirmedAccount()" class="btn btn-success">{{ btncap }}</button>
                            <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>
</template>

<script>
import DataTable from '../table/DataTable';
import PaginationVue from '../table/Pagination';

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
    components:{
        Datepicker,
        dataTable:DataTable,
        pagination:PaginationVue
    },
    setup() {
        // In case of a range picker, you'll receive [Date, Date]
        const format = (d) => {
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();

            return  month+ "-" + day  + "-" + year;
        }
        return {
            format,
        }
    },
    data(){
        let sortOrders = {};
        let columns =[
        {label:'First Name', name:'first_name'},
        {label:'Last Name', name:'last_name'},
        {label:'Email', name:'email'},
        {label:'Contact Number', name:'contact_number'},
        {label:'Action ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{
            upload:{},
            btncap:"Save",
            errors:[],
            post:{},
            users:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            btndis: false,
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                archive:0,
                dir:'desc',
                filter:0,
            },
            pagination:{
                lastPage:'',
                currentPage:'',
                total:'',
                lastPageUrl:'',
                nextPageurl:'',
                prevPageUrl:'',
                from:'',
                to:''
            },
            form: new FormData,
            uploadPercentage_:0,
            showbar:false,
        }
    },
    methods:{
        showAddModal(){
            $('.user').modal('show');
        },
        editUser(data){
            this.post = data;
            $('.user').modal('show');
        },
        deleteUser(data){
            this.post = data;
            $('.delete-user').modal('show');
        },
        showUpload(data){
            this.upload = data
            $('#upload-img').modal('show');
        },
        saveUser(){
            if(this.post.id > 0){
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.btncap = "Saving...";
                this.$axios.put("api/user/"+this.post.id, this.post).then(res=>{
                    this.btncap = "Save";
                    this.$emit('show',{'message':'User has been modified!', 'status':4});
                    this.post ={};
                    this.errors = [];
                    $('.user').modal('hide');
                    this.listUser();
                }).catch(err=>{
                    this.btncap = "Save";
                    this.errors = err.response.data.errors
                });
            });
            }else{
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                    this.btncap = "Saving...";
                    this.$axios.post("api/user", this.post).then(res=>{
                        this.$emit('show',{'message':'User has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.post ={};
                        this.errors = [];
                        $('.user').modal('hide');
                        this.listUser();
                    }).catch(err=>{
                        this.btncap = "Save";
                        this.errors = err.response.data.errors
                    });
                });
            }
           
        },
        listUser(url='api/user'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.users = data.data.data;
                        this.configPagination(data.data);
                    }else{
                        this.not_found = true;
                    }
                });
            });
        },
        configPagination(data){
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key){
            if(key != null){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.listUser();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        confirmDeleteUser(data){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.delete("api/user/"+data.id).then(res=>{
                    this.$emit('show',{'message':'User has been deleted!', 'status':4});
                   
                    this.post ={};
                    $('.delete-user').modal('hide');
                    this.listUser();
                });
            });
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        browseImg(){
            $('#uploader').click();
        },
        uploadImage(e){
            this.img = e.target.files[0];
            this.uploadLogo();
        },
        uploadLogo(){
            this.form.append('image', this.img);
            this.form.append('id',  this.upload.id);
             const config = {
                header:{'Content-Type':'multipart/form-data'},
                    onUploadProgress:(e)=>{
                        this.uploadPercentage_ = parseInt(Math.round((e.loaded * 100)/ e.total));
                        this.showbar = true;
                    }
                };
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.post('api/user-upload',this.form, config).then(res=>{
                    this.showbar = false;
                    this.uploadPercentage_ = 0;
                    this.listUser();
                    $('#upload-img').modal('hide');
                }).catch(err=>{
                    this.uploadPercentage_ = 0;
                });
            });
        
        },
        setAccount(data){
            this.post = data;
            $('.password').modal('show');
        },

        saveConfirmedAccount(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap = "Saving..."
                this.$axios.post('api/user-account', this.post).then(res=>{
                    this.post = {};
                    this.btncap = "Save";
                    $('.password').modal('hide');
                }).catch(err=>{
                    this.btncap = "Save";
                    this.errors = err.response.data.errors
                });
            });
        }
        
    },
    mounted() {
        this.listUser();
    },
}
</script>

<style>

</style>
