<template>
    <div class="row">
        <div class="col-md-12 mb-5">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <h5 class="text-center mb-3">School History</h5>
                            {{profile.school_history}}
                        </div>
                        <!-- <div class="col-md-4 p-5">
                            <ul class="list-group shadow ">
                                <li class="list-group-item">
                                    <h5 class="text-center mb-3"><strong>Faculties</strong></h5>
                                </li>
                                <li class="list-group-item p-2 text-center" v-for="(list, idx) in faculties" :key="idx" >
                                    <div> <strong> {{ list.name }}</strong></div>
                                    <small>{{ list.position }}</small>
                                </li>
                                <li class="list-group-item">
                                    <div class="pull-right">
                                        <pagination :pagination="pagination"
                                            @prev="listFaculty(pagination.prevPageUrl)"
                                            @next="listFaculty(pagination.nextPageUrl)"
                                            v-show="noData(faculties)">
                                        </pagination>
                                    </div>  
                                </li>
                            </ul>
                        </div> -->
                    </div>

                </div>
            </div>
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-center">Mission</h5>
                            <div class="row">
                                <div class="col-md-12 p-3">
                                    {{profile.mission}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-center">Vision</h5>
                             <div class="row">
                                <div class="col-md-12 p-3">
                                    {{profile.vision}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h5 class="text-center">Rules and Regulations</h5>
                    <div class="row">
                        <div class="col-md-12 p-3">
                            {{profile.rules_regulation }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PaginationVue from '../table/Pagination';
export default {
    components:{
        pagination:PaginationVue
    },
    data(){
        return{
            faculties:[],
            profile:{},
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                archive:0,
                dir:'asc',
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
        getProfile(){
             this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.get("api/lib-profile").then(res=>{
                    this.profile = res.data;
                });
            });
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
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },

    },
    mounted() {
        this.getProfile();
        this.listFaculty();
    },
}
</script>

<style>

</style>
