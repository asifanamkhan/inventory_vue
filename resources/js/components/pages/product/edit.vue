<template>
    <div>
        <div class="card axiosForm">
            <div class="spinner" v-show="loading"></div>
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">track_changes</i>
                </div>
                <h4 class="card-title">Update Product</h4>
            </div>
            <div class="card-body ">
                <form @submit.prevent="productUpdate">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Buying Date</label>
                            <input v-model="form.buying_date" type="date" class="form-control" placeholder="Root/Warehouse name">
                            <small class="text-rose" v-if="errors.buying_date" >{{errors.buying_date[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">.</label>
                            <input  v-model="form.product_name" type="text" class="form-control" placeholder="">
                            <small class="text-rose" v-if="errors.product_name" >{{errors.product_name[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input v-model="form.product_code" type="text" class="form-control" placeholder="Product code">
                            <small class="text-rose" v-if="errors.product_code" >{{errors.product_code[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input v-model="form.root" type="text" class="form-control" placeholder="Root/Warehouse name">
                            <small class="text-rose" v-if="errors.root" >{{errors.root[0]}}</small>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Select category</label>
                            <select class="form-control" v-model="form.category_id">
                                <option v-for="category in categories" :value="category.id">
                                    {{category.category_name}}
                                </option>
                            </select>
                            <small class="text-rose" v-if="errors.category_id" >{{errors.category_id[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Select supplier</label>
                            <select v-model="form.supplier_id" class="form-control">
                                <option v-for="supplier in suppliers" :value="supplier.id">
                                    {{supplier.name}}
                                </option>
                            </select>
                            <small class="text-rose" v-if="errors.supplier_id" >{{errors.supplier_id[0]}}</small>
                        </div>
                        <div class="form-group col-md-4">
                            <input v-model="form.product_quantity" type="number" class="form-control" placeholder="Product quantity">
                            <small class="text-rose" v-if="errors.product_quantity" >{{errors.product_quantity[0]}}</small>
                        </div>
                        <div class="form-group col-md-4">
                            <input v-model="form.buying_price" type="number" class="form-control" placeholder="Buying price">
                            <small class="text-rose" v-if="errors.buying_price" >{{errors.buying_price[0]}}</small>
                        </div>
                        <div class="form-group col-md-4">
                            <input v-model="form.selling_price" type="number" class="form-control" placeholder="Selling price">
                            <small class="text-rose" v-if="errors.selling_price" >{{errors.selling_price[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <textarea class="form-control" v-model="form.details" name="" id="" rows="7" placeholder="Details"></textarea>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-6">
                                <label for="">Image</label>
                                <input type="file" @change="onFileSelected" class="btn btn-round btn-rose">
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
                            <button type="submit" class="btn btn-fill btn-rose">Submit</button>
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
            axios.get('/api/product/'+this.$route.params.id,this.form)
                .then(response=>{
                    this.form = response.data;
                })
                .catch(error=>this.errors = error.response.data.errors)

            axios.get('/api/category')
                .then(response=>{
                    this.categories = response.data;
                })
                .catch(error=>this.categoryErrors = error.response.data.errors);

            axios.get('/api/supplier')
                .then(response=>{
                    this.suppliers = response.data;
                })
                .catch(error=>this.supplierErrors = error.response.data.errors)
                .finally(() =>{this.loading =  false});
        },
        data(){
            return{
                loading: false,
                form:{
                    category_id:'',
                    product_name:'',
                    product_code:'',
                    root:'',
                    buying_price:'',
                    selling_price:'',
                    supplier_id:'',
                    buying_date:'',
                    image:'',
                    product_quantity:'',
                    details:'',
                },
                errors:{},
                categoryErrors:{},
                supplierErrors:{},
                categories:{},
                suppliers:{},
            }
        },
        methods:{
            productUpdate(){
                this.loading = true;
                axios.patch('/api/product/'+this.$route.params.id,this.form)
                    .then(response=>{
                        // console.log(response.data);
                        this.$router.push({name: 'productDetails',params: { id: this.$route.params.id }});
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