<template>
    <div class="row axiosForm">
        <div class="spinner" v-show="loading"></div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header card-header-rose">
                    <div class="card-icon">
                        <i class="material-icons">track_changes</i>
                    </div>
                    <h4 class="card-title ">Products Table</h4>
                    <p class="card-category"> This table consist a list of product</p>
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
                                <td>{{value.product_name}}</td>
                                <td>{{value.category_name}}</td>
                                <td class="td-actions">
                                    <router-link :to="{name:'editProduct',params: { id: value.id }}"
                                                 rel="tooltip" class="btn btn-success btn-simple"
                                                 title="Edit">
                                        <i class="material-icons">edit</i>
                                    </router-link>
                                    <a @click="deleteProduct(value.id)"
                                       rel="tooltip" class="btn btn-danger btn-simple"
                                       style="color: white"
                                       title="Delete">
                                        <i class="material-icons">close</i>
                                    </a>
                                    <router-link :to="{name:'productDetails',params: { id: value.id }}"
                                                 rel="tooltip" class="btn btn-rose btn-simple"
                                                 title="Details">
                                        <i class="material-icons">description</i>
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
        <div class="col-md-5" >
            <div class="card"><div class="card-header card-header-rose">
                <div class="card-icon">
                    <i class="material-icons">question_answer</i>
                </div>
                <h4 class="card-title ">Product Details</h4>
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
    import Datatable from '../../dataTable/Datatable';
    import Pagination from '../../dataTable/Pagination';
    import User from "../../../helper/User";
    export default {
        name: "index",
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
                {width: '16%', label: 'Image', name: 'image' },
                {width: '32%', label: 'Product name', name: 'product_name'},
                {width: '25%', label: 'Category', name: 'category_id'},
                {width: '17%', label: 'Action', name: ''},
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
            getData(url = '/api/allProducts') {
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
            deleteProduct(id) {
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
                        let uri = `/api/product/${id}`;
                        axios.delete(uri).then(response => {
                            Swal.fire(
                                'Deleted!',
                                'Your data has been deleted.',
                                'success'
                            );
                            this.getData();
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
        width: 147%;
    }
</style>