<template>
<div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Faculty</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        </div>
        <div class="row card">
            <div class="col-md-12 card-body">
                <h4>--</h4>
                <hr>
                <button type="button" @click="showAddModal()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> ADD</button>
                <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in faculties" :key="idx">
                        <tr class="tr-shadow">
                            <td><strong>{{ list.name }}</strong>
                            </td>
                            <td><span>{{ list.position }}</span></td>
                           
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"  @click="editFaculty(list)">
                                        <span class="fa fa-edit"></span>
                                        Edit
                                    </button>
                                    <!-- <button class="btn btn-sm btn-secondary" @click="deleteFaculty(list)">
                                        <span class="fa fa-trash"></span>
                                        Delete
                                    </button> -->
                                </div>
                                
                            </td>
                        </tr>
                        <tr class="spacer"></tr>
                        
                    </tbody>
                </data-table>
                <div class="col-md-12">
                    <div class="pull-right">
                        <pagination :pagination="pagination"
                            @prev="listFaculty(pagination.prevPageUrl)"
                            @next="listFaculty(pagination.nextPageUrl)"
                            v-show="noData(faculties)">
                        </pagination>
                    </div>
                    
                </div>

            </div>

            <div class="modal fade faculty" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4>Linkages</h4>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" v-model="post.name" class="form-control form-control-user" placeholder="Enter Name">
                                        <span class="errors-material" v-if="errors.name">{{errors.name[0]}}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input type="text" v-model="post.position" class="form-control form-control-user" placeholder="Enter Position">
                                        <span class="errors-material" v-if="errors.position">{{errors.position[0]}}</span>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" @click="saveFaculty()" class="btn btn-success">{{ btncap }}</button>
                            <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade delete-linkage">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h6>Faculty</h6>
                    </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    Do you want to delete <strong>{{ post.name }}</strong> ?
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <div class="btn-group">
                                <button type="button" @click="confirmDeleteFaculty(post)" class="btn btn-danger btn-sm">Yes</button>
                                <button type="button"  data-dismiss="modal" class="btn btn-secondary btn-sm">No</button>
                            </div>
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
        {label:'Name', name:'name'},
        {label:'Position', name:'position'},
        {label:'Action ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{
            btncap:"Save",
            errors:[],
            post:{},
            faculties:[],
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
        }
    },
    methods:{
        showAddModal(){
            $('.faculty').modal('show');
        },
        editFaculty(data){
            this.post = data;
            $('.faculty').modal('show');
        },
        deleteFaculty(data){
            this.post = data;
            $('.delete-faculty').modal('show');
        },
        saveFaculty(){
            if(this.post.id > 0){
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.btncap = "Saving...";
                this.$axios.put("api/faculty/"+this.post.id, this.post).then(res=>{
                    this.btncap = "Save";
                    this.$emit('show',{'message':'Faculty has been modified!', 'status':4});
                    this.post ={};
                    this.errors = [];
                    $('.faculty').modal('hide');
                    this.listFaculty();
                }).catch(err=>{
                    this.btncap = "Save";
                    this.errors = err.response.data.errors
                });
            });
            }else{
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                    this.btncap = "Saving...";
                    this.$axios.post("api/faculty", this.post).then(res=>{
                        this.$emit('show',{'message':'Faculty has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.post ={};
                        this.errors = [];
                        $('.faculty').modal('hide');
                        this.listFaculty();
                    }).catch(err=>{
                        this.btncap = "Save";
                        this.errors = err.response.data.errors
                    });
                });
            }
           
        },
        listFaculty(url='api/faculty'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.faculties = data.data.data;
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
                this.listFaculty();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        confirmDeleteFaculty(data){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.delete("api/faculty/"+data.id).then(res=>{
                    this.$emit('show',{'message':'Faculty has been deleted!', 'status':4});
                    this.post ={};
                    $('.delete-faculty').modal('hide');
                    this.listFaculty();
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

    },
    mounted() {
        this.listFaculty();
    },
}
</script>

<style>

</style>
