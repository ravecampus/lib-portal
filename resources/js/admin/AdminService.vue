<template>
<div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Program & Services</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        </div>

        <div class="row card">
            <div class="col-md-12 card-body">
                <h4>--</h4>
                <hr>
                <button type="button" @click="showAddModal()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> ADD</button>
                <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in services" :key="idx">
                        <tr class="tr-shadow">
                            <td>
                                <img class="img-thumbnail logo-sc" :src="list.image == null ? '../img/logo.png' :'../storage/service/'+list.image" />
                                    <div class="">
                                        <a href="#" @click="showUpload(list)" >Edit </a>
                                </div>
                            </td>
                            <td><strong>{{ list.title }}</strong>
                            </td>
                            <td><span>{{list.description }}</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"  @click="editService(list)">
                                        <span class="fa fa-edit"></span>
                                        Edit
                                    </button>
                                    <button class="btn btn-sm btn-secondary" @click="deleteService(list)">
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
                            @prev="listService(pagination.prevPageUrl)"
                            @next="listService(pagination.nextPageUrl)"
                            v-show="noData(services)">
                        </pagination>
                    </div>
                    
                </div>

            </div>

            <div class="modal fade service" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4>Services</h4>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" v-model="post.title" class="form-control form-control-user" placeholder="Enter Title">
                                        <span class="errors-material" v-if="errors.title">{{errors.title[0]}}</span> 
                                    </div>
                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" v-model="post.description" rows="5" placeholder="Description..."></textarea>
                                        <span class="errors-material" v-if="errors.description">{{errors.description[0]}}</span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" @click="saveService()" class="btn btn-success">{{ btncap }}</button>
                            <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade delete-service">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h6>Services</h6>
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
                                <button type="button" @click="confirmDeleteService(post)" class="btn btn-danger btn-sm">Yes</button>
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
                                        <img class="logo-upload" :src="upload.image == null ? '../img/logo.png' :'../storage/service/'+upload.image">
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
        {label:'Image', name:null},
        {label:'Title', name:'title'},
        {label:'Description', name:'description'},
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
            services:[],
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
            $('.service').modal('show');
        },
        editService(data){
            this.post = data;
            $('.service').modal('show');
        },
        deleteService(data){
            this.post = data;
            $('.delete-service').modal('show');
        },
        showUpload(data){
            this.upload = data
            $('#upload-img').modal('show');
        },
        saveService(){
            if(this.post.id > 0){
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.btncap = "Saving...";
                this.$axios.put("api/service/"+this.post.id, this.post).then(res=>{
                    this.btncap = "Save";
                    this.$emit('show',{'message':'Services has been modified!', 'status':4});
                    this.post ={};
                    this.errors = [];
                    $('.service').modal('hide');
                    this.listService();
                }).catch(err=>{
                    this.btncap = "Save";
                    this.errors = err.response.data.errors
                });
            });
            }else{
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                    this.btncap = "Saving...";
                    this.$axios.post("api/service", this.post).then(res=>{
                        this.$emit('show',{'message':'Services has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.post ={};
                        this.errors = [];
                        $('.service').modal('hide');
                        this.listService();
                    }).catch(err=>{
                        this.btncap = "Save";
                        this.errors = err.response.data.errors
                    });
                });
            }
           
        },
        listService(url='api/service'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.services = data.data.data;
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
                this.listService();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        confirmDeleteService(data){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.delete("api/service/"+data.id).then(res=>{
                    this.$emit('show',{'message':'Services has been deleted!', 'status':4});
                   
                    this.post ={};
                    $('.delete-service').modal('hide');
                    this.listService();
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
                this.$axios.post('api/service-upload',this.form, config).then(res=>{
                    this.showbar = false;
                    this.uploadPercentage_ = 0;
                    this.listService();
                    $('#upload-img').modal('hide');
                }).catch(err=>{
                    this.uploadPercentage_ = 0;
                });
            });
        
        }
    },
    mounted() {
        this.listService();
    },
}
</script>

<style>

</style>
