<template>
    <div class="row">
        <div class="col-md-12">
            <h4>Journals</h4>
            <input type="text" class="form-control" v-model="tableData.search"  @input="listJournal()" placeholder="Search....">
            <hr>
            <button type="button" @click="showAddModal()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> ADD</button>
            <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                <tbody v-for="(list, idx) in journals" :key="idx">
                    <tr class="tr-shadow">
                        <td><strong>{{ list.journal_title }}</strong>
                        </td>
                        <td><span class="status--process">{{ list.volume }}</span></td>
                        <td><span>{{ formatDate(list.date_issued) }}</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-success"  @click="editJournal(list)">
                                    <span class="fa fa-edit"></span>
                                    Edit
                                </button>
                                <!-- <button class="btn btn-sm btn-secondary" @click="deleteJournal(list)">
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
                        @prev="listJournal(pagination.prevPageUrl)"
                        @next="listJournal(pagination.nextPageUrl)"
                        v-show="noData(journals)">
                    </pagination>
                </div>
                
            </div>

        </div>

         <div class="modal fade journal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Journals</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" v-model="post.journal_title" class="form-control form-control-user" placeholder="Enter Title">
                                    <span class="errors-material" v-if="errors.journal_title">{{errors.journal_title[0]}}</span>
                                    
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Volume</label>
                                        <input type="text" v-model="post.volume" class="form-control form-control-user" placeholder="Enter Volume">
                                        <span class="errors-material" v-if="errors.volume">{{errors.volume[0]}}</span>
                                    </div>
                                
                                    <div class="form-group col-md-6">
                                        <label>Date Issued</label>
                                         <Datepicker v-model="post.date_issued" placeholder="Date Issued" :format="format"/>
                                        <span class="errors-material" v-if="errors.date_issued">{{errors.date_issued[0]}}</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" @click="saveJournal()" class="btn btn-success">{{ btncap }}</button>
                        <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade delete-journal">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6>Journals</h6>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                Do you want to delete <strong>{{ post.journal_title }}</strong> ?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <div class="btn-group">
                            <button type="button" @click="confirmDeleteJournal(post)" class="btn btn-danger btn-sm">Yes</button>
                            <button type="button"  data-dismiss="modal" class="btn btn-secondary btn-sm">No</button>
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
        {label:'Title', name:'journal_title'},
        {label:'volume', name:'volume'},
        {label:'Date issued', name:'date_issued'},
        {label:'Action ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{
            btncap:"Save",
            errors:[],
            post:{},
            journals:[],
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
            $('.journal').modal('show');
        },
        editJournal(data){
            this.post = data;
            $('.journal').modal('show');
        },
        deleteJournal(data){
            this.post = data;
            $('.delete-journal').modal('show');
        },
        saveJournal(){
            if(this.post.id > 0){
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.btncap = "Saving...";
                this.$axios.put("api/journal/"+this.post.id, this.post).then(res=>{
                    this.btncap = "Save";
                    this.$emit('show',{'message':'Journal has been modified!', 'status':4});
                    this.post ={};
                    this.errors = [];
                    $('.journal').modal('hide');
                    this.listJournal();
                }).catch(err=>{
                    this.btncap = "Save";
                    this.errors = err.response.data.errors
                });
            });
            }else{
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                    this.btncap = "Saving...";
                    this.$axios.post("api/journal", this.post).then(res=>{
                        this.$emit('show',{'message':'Journal has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.post ={};
                        this.errors = [];
                        $('.journal').modal('hide');
                        this.listJournal();
                    }).catch(err=>{
                        this.btncap = "Save";
                        this.errors = err.response.data.errors
                    });
                });
            }
           
        },
        listJournal(url='api/journal'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.journals = data.data.data;
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
                this.listJournal();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        confirmDeleteJournal(data){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.delete("api/journal/"+data.id).then(res=>{
                    this.$emit('show',{'message':'Journal has been deleted!', 'status':4});
                   
                    this.post ={};
                    $('.delete-journal').modal('hide');
                    this.listJournal();
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
        this.listJournal();
    },
}
</script>

<style>

</style>
