<template>
    <div>
        <div class="card axiosForm">
            <div class="spinner" v-show="loading"></div>
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">accessibility</i>
                </div>
                <h4 class="card-title">Add Supplier</h4>
            </div>
            <div class="card-body ">
                <form @submit.prevent="supplierInsert">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input  v-model="form.name" type="text" class="form-control" placeholder="Full name">
                            <small class="text-rose" v-if="errors.name" >{{errors.name[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input v-model="form.email" type="email" class="form-control" placeholder="Email">
                            <small class="text-rose" v-if="errors.email" >{{errors.email[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input v-model="form.shop_name" type="text" class="form-control" placeholder="Shop name">
                            <small class="text-rose" v-if="errors.shop_name" >{{errors.shop_name[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input v-model="form.phone" type="text" class="form-control" placeholder="Phone number">
                            <small class="text-rose" v-if="errors.phone" >{{errors.phone[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <textarea class="form-control" v-model="form.address" name="" id="" rows="7" placeholder="Address"></textarea>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-6">
                                <label for="">Image</label>
                                <input type="file" @change="onFileSelected" class="btn btn-round btn-danger">
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="fileinput-new thumbnail img-raised">
                                    <img v-if="form.image === ''" style="height: 160px;width: 145px" src="image/person_8x10.png" rel="nofollow" alt="...">
                                    <img v-if="form.image !== ''" style="height: 160px;width: 145px" :src="form.image" rel="nofollow" alt="...">
                                </div>
                                <a v-if="form.image !== ''" @click.prevent="imgRemove" href="#" class="btn btn-danger btn-round"><i class="fa fa-times"></i> Remove</a>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-fill btn-danger">Submit</button>
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
                    name:'',
                    email:'',
                    address:'',
                    phone:'',
                    shop_name:'',
                    image:'',
                },
                errors:{}
            }
        },
        methods:{
            supplierInsert(){
                this.loading = true;
                axios.post('/api/supplier',this.form)
                    .then(response=>{
                        // console.log(response.data);
                        this.$router.push({name: 'allSupplier'});
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Supplier added successfully',
                            timeout: 2000,
                        }).show();
                    })
                    .catch(error=>this.errors = error.response.data.errors)
                    .finally(() =>{this.loading =  false});
            },
            onFileSelected(){
                let file = event.target.files[0];
                if(file.size > 2024770){
                    this.form.image = '';
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Uploaded image should be less then 2 mb ',
                        timeout: 2000,

                    }).show();
                }
                else{
                    let reader = new FileReader();
                    reader.onload = event =>{
                        this.form.image = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },
            imgRemove(){
                this.form.image = '';
            }
        }
    }
</script>

<style scoped>
    @import "/loder/loder.css";
    .spinner{
        width: 107%;
    }
</style>