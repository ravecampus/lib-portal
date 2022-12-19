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
                <router-link class="btn btn-secondary btn-sm shadow-sm mr-2" :to="{name:'books'}" >BOOKS</router-link>
                <router-link class="btn btn-secondary btn-sm shadow-sm mr-2" :to="{name:'journals'}">JOURNALS</router-link>
                <router-link class="btn btn-secondary btn-sm shadow-sm mr-2" :to="{name:'magazines'}">MAGAZINES</router-link>
                <div class="row menu-container d-flex justify-content-center mt-2 card card-body shadow-sm mt-3">
                    <flashmessage :message="message" :status="status"></flashmessage>
                    <router-view @show="flashMessage"></router-view>
                </div>
            </div>
        </div>

     </div>
</template>

<script>
import FlashMessage from '../page/FlashMessage.vue';

export default {
    components:{
        flashmessage: FlashMessage
    },
    data(){
        return{
            message:'',
            status:0,
        }
    },
    methods: {
      
        flashMessage(data){
             this.showMessage(data)
        },
        showMessage(data){
            this.message = data.message;
            if(data.status == 1){
                this.status = 'alert-success';
            }else if(data.status == 2){
                this.status = 'alert-warning';
            }else if(data.status == 3){
                this.status = 'alert-danger';
            }else if(data.status == 4){
                this.status = 'alert-secondary';
            }else if(data.status == 5){
                this.status = 'alert-dark';
            }else if(data.status == 6){
                this.status = 'alert-light';
            }else if(data.status == 7){
                this.status = 'alert-primary';
            }
            $('.fm-body').show();
            setTimeout(() => {
                $('.fm-body').fadeOut("slow");
            }, 500);
        },
    },
    mounted() {
        
    },
}
</script>

<style>

</style>
