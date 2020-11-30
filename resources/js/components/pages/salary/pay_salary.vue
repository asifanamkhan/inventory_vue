<template>
    <div class="row axiosForm">
        <div class="spinner" v-show="loading"></div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <div class="card-icon">
                        <i class="material-icons">credit_card</i>
                    </div>
                    <h4 class="card-title ">Salary Given Table</h4>
                    <p class="card-category"> This table consist a list of Employee</p>
                </div>
                <div class="card-body table-hover">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <input class="form-control " type="text" v-model="tableData.search" placeholder="Search Table" @input="getData()">
                        </div>
                        <div class="col-md-6"></div>

                        <div class="col-md-2">
                            <select class="form-control" v-model="tableData.length" @change="getData()">
                                <option v-for="(records, index) in perPage" :key="index" :value="records">{{records}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <datatable id="dataTable" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy" class="">
                            <tbody v-for="(value,i) in values" :key="value.id">
                            <tr >
                                <td><b>{{i+1}}</b></td>
                                <td><a target="_blank" title="click to view image"   :href="value.image"><img class="card-img" style="width: 45px;height: 40px"  :src="value.image"  alt=""></a></td>
                                <td>{{value.name}}</td>
                                <td>{{value.phone}}</td>
                                <td>{{value.salary}}</td>
                                <td  class="td-actions">
                                    <router-link :to="{name:'addSalary',params: { id: value.id }}"
                                                 rel="tooltip" class="btn btn-rose btn-simple"
                                                 title="Pay Salary">
                                        <i class="material-icons">payment</i>
                                        Pay Salary
                                    </router-link>
                                </td>
                            </tr>
                            </tbody>
                        </datatable>
                        <pagination :pagination="pagination"
                                    @prev="getData(pagination.prevPageUrl)"
                                    @next="getData(pagination.nextPageUrl)">
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datatable from '../../dataTable/Datatable';
    import Pagination from '../../dataTable/Pagination';
    import User from "../../../helper/User";
    export default {
        name: "pay_salary",
        components: { datatable: Datatable, pagination: Pagination },
        mounted(){
            if (! User.loggedIn()){
                this.$router.push({name: '/'})
            }

        },
        created() {
            this.getData();
        },
        data() {
            let sortOrders = {};

            let columns = [
                {width: '10%', label: 'Sl', name: 'id' },
                {width: '15%', label: 'Image', name: 'image'},
                {width: '25%', label: 'Employee Name', name: 'name'},
                {width: '25%', label: 'Phone', name: 'phone'},
                {width: '15%', label: 'Salary', name: 'salary'},
                {width: '10%', label: 'Action', name: ''},
            ];

            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return {
                loading: false,
                values: [],
                sum: [],
                columns: columns,
                sortKey: 'id',
                sortOrders: sortOrders,
                perPage: ['10', '25', '50','100','500','2000','all'],
                tableData: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                },
                pagination: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },
            }
        },
        methods: {
            getData(url = '/api/employeeListSalary') {
                this.loading = true;
                this.tableData.draw++;
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData.draw == data.draw) {
                            this.values = data.data.data;
                            this.sum = data.sum;
                            this.configPagination(data.data);
                        }
                    })
                    .catch(errors => {
                        //console.log(errors);
                    }).finally(() => {
                    this.loading = false
                });
            },
            configPagination(data) {
                this.pagination.lastPage = data.last_page;
                this.pagination.currentPage = data.current_page;
                this.pagination.total = data.total;
                this.pagination.lastPageUrl = data.last_page_url;
                this.pagination.nextPageUrl = data.next_page_url;
                this.pagination.prevPageUrl = data.prev_page_url;
                this.pagination.from = data.from;
                this.pagination.to = data.to;
            },
            sortBy(key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.getData();
            },
            getIndex(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },

        }
    }
</script>

<style scoped>
    @import "/loder/loder.css";
    .spinner{
        top:100px;
        width: 107%;
    }
</style>