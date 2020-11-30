<template>
    <div>
        <div class="card axiosForm">
            <div class="spinner" v-show="loading"></div>
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">credit_card</i>
                </div>
                <h4 class="card-title">Add Salary</h4>
            </div>
            <div class="card-body ">
                <form @submit.prevent="paySalary">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Paid date</label>
                            <input v-model="form.salary_date" type="date" class="form-group form-control" placeholder="">
                            <small class="text-rose" v-if="errors.salary_date" >{{errors.salary_date[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Employee name</label>
                            <input  v-model="form.name" type="text" class="form-group form-control" placeholder="Category name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Employee phone</label>
                            <input  v-model="form.phone" type="text" class="form-group form-control" placeholder="Category name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Employee salary</label>
                            <input readonly  v-model="form.salary" type="text" class="form-group form-control" placeholder="Category name">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Select month</label>
                            <select class="form-control" v-model="form.salary_month" >
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                            <small class="text-rose" v-if="errors.salary_month" >{{errors.salary_month[0]}}</small>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-fill btn-info">Pay salary</button>
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
        created(){
            this.loading = true;
            axios.get('/api/employee/'+this.$route.params.id,this.form)
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
                    salary_date:'',
                    employee_id:'',
                    salary:'',
                    phone:'',
                    salary_month:'',
                },
                errors:{}
            }
        },
        methods:{
            paySalary(){
                this.loading = true;
                this.form.employee_id = +this.$route.params.id;
                axios.post('/api/salary',this.form)
                    .then(response=>{
                        console.log(response.data)
                        if( response.data === false){
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Salary already paid to '+this.form.name ,
                                timeout: 2000,

                            }).show();
                        }
                        else{
                            this.$router.push({name: 'paySalary'});
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Salary paid to '+this.form.name +' successfully',
                                timeout: 2000,

                            }).show();
                        }

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