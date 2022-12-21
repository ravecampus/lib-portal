<template>
    <div class="row">
        <div class="col-md-12 text-center">
            <h4>Library Events</h4>
            <div class="row mt-4 d-flex justify-content-center">
                <div class="card shadow-sm mt-1 col-md-4 mr-1" v-for="(list, index) in events" :key="index">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <img :src="list.image == null ? '../img/logo.png' :'../storage/event/'+list.image"
                                    class="card-img-top"
                                    alt="Waterfall"
                                />
                                <h4>{{ list.title }}</h4>
                                <div class="card card-body shadow">
                                    <p>{{ list.description }}</p>
                                </div>
                            </div>
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
            events:[],
            profile:{},
            tableData:{
                draw:0,
                length:1000,
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
         listEvent(url='api/event'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.events = data.data.data;
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
                this.listEvent();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        confirmDeleteEvent(data){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.delete("api/event/"+data.id).then(res=>{
                    this.$emit('show',{'message':'Event has been deleted!', 'status':4});
                   
                    this.post ={};
                    $('.delete-event').modal('hide');
                    this.listEvent();
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
        this.listEvent();
    },
}
</script>

<style>

</style>
