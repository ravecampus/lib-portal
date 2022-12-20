<template>
    <div class="container">
        <h1 class="h3 text-gray-800 text-center mt-5">Gallery</h1>
        <div class="row mt-4 d-flex justify-content-center">

          <div class="col-lg-4 " v-for="(list, idx) in galleries" :key="idx">
            <div class="card shadow">
              <img
                 :src="list.image == null ? '../img/logo.png' :'../storage/gallery/'+list.image"
                class="card-img-top"
                alt="Waterfall"
              />
              <div class="card-body">
                <h5 class="card-title">{{ list.title }}</h5>
                <p class="card-text">
                 {{ list.description }}
                </p>
                <!-- <a href="#!" class="btn btn-primary">Button</a> -->
              </div>
            </div>
          </div>

        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            galleries:[],
            tableData:{
                draw:0,
                length:100,
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
         listGallery(url='api/gallery'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.galleries = data.data.data;
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
                this.listGallery();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
    },
    mounted() {
        this.listGallery();
    },
}
</script>

<style>

</style>
