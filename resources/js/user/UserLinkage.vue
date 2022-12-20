<template>
    <div class="mb-4">
        <h1 class="h3 text-gray-800 text-center mt-5">Linkages</h1>
        <div class="row mt-3">
            
            <div class="col-md-12 card card-body">
             
                  <ul class="list-inline">
                    <li class="list-inline-item"><h4><span class="fa fa-list"></span> List of linkages</h4></li>
                    <li class="list-inline-item">
                    
                    </li>
                  </ul>
                <div class="row mb-5">
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="tableData.search" @input="listLinkage()" placeholder="Search...">
                    </div>
                    <div class="col-md-4">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <data-table :sortKey="sortKey" >
                            <tbody>
                                <tr v-for = "(list, index) in linkages" :key="index" >
                                    
                                    <td>
                                        <small>Name : </small>
                                        <strong> {{ list.name }}</strong>
                                    </td>
                                    <td>
                                        <small>Position :</small>
                                       {{ list.position }}
                                    </td>
                                    <td>           
                                        <small>School :</small>
                                        {{ list.school }}
                                    </td>
                                    <td>           
                                        <small>Address :</small>
                                        {{ list.address }}
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td colspan="3" v-show="!noData(linkages)">
                                        No Result Found!
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                    </div>
                <div class="col-md-12">
                    <pagination :pagination="pagination"
                        @prev="listJournal(pagination.prevPageUrl)"
                        @next="listJournal(pagination.nextPageUrl)"
                        v-show="noData(linkages)">
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
export default {
    components:{
        dataTable:DataTable,
        pagination:PaginationVue
    },
    data(){
        return{
            linkages:[],
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
        listLinkage(url='api/linkage'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.linkages = data.data.data;
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
                this.listLinkage();
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
    mounted(){
        this.listLinkage();
    }
}
</script>

<style>

</style>
