<template>
    <div class="row axiosForm">
        <div class="spinner" v-show="loading"></div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header card-header-primary">
                    <div class="card-icon">
                        <i class="material-icons">accessibility</i>
                    </div>
                    <h4 class="card-title ">Employee Table</h4>
                    <p class="card-category"> This table consist a list of employee</p>

                </div>
                <div class="card-body table-hover">
                    <div class="row mb-3">
                        <div class="col-md-2"></div>
                        <input v-model="searchTerm" placeholder="search by name" type="search" class="text-center form-control bmd-form-group col-md-7">
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th class="font-weight-bold">Id</th>
                                    <th class="font-weight-bold">Name</th>
                                    <th class="font-weight-bold">Phone</th>
                                    <th class="font-weight-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                            <tr v-for="employee in SearchFilter" :key="employee.id">
                                <td width="10%">{{employee.id}}</td>
                                <td width="30#">{{employee.name}}</td>
                                <td width="30%">{{employee.phone}}</td>
                                <td width="30%" class="td-actions">
                                    <router-link :to="{name:'editEmployee',params: { id: employee.id }}"
                                            type="button" rel="tooltip" class="btn btn-success btn-simple"
                                                 title="Edit">
                                            <i class="material-icons">edit</i>
                                    </router-link>
                                    <a @click="deleteEmployee(employee.id)"
                                            type="button" rel="tooltip" class="btn btn-danger btn-simple"
                                            style="color: white"
                                            title="Delete">
                                        <i class="material-icons">close</i>
                                    </a>
                                    <a @click="pdfEmployee(employee.id)"
                                            type="button" rel="tooltip" style="color: white"
                                            class="btn btn-primary btn-simple"
                                            title="PDF">
                                        <i class="material-icons">picture_as_pdf</i>
                                    </a>
                                    <router-link :to="{name:'EmployeeDetails',params: { id: employee.id }}"
                                                 type="button" rel="tooltip" class="btn btn-rose btn-simple"
                                                 title="Details">
                                        <i class="material-icons">question_answer</i>
                                    </router-link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card"><div class="card-header card-header-primary">
                <div class="card-icon">
                    <i class="material-icons">question_answer</i>
                </div>
                <h4 class="card-title ">Employee Details</h4>
                <p class="card-category"> This table consist a details of an employee</p>
            </div>
            <div class="card-body" >
                <router-view :key="$route.fullPath"></router-view>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    import User from "../../../helper/User";
    export default {
        name: "index",
        mounted(){
            if (! User.loggedIn()){
                this.$router.push({name: '/'})
            }

        },
        created(){
            this.allEmployee();
        },
        data() {
            return {
                loading: false,
                employees:[],
                searchTerm:''
            }
        },
        computed:{
            SearchFilter(){
                return this.employees.filter(employee => {
                    return employee.name.match(this.searchTerm);
                })
            }
        },
        methods: {
            pdfEmployee(id) {
                this.loading = true;
                axios.get('/api/generate/')
                    .then(res => {
                    }).finally(() => {
                    this.loading = false
                });
            },
            allEmployee() {
                this.loading = true;
                axios.get('/api/employee')
                    .then(response => {
                        this.employees = response.data;
                    })
                    .catch()
                    .finally(() => {
                        this.loading = false
                    });

            },
            deleteEmployee(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/employee/' + id)
                            .then(response => {
                                Swal.fire(
                                    'Deleted!',
                                    'Your data has been deleted.',
                                    'success'
                                );
                                this.allEmployee();
                            });

                    }
                });
            }
        }
    }
</script>

<style scoped>
    @import "/loder/loder.css";
    .spinner{
        top:100px;
        width: 145%;
    }
</style>