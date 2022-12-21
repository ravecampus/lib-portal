<template>
    <div class="row">
        <div class="col-md-12">
            <h4>Books</h4>
             <input type="text" class="form-control" v-model="tableData.search"  @input="listBook()" placeholder="Search....">
            <hr>
            <button type="button" @click="showAddModal()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> ADD</button>
            <data-table class="mt-5" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                <tbody v-for="(list, idx) in books" :key="idx">
                    <tr class="tr-shadow">
                        <td><strong>{{ list.title }}</strong>
                        </td>
                        <td><span class="status--process">{{ list.author }}</span></td>
                        <td><span>{{ list.copyright }}</span></td>
                        <td><span>{{ list.publisher }}</span></td>
                        <td><span class="text-muted">{{ list.isbn }}</span></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-success"  @click="editBook(list)">
                                    <span class="fa fa-edit"></span>
                                    Edit
                                </button>
                                <!-- <button class="btn btn-sm btn-secondary" @click="deleteBook(list)">
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
                        @prev="listBook(pagination.prevPageUrl)"
                        @next="listBook(pagination.nextPageUrl)"
                        v-show="noData(books)">
                    </pagination>
                </div>
                
            </div>

        </div>

         <div class="modal fade books" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Books</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                    <label>Title</label>
                                   <textarea v-model="post.title" class="form-control form-control-user"
                                    placeholder="Enter Title"></textarea>
                                    <span class="errors-material" v-if="errors.title">{{errors.title[0]}}</span>
                                    
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Author</label>
                                        <input type="text" v-model="post.author" class="form-control form-control-user" placeholder="Enter Author">
                                        <span class="errors-material" v-if="errors.author">{{errors.author[0]}}</span>
                                    </div>
                                
                                    <div class="form-group col-md-6">
                                        <label>Copyright</label>
                                        <input type="text" v-model="post.copyright" class="form-control form-control-user" placeholder="Enter Copyright">
                                        <span class="errors-material" v-if="errors.copyright">{{errors.copyright[0]}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Publisher</label>
                                        <input type="text" v-model="post.publisher" class="form-control form-control-user" placeholder="Enter Publisher">
                                        <span class="errors-material" v-if="errors.publisher">{{errors.publisher[0]}}</span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>ISBN</label>
                                        <input type="text" v-model="post.isbn" class="form-control form-control-user" placeholder="Enter ISBN">
                                        <span class="errors-material" v-if="errors.isbn">{{errors.isbn[0]}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" @click="saveBook()" class="btn btn-success">{{ btncap }}</button>
                        <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade delete-books">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h6>Books</h6>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                Do you want to delete <strong>{{ post.title }}</strong> ?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <div class="btn-group">
                            <button type="button" @click="confirmDeleteBook(post)" class="btn btn-danger btn-sm">Yes</button>
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

export default {
    components:{
        dataTable:DataTable,
        pagination:PaginationVue
    },
    data(){
        let sortOrders = {};
        let columns =[
        {label:'Title', name:'title'},
        {label:'Author', name:'author'},
        {label:'Copyright', name:'copyright'},
        {label:'Publisher', name:'publisher'},
        {label:'ISBN', name:'isbn'},
        {label:'Action ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });

        return{
            btncap:"Save",
            errors:[],
            post:{},
            books:[],
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
            $('.books').modal('show');
        },
        editBook(data){
            this.post = data;
            $('.books').modal('show');
        },
        deleteBook(data){
            this.post = data;
            $('.delete-books').modal('show');
        },
        saveBook(){
            if(this.post.id > 0){
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.btncap = "Saving...";
                this.$axios.put("api/book/"+this.post.id, this.post).then(res=>{
                    this.btncap = "Save";
                    this.$emit('show',{'message':'Book has been modified!', 'status':4});
                    this.post ={};
                    this.errors = [];
                    $('.books').modal('hide');
                    this.listBook();
                }).catch(err=>{
                    this.btncap = "Save";
                    this.errors = err.response.data.errors
                });
            });
            }else{
                this.$axios.get("sactum/cookie-csrf").then(response=>{
                    this.btncap = "Saving...";
                    this.$axios.post("api/book", this.post).then(res=>{
                        this.$emit('show',{'message':'Book has been saved!', 'status':4});
                        this.btncap = "Save";
                        this.post ={};
                        this.errors = [];
                        $('.books').modal('hide');
                        this.listBook();
                    }).catch(err=>{
                        this.btncap = "Save";
                        this.errors = err.response.data.errors
                    });
                });
            }
           
        },
        listBook(url='api/book'){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.books = data.data.data;
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
                this.listBook();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        confirmDeleteBook(data){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.delete("api/book/"+data.id).then(res=>{
                    this.$emit('show',{'message':'Book has been deleted!', 'status':4});
                   
                    this.post ={};
                    $('.delete-books').modal('hide');
                    this.listBook();
                });
            });
        }

    },
    mounted() {
        this.listBook();
    },
}
</script>

<style>

</style>
