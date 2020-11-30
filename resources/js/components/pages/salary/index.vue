<template>
    <div class="row axiosForm">
        <div class="spinner" v-show="loading"></div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header card-header-rose">
                    <div class="card-icon">
                        <i class="material-icons">credit_card</i>
                    </div>
                    <h4 class="card-title ">Salary details Table</h4>
                    <p class="card-category"> This table consist a details of salary</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-hover">
                        <div>
                            <label for="year">Select Year</label>
                            <select id="year" @change="yearChange($event)" v-model="year" class="form-control">
                                <option :value="2020">2020</option>
                                <option :value="2021">2021</option>
                                <option :value="2022">2022</option>
                                <option :value="2023">2023</option>
                            </select>
                        </div>
                        <table class="table">
                            <thead>
                            <tr class="text-rose font-weight-bold" style="font-size: 16px">
                                <td>Month</td>
                                <td width="40%">Details</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="month in months">
                                <td>{{month.salary_month}}</td>
                                <td v-show="year == ''">
                                    <button @click="yearCheck"
                                                class="btn btn-sm btn-rose btn-simple"
                                                  title="Details">
                                        <i class="material-icons">details</i>
                                    </button>
                                </td>
                                <td v-show="year != ''">
                                    <router-link  :to="{name:'salaryDetails',params: { id: year+month.salary_month }}"
                                                 rel="tooltip" class="btn btn-sm btn-rose btn-simple"
                                                 title="Details">
                                        <i class="material-icons">details</i>
                                    </router-link>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card"><div class="card-header card-header-rose">
                <div class="card-icon">
                    <i class="material-icons">question_answer</i>
                </div>
                <h4 class="card-title ">Salary list according to employee</h4>
                <p class="card-category"> This table consist a details of an product</p>
            </div>
                <div class="card-body" >
                    <router-view :key="$route.fullPath"></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Noty from 'noty';
    import User from "../../../helper/User";
    export default {
        name: "details",
        mounted(){
            if (! User.loggedIn()){
                this.$router.push({name: '/'})
            }
        },
        data(){
            return{
                loading: false,
                months:'',
                year:''
            }
        },
        created(){
            this.loading = true;
            axios.get('/api/monthList')
                .then(response=>{
                    this.months = response.data;
                })
                .catch(error=>this.errors = error.response.data.errors)
                .finally(() => {this.loading = false});
        },
        methods:{
            yearChange(event){
                this.year = event.target.value;
            },
            yearCheck(){
                new Noty({
                    type: 'warning',
                    layout: 'topRight',
                    text: 'Select a year first' ,
                    timeout: 2000,

                }).show();
            }
        }
    }
</script>

<style scoped>
    @import "/loder/loder.css";
    .spinner{
        top:100px;
        width: 169%;
    }
</style>