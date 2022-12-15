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
                        <textarea class="form-control" rows="5" placeholder="Description..."></textarea>
                    </div>
                </div>
                 <div class="card mb-1 shadow-sm">
                  
                    <div class="card-body">
                        <h5>Vission</h5>
                        <textarea class="form-control" placeholder="Content..." rows="3"></textarea>
                    </div>
                  
                </div>
                 <div class="card mb-1 shadow-sm">
                     <div class="card-body">
                        <h5>Mission</h5>
                        <textarea class="form-control" placeholder="Content..." rows="3"></textarea>
                    </div>
                </div>
                <div class="card mb-3 shadow-sm">
                     <div class="card-body">
                        <h5>Core Value</h5>
                        <textarea class="form-control" placeholder="Content..." rows="2"></textarea>
                    </div>
                </div>
                <div class="btn-group mb-5">
                    <button type="button" class="btn btn-primary pull-right">Save</button>
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

        }
    }
}
</script>

<style>

</style>
