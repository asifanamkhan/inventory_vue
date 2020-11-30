<template>
    <div>
        <div class="card axiosForm">
            <div class="spinner" v-show="loading"></div>
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">category</i>
                </div>
                <h4 class="card-title">Add Category</h4>
            </div>
            <div class="card-body ">
                <form @submit.prevent="categoryInsert">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Category name</label>
                            <input  v-model="form.category_name" type="text" class="form-group form-control" placeholder="category name">
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
        name: "create",
        mounted(){
            if (! User.loggedIn()){
                this.$router.push({name: '/'})
            }
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
            categoryInsert(){
                this.loading = true;
                axios.post('/api/category',this.form)
                    .then(response=>{
                        // console.log(response.data);
                        this.$router.push({name: 'allCategory'});
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Category added successfully',
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