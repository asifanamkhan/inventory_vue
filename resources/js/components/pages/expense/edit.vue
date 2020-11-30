<template>
    <div>
        <div class="card axiosForm">
            <div class="spinner" v-show="loading"></div>
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">hourglass_top</i>
                </div>
                <h4 class="card-title">Edit Expense</h4>
            </div>
            <div class="card-body ">
                <form @submit.prevent="ExpenseUpdate">
                    <div class="form-row">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Date</label>
                                <input  v-model="form.date" type="date" class="form-control" placeholder="">
                                <small class="text-rose" v-if="errors.date" >{{errors.date[0]}}</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">.</label>
                                <input  v-model="form.name" type="text" class="form-control" placeholder="Expense name">
                                <small class="text-rose" v-if="errors.name" >{{errors.name[0]}}</small>
                            </div>
                            <div class="form-group col-md-6">
                                <input v-model="form.amount" type="number" class="form-control" placeholder="amount">
                                <small class="text-rose" v-if="errors.amount" >{{errors.amount[0]}}</small>
                            </div>
                            <div class="form-group col-md-6">
                                <textarea class="form-control" v-model="form.details" rows="2" placeholder="Expense details"></textarea>
                            </div>
                            <div class="card-footer ">
                                <button type="submit" class="btn btn-fill btn-success">Submit</button>
                            </div>
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
            axios.get('/api/expense/'+this.$route.params.id,this.form)
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
                    name:'',
                    date:'',
                    details:'',
                    amount:'',
                },
                errors:{}
            }
        },
        methods:{
            ExpenseUpdate(){
                this.loading = true;
                axios.patch('/api/expense/'+this.$route.params.id,this.form)
                    .then(response=>{
                        this.$router.push({name: 'allExpense'});
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