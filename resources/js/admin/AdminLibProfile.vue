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
                <button class="btn btn-primary btn-sm shadow-sm"></button>
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
        {label:'Order Number', name:'order_number'},
        {label:'Total', name:null},
        {label:'Delivery Fee', name:null},
        {label:'Grand Total', name:null},
        {label:'Items', name:null},
        {label:'Status', name:null},
        {label:'Order Date', name:'created_at'},
        {label:' ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{

        }
    }
}
</script>

<style>

</style>
