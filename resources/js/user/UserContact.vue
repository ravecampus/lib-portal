<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                     
                        <h6>Comment / Suggestion</h6>
                        <div class="form-group">
                            <textarea class="form-control" v-model="post.message" rows="5" placeholder="Message..."></textarea>
                            <span class="errors-material" v-if="errors.message">{{errors.message[0]}}</span>
                        </div>
                        <div class="btn-group mb-5">
                            <button type="button" :disabled="btndis" @click="saveComment()" class="btn btn-primary pull-right">{{btncap}}</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12 mt-3">
                <div class="card card-sm mt-1 shadow-sm" v-for="(list,indx) in comments" :key="indx">
                    <div class="card-body">
                         <img class="img-thumbnail logo-sc mr-2" :src="'../img/logo.png'" />
                        <strong>{{ list.first_name }},  {{ list.last_name }}</strong> : {{ list.message }} <small> ({{ formatDate(list.created_at) }})</small>
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
            post:{},
            btncap:"Send",
            errors:[],
            comments:[],
            btndis:false,
        }
    },
    methods: {
        saveComment(){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.btncap = "Sending";
                this.btndis = true;
                this.$axios.post("api/comment", this.post).then(res=>{
                    this.$emit('show',{'message':'Message sent!', 'status':4});
                    this.btncap = "Send";
                    this.post ={};
                    this.errors = [];
                    this.listComment();
                    this.btndis = false;
                }).catch(err=>{
                    this.btncap = "Send";
                    this.btndis = false;
                    this.errors = err.response.data.errors
                });
            });
        },
        listComment(){
            this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.get("api/comment").then(res=>{
                    this.comments = res.data;
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
    mounted(){
        this.listComment();
    }
}
</script>

<style>

</style>
