<template>
    <div class=" axiosForm">
        <div class="spinner" v-show="loading"></div>
        <div class="table-responsive table-hover">
            <table class="table">
                <tbody>
                <tr >
                    <th width="30%">Image</th>
                    <td>
                        <img class="fileinput-new thumbnail img-raised" style="width: 140px;height: 140px"  :src="forms.image"  alt="">
                    </td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{forms.product_name}}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{forms.category_name}}</td>
                </tr>
                <tr>
                    <th>Supplier</th>
                    <td>{{forms.s_name}}</td>
                </tr>
                <tr>
                    <th>Code</th>
                    <td>{{forms.product_code}}</td>
                </tr>
                <tr>
                    <th>Root</th>
                    <td>{{forms.root}}</td>
                </tr>
                <tr>
                    <th>Buying date</th>
                    <td>{{forms.buying_date}}</td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td>{{forms.product_quantity}}</td>
                </tr>
                <tr>
                    <th>Buying price</th>
                    <td>{{forms.buying_price}}</td>
                </tr>
                <tr>
                    <th>Selling price</th>
                    <td>{{forms.selling_price}}</td>
                </tr>
                <tr>
                    <th>Details</th>
                    <td>{{forms.details}}</td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</template>

<script>
    export default {
        name: "details",
        data(){
            return{
                loading: false,
                forms:'',
            }
        },
        created(){
            this.loading = true;
            axios.get('/api/product/'+this.$route.params.id,this.form)
                .then(response=>{
                    this.forms = response.data;
                })
                .catch(error=>this.errors = error.response.data.errors)
                 .finally(() => {this.loading = false});
        },
        methods:{

        }
    }
</script>

<style scoped>
    @import "/loder/loder.css";
    .spinner{
        top: -15px;
        width: 105%;
    }
</style>