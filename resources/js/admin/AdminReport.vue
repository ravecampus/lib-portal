<template>
<div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between d-print-none mb-4">
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        </div>

        <div class="row card mt-5">
            <div class="col-md-12 card-body">
                <!-- <h4>--</h4> -->
                  <div class="text-center d-none d-print-block mb-5">
                    <h4>LIBRARY PORTAL</h4>
                    <h4>KABACAN PILOT CENTRAL ELEMENTARY SCHOOL</h4>
                    <h5>KABACAN, COTABATO</h5>
                </div>
                <hr>
                <div class="row d-print-none">
                    <div class="col-md-3">
                        <button type="button" @click="printData()" class="btn btn-success btn-sm "><i class="fa fa-print"></i> Print</button>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" v-model="tableData.filter" @change="filterData()">
                            <option value="null">Filter</option>
                            <option value="0">Student</option>
                            <option value="1">Faculty</option>
                        </select>
                    </div>
                    
                   
                </div>
                <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in users" :key="idx">
                        <tr class="tr-shadow">
                            <td><strong>{{ list.first_name }}</strong>
                            </td>
                            <td><span>{{ list.last_name }}</span></td>
                            <td><span>{{ list.grade_level }}</span></td>
                            <td><span>{{ extractRole(list.role) }}</span></td>
                            <td><span>{{ list.email }}</span></td>
                            <td><span>{{ list.contact_number }}</span></td>
                      
                        </tr>
                        <tr class="spacer"></tr>
                        
                    </tbody>
                </data-table>
                <div class="col-md-12 d-print-none">
                    <div class="pull-right">
                        <pagination :pagination="pagination"
                            @prev="listUser(pagination.prevPageUrl)"
                            @next="listUser(pagination.nextPageUrl)"
                            v-show="noData(users)">
                        </pagination>
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
        {label:'First Name', name:null},
        {label:'Last Name', name:null},
        {label:'Grade Level', name:null},
        {label:'Role', name:null},
        {label:'Email', name:null},
        {label:'Contact Number', name:null},
        // {label:'Action ', name:null},
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
                filter:null,
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
        listUser(url='api/report'){
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
        printData(){
            window.print();
        },
        extractRole(num){
            return num== 0 ? "Student" :num== 1 ? "Faculty" :"Admin";
        },
        filterData(){
            this.listUser();
        }
    },
    mounted() {
        this.listUser();
    },
}
</script>

<style>

</style>
