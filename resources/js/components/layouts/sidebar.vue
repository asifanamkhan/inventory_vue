<template>
    <div>
        <div class="sidebar" data-color="green" data-background-color="black" style="background-image: url(assets/img/sidebar-1.jpg)" data-image="" v-show="$route.path === '/' || $route.path === '/register' ? false : true">
            <div class="logo">
                <a href="#" class="simple-text logo-normal">
                    Admin Panel
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item " :class="$route.path === '/home' ? 'active' : ''">
                        <router-link class="nav-link" :to="{name:'Home'}">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </router-link>
                    </li>
                    <li class="nav-item" :class="$route.path === '/add-employee' || $route.path === '/all-employee' ? 'active' : '' ">
                        <a class="nav-link"  data-toggle="collapse" href="#sidebarEmployee">
                            <i class="material-icons">accessibility</i>
                            <p>Employee <b class="caret"></b></p>
                        </a>
                        <div class="collapse" id="sidebarEmployee">
                            <ul class="nav">
                                <li class="nav-item" :class="$route.path === '/all-employee' ? 'active' : ''">
                                    <router-link  :to="{name:'allEmployee'}" class="nav-link" >
                                        <span class="sidebar-mini"> ALE </span>
                                        <span class="sidebar-normal"> All Employee </span>
                                    </router-link>
                                </li>
                                <li class="nav-item" :class="$route.path === '/add-employee' ? 'active' : ''">
                                    <router-link  :to="{name:'addEmployee'}" class="nav-link">
                                        <span class="sidebar-mini"> ADE </span>
                                        <span class="sidebar-normal"> Add Employee </span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item" :class="$route.path === '/add-supplier' || $route.path === '/all-supplier' ? 'active' : '' ">
                        <a class="nav-link" data-toggle="collapse" href="#sidebarSupplier">
                            <i class="material-icons">emoji_people</i>
                            <p>Supplier <b class="caret"></b></p>
                        </a>
                        <div class="collapse" id="sidebarSupplier">
                            <ul class="nav">
                                <li class="nav-item" :class="$route.path === '/all-supplier' ? 'active' : ''">
                                    <router-link  :to="{name:'allSupplier'}" class="nav-link">
                                        <span class="sidebar-mini"> ALS </span>
                                        <span class="sidebar-normal"> All Supplier </span>
                                    </router-link>
                                </li>
                                <li class="nav-item" :class="$route.path === '/add-supplier' ? 'active' : ''">
                                    <router-link  :to="{name:'addSupplier'}" class="nav-link">
                                        <span class="sidebar-mini"> ADS </span>
                                        <span class="sidebar-normal"> Add Supplier </span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item" :class="$route.path === '/add-category' || $route.path === '/all-category' ? 'active' : '' ">
                        <a class="nav-link" data-toggle="collapse" href="#sidebarCategory">
                            <i class="material-icons">category</i>
                            <p>Category <b class="caret"></b></p>
                        </a>
                        <div class="collapse" id="sidebarCategory">
                            <ul class="nav">
                                <li class="nav-item" :class="$route.path === '/all-category' ? 'active' : ''">
                                    <router-link  :to="{name:'allCategory'}" class="nav-link">
                                        <span class="sidebar-mini"> ALC </span>
                                        <span class="sidebar-normal"> All Category </span>
                                    </router-link>
                                </li>
                                <li class="nav-item" :class="$route.path === '/add-category' ? 'active' : ''">
                                    <router-link  :to="{name:'addCategory'}" class="nav-link">
                                        <span class="sidebar-mini"> ADC </span>
                                        <span class="sidebar-normal"> Add Category </span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item" :class="$route.path === '/add-product' || $route.path === '/all-product' ? 'active' : '' ">
                        <a class="nav-link" data-toggle="collapse" href="#sidebarProduct">
                            <i class="material-icons">track_changes</i>
                            <p>Product <b class="caret"></b></p>
                        </a>
                        <div class="collapse" id="sidebarProduct">
                            <ul class="nav">
                                <li class="nav-item" :class="$route.path === '/all-product' ? 'active' : ''">
                                    <router-link  :to="{name:'allProduct'}" class="nav-link">
                                        <span class="sidebar-mini"> ALP </span>
                                        <span class="sidebar-normal"> All Product </span>
                                    </router-link>
                                </li>
                                <li class="nav-item" :class="$route.path === '/add-product' ? 'active' : ''">
                                    <router-link  :to="{name:'addProduct'}" class="nav-link">
                                        <span class="sidebar-mini"> ADP </span>
                                        <span class="sidebar-normal"> Add Product </span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item" :class="$route.path === '/add-expense' || $route.path === '/all-expense' ? 'active' : '' ">
                        <a class="nav-link" data-toggle="collapse" href="#sidebarExpense">
                            <i class="material-icons">hourglass_top</i>
                            <p>Expense <b class="caret"></b></p>
                        </a>
                        <div class="collapse" id="sidebarExpense">
                            <ul class="nav">
                                <li class="nav-item" :class="$route.path === '/all-expense' ? 'active' : ''">
                                    <router-link  :to="{name:'allExpense'}" class="nav-link">
                                        <span class="sidebar-mini"> ALEX </span>
                                        <span class="sidebar-normal"> All Expense </span>
                                    </router-link>
                                </li>
                                <li class="nav-item" :class="$route.path === '/add-expense' ? 'active' : ''">
                                    <router-link  :to="{name:'addExpense'}" class="nav-link">
                                        <span class="sidebar-mini"> ADEX </span>
                                        <span class="sidebar-normal"> Add Expense </span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item" :class="$route.path === '/add-salary' || $route.path === '/view-salary' || $route.path === 'pay-salary' ? 'active' : '' ">
                        <a class="nav-link" data-toggle="collapse" href="#sidebarSalary">
                            <i class="material-icons">credit_card</i>
                            <p>Salary <b class="caret"></b></p>
                        </a>
                        <div class="collapse" id="sidebarSalary">
                            <ul class="nav">
                                <li class="nav-item" :class="$route.path === '/pay-salary' ? 'active' : ''">
                                    <router-link  :to="{name:'paySalary'}" class="nav-link">
                                        <span class="sidebar-mini"> PS </span>
                                        <span class="sidebar-normal"> Pay Salary </span>
                                    </router-link>
                                </li>
                                <li class="nav-item" :class="$route.path === '/all-salary' ? 'active' : ''">
                                    <router-link  :to="{name:'allSalary'}" class="nav-link">
                                        <span class="sidebar-mini"> AS </span>
                                        <span class="sidebar-normal"> All Salary </span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "sidebar"
    }
</script>

<style scoped>

</style>