<template>
    <div class="axiosForm">
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
                   <td>{{forms.name}}</td>
               </tr>
               <tr>
                   <th>Phone</th>
                   <td>{{forms.phone}}</td>
               </tr>
               <tr>
                   <th>Email</th>
                   <td>{{forms.email}}</td>
               </tr>
               <tr>
                   <th>Salary</th>
                   <td>{{forms.salary}}</td>
               </tr>
               <tr>
                   <th>Join Date</th>
                   <td>{{forms.join_date}}</td>
               </tr><tr>
                   <th>Address</th>
                   <td>{{forms.address}}</td>
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
            axios.get('/api/employee/'+this.$route.params.id)
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