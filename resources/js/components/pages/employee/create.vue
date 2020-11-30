<template>
    <div>
        <div class="card axiosForm">
            <div class="spinner" v-show="loading"></div>
            <div class="card-header card-header-primary card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">accessibility</i>
                </div>
                <h4 class="card-title">Add Employee</h4>
            </div>
            <div class="card-body ">
                <form @submit.prevent="employeeInsert">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Joining date</label>
                            <input  v-model="form.join_date"  type="date" class="form-group form-control" placeholder="Joining Date"/>
                            <small class="text-rose" v-if="errors.join_date" >{{errors.join_date[0]}}</small>
                        </div>
                        <div class="form-group col-md-6 row">
                            <label for=""> .</label>
                            <input  v-model="form.name" type="text" class="form-group form-control" placeholder="Full name">
                            <small class="text-rose" v-if="errors.name" >{{errors.name[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input v-model="form.email" type="email" class="form-control" placeholder="Email">
                            <small class="text-rose" v-if="errors.email" >{{errors.email[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input v-model="form.nid" type="text" class="form-control" placeholder="National id">
                            <small class="text-rose" v-if="errors.nid" >{{errors.nid[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input v-model="form.salary" type="number" minlength="0" class="form-control" placeholder="Salary">
                            <small class="text-rose" v-if="errors.salary" >{{errors.salary[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input v-model="form.phone" type="text" class="form-control" placeholder="Phone number">
                            <small class="text-rose" v-if="errors.phone" >{{errors.phone[0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <textarea v-model="form.address" class="form-control" name="" id="" rows="7" placeholder="Address"></textarea>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-md-6">
                                <label for="">Image</label>
                                <input type="file" @change="onFileSelected" class="btn btn-round btn-primary">
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
                            <button type="submit" class="btn btn-fill btn-primary">Submit</button>
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
                    salary:'',
                    phone:'',
                    join_date:'',
                    nid:'',
                    image:'',
                },
                errors:{}
            }
        },
        methods:{
            employeeInsert(){
                this.loading = true;
                axios.post('/api/employee',this.form)
                    .then(response=>{
                        // console.log(response.data);
                        this.$router.push({name: 'allEmployee'});
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Employee added successfully',
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