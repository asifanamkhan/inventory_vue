<template>
    <div>
        <div class="card axiosForm">
            <div class="spinner" v-show="loading"></div>
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">category</i>
                </div>
                <h4 class="card-title">Edit Category</h4>
            </div>
            <div class="card-body ">
                <form @submit.prevent="categoryUpdate">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Category name</label>
                            <input  v-model="form.category_name" type="text" class="form-group form-control" placeholder="Category name">
                            <small class="text-rose" v-if="errors.category_name" >{{errors.category_name[0]}}</small>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-fill btn-warning">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import User from "../../../helper/User";
    import Noty from 'noty';
    export default {
        name: "edit",
        mounted(){
            if (! User.loggedIn()){
                this.$router.push({name: '/'})
            }

        },
        created(){
            this.loading = true;
            axios.get('/api/category/'+this.$route.params.id,this.form)
                .then(response=>{
                    this.form = response.data;
                })
                .catch(error=>this.errors = error.response.data.errors)
                .finally(() =>{this.loading =  false});
        },
        data(){
            return{
                loading: false,
                form:{
                    category_name:'',
                },
                errors:{}
            }
        },
        methods:{
            categoryUpdate(){
                this.loading = true;
                axios.patch('/api/category/'+this.$route.params.id,this.form)
                    .then(response=>{
                        console.log(response.data);
                        this.$router.push({name: 'allCategory'});
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Updated successfully',
                            timeout: 2000,

                        }).show();
                    })
                    .catch(error=>this.errors = error.response.data.errors)
                    .finally(() =>{this.loading =  false});

            },

        }
    }
</script>

<style scoped>
    @import "/loder/loder.css";
    .spinner{
        width: 107%;
    }
</style>