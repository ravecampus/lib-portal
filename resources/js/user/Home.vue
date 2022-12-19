<template>
    <div class="row">
        <div class="col-md-12 mb-5">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h5 class="text-center">School History</h5>
                    <div class="row">
                        <div class="col-md-12 p-5">
                            {{profile.school_history}}
                        </div>
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
export default {

    data(){
        return{
            profile:{}
        }
    },
    methods: {
        getProfile(){
             this.$axios.get("sactum/cookie-csrf").then(response=>{
                this.$axios.get("api/lib-profile").then(res=>{
                    this.profile = res.data;
                });
            });
        }
    },
    mounted() {
        this.getProfile();
    },
}
</script>

<style>

</style>
