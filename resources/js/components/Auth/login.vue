<template>
    <div>
        <div class="row axiosForm">
            <div class="spinner" v-show="loading"></div>
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">Login</h4>
                        <p class="card-category">Login with valid email and password</p>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="login" class="mt-5" >
                            <div class="form-group">
                                <label class="bmd-label-floating">E-Mail Address</label>
                                <input v-model="form.email" type="text" class="form-control">
                                <small class="text-danger" v-if="errors.email" >{{errors.email[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label class="bmd-label-floating">Password</label>
                                <input v-model="form.password" type="password" class="form-control">
                                <small class="text-danger" v-if="errors.password" >{{errors.password[0]}}</small>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-1">
                                    <input type="checkbox" class="">
                                </div>
                                <label class="col-md-5">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-success pull-right">Login</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
     import User from "../../helper/User";
     import Noty from 'noty';

    export default {
        name: "login",
        created(){
            if (User.loggedIn()){
                this.$router.push({name: 'Home'})
            }
        },
        data(){
            return{
                loading: false,
                form:{
                    email:'',
                    password:'',
                },
                errors:{}
            }
        },
        methods:{
            login(){
                this.loading = true;
                axios.post('api/auth/login',this.form)
                    .then(response=>{
                        User.responseAfterLogin(response);
                        if (User.responseAfterLogin(response) !== false) {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Successfully sign up',
                                timeout: 2000,

                            }).show();
                            this.$router.push({name: 'Home'});
                        }else{
                            new Noty({
                                type: 'error',
                                text: 'You have no permission to access',
                                timeout: 2000,
                            }).show();
                        }
                    })
                    .catch(error=>{
                        if(error.response.status === 422){
                            this.errors = error.response.data.errors;
                        }
                        new Noty({
                            type: 'error',
                            text: 'Email and password are not matched',
                            timeout: 2000,
                        }).show();
                    })
                    .finally(() =>{this.loading =  false});
            },
        }
    }
</script>

<style scoped>
    @import "/loder/loder.css";
    .spinner{
        width: 126%;
    }
</style>