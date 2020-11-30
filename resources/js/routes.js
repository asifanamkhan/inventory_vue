import Home from './components/home'

// auth---------------------------------------------------
import Login from './components/auth/login'
import Register from './components/auth/register'
// import ForgetPass from './components/auth/forgetPass'
import Logout from './components/auth/logout'

// Employee---------------------------------------------------
import addEmployee from './components/pages/employee/create';
import allEmployee from './components/pages/employee/index';
import editEmployee from './components/pages/employee/edit';
import Details from './components/pages/employee/details';

// Supplier---------------------------------------------------
import addSupplier from './components/pages/supplier/create'
import allSupplier from './components/pages/supplier/index'
import editSupplier from './components/pages/supplier/edit'
import supplierDetails from './components/pages/supplier/details'

// Category---------------------------------------------------
import addCategory from './components/pages/category/create'
import allCategory from './components/pages/category/index'
import editCategory from './components/pages/category/edit'

// Product---------------------------------------------------
import addProduct from './components/pages/product/create'
import allProduct from './components/pages/product/index'
import editProduct from './components/pages/product/edit'
import productDetails from './components/pages/product/details'

// Expense---------------------------------------------------
import addExpense from './components/pages/expense/create'
import allExpense from './components/pages/expense/index'
import editExpense from './components/pages/expense/edit'

// Salary---------------------------------------------------
import addSalary from './components/pages/salary/create'
import allSalary from './components/pages/salary/index'
import salaryDetails from './components/pages/salary/details'
import editSalary from './components/pages/salary/edit'
import paySalary from './components/pages/salary/pay_salary'



export const routes = [
    { path: '/home', component:Home, name:'Home' },

    // auth----------------------------------------------------------
    { path: '/', component: Login,name: '/' },
    { path: '/register', component:Register, name:'register' },
    // { path: '/forgetPass', component:ForgetPass, name:'forgetPass' },
    { path: '/logout', component:Logout, name:'Logout' },

    // Employee------------------------------------------------------
    { path: '/add-employee', component:addEmployee, name:'addEmployee' },
    { path: '/all-employee', component:allEmployee, name:'allEmployee',
        children: [
            { path: 'details/:id', component: Details, name:'EmployeeDetails' },
        ]
    },
    { path: '/edit-employee/:id', component:editEmployee, name:'editEmployee' },

    // Supplier------------------------------------------------------
    { path: '/add-supplier', component:addSupplier, name:'addSupplier' },
    { path: '/all-supplier', component:allSupplier, name:'allSupplier',
        children: [
            { path: 'details/:id', component: supplierDetails, name:'supplierDetails' },
        ]
    },
    { path: '/edit-supplier/:id', component:editSupplier, name:'editSupplier',},

    // Category------------------------------------------------------
    { path: '/add-category', component:addCategory, name:'addCategory' },
    { path: '/all-category', component:allCategory, name:'allCategory',},
    { path: '/edit-category/:id', component:editCategory, name:'editCategory',},

    // Product------------------------------------------------------
    { path: '/add-product', component:addProduct, name:'addProduct' },
    { path: '/all-product', component:allProduct, name:'allProduct',
        children: [
            { path: 'details/:id', component: productDetails, name:'productDetails' },
        ]
    },
    { path: '/edit-product/:id', component:editProduct, name:'editProduct',},

    // Expense------------------------------------------------------
    { path: '/add-expense', component:addExpense, name:'addExpense' },
    { path: '/all-expense', component:allExpense, name:'allExpense',},
    { path: '/edit-expense/:id', component:editExpense, name:'editExpense',},

    // Salary------------------------------------------------------
    { path: '/pay-salary', component:paySalary, name:'paySalary' },
    { path: '/add-salary/:id', component:addSalary, name:'addSalary' },
    { path: '/all-salary', component:allSalary, name:'allSalary',
        children: [
            { path: 'details/:id', component: salaryDetails, name:'salaryDetails' },
        ]
    },
    { path: '/edit-salary/:id', component:editSalary, name:'editSalary',},

];