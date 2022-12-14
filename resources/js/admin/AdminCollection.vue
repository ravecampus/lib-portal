<template>
     <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Resource / Collection</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-sm shadow-sm" @click="showModalAddCollection()"> ADD</button>
                <div class="row menu-container d-flex justify-content-center mt-2 card card-body shadow-sm">
                    
                    <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                        <tbody v-for="(list, idx) in collects" :key="idx">
                                <tr class="tr-shadow">
                                    <td>{{ list.title }}
                                    </td>
                                    <td><span class="status--process">{{ list.description }}</span></td>
                                    <td><span class="text-muted">{{ formatDate(list.created_at) }}</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top"  @click="payOrder(list)" title="Pay with Paypal">
                                                Pay
                                            </button>
                                            <button class="btn btn-sm btn-secondary" @click="showCancelOrder(list)" data-toggle="tooltip" data-placement="top" title="Cancel Orders">
                                                Cancel
                                            </button>
                                        </div>
                                        <!-- <div class="btn-group">
                                            <button class="btn btn-sm btn-primary" v-if="list.status == 2  && list.payment_mode == 2" data-toggle="tooltip" data-placement="top"  @click="setStatusForHistory(list)" title="Pay with Paypal">
                                                Finish
                                            </button>
                                            <button class="btn btn-sm btn-primary" v-if="list.status == 3 && list.payment_mode == 1" @click="setStatusForHistory(list)" data-toggle="tooltip" data-placement="top" title="Cancel Orders">
                                                Received
                                            </button>
                                        </div> -->
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                
                            </tbody>
                        </data-table>
                        <div class="col-md-12">
                            <div class="pull-right">
                                <pagination :pagination="pagination"
                                    @prev="listCollection(pagination.prevPageUrl)"
                                    @next="listCollection(pagination.nextPageUrl)"
                                    v-show="noData(collects)">
                                </pagination>
                            </div>
                            
                        </div>
                </div>
            </div>
        </div>

        <div class="modal fade lib-profile" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                    <input type="text" v-model="post.title" class="form-control form-control-user"
                                        placeholder="Enter Title">
                                </div>
                                <div class="form-group">
                                    <textarea v-model="post.description" class="form-control form-control-user"
                                    placeholder="Enter Description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" @click="saveCollection()" class="btn btn-primary btn-sm">Save</button>
                        <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
                    </div>
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
        let sortOrders = {};
        let columns =[
        {label:'Title', name:'title'},
        {label:'Description', name:'description'},
        {label:'Date', name:'created_at'},
        {label:'Action ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{
            post:{},
            collects:[],
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
    methods: {
        showModalAddCollection(){
            $('.lib-profile').modal('show');
        },
        saveCollection(){
            this.$axios.get('csrf-cookie/sanctum').then(res=>{
                this.$axios.post('api/collection', this.post).then(res=>{

                });
            });
        },

        listCollection(url='api/collection'){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.collects = data.data.data;
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
                this.listCollection();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
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
        this.listCollection();
    },
}
</script>

<style>

</style>
