import Login from   '../views/Login.vue'
import Index from   '../views/Index.vue'
import Todo from   '../views/TodoList.vue'
import Register from   '../views/Register.vue'
import TodoDetails from "../views/TodoDetails.vue";
import AddTodo from "../views/AddTodo.vue";
import TeamList from "../views/TeamList.vue"
import AdminPage from "../views/AdminPage.vue"
import Project from "../views/Project.vue"
import VerifyEmail from "../views/ConfirmMail.vue"
import ErrorMail from "../views/ErrorMail.vue"

import { createRouter, createWebHistory } from "vue-router";
const routerCustom = [{
        path: '/login',
        name:'login',
        component: Login
    },
    {
        path:'/register',
        name: 'register',
        component: Register
    },
    {
        path: '/',
        name: 'index',
        component: Index
    },
    {
        path:'/todo',
        name: 'todo',
        component: Todo
    },
    {
        path:'/todo/:id',
        name: 'details',
        component: TodoDetails
    },
    {
        path:'/add-todo',
        name: 'add',
        component: AddTodo
    },
    {
        path:'/edit-todo/:id',
        name: 'edit',
        component: AddTodo
    },
    {
        path:'/team',
        name: 'team',
        component: TeamList
    },
    {
        path:'/admin',
        name: 'admin',
        component: AdminPage
    },
    {
        path:'/projects',
        name: 'projects',
        component: Project
    },
    {
        path:'/verify-mail/:code',
        name: 'verify-mail',
        component: VerifyEmail
    },
    {
        path:'/error-mail',
        name: 'error-mail',
        component: ErrorMail
    },

]

const createCustomRouter = () =>
    createRouter({
        history: createWebHistory(''),
        routes: routerCustom,
        scrollBehavior(to) {
            if (to.hash) {
                return {
                    el: to.hash,
                    behavior: "smooth",
                };
            }
        },
    });
const router = createCustomRouter();

router.beforeEach(async (to, from, next) => {
    // set title
    const appName = "TodoList";
    document.title = to.meta?.title ? to.meta.title + " - " + appName : appName;

    // if no token then redirect to login
    const token = localStorage.getItem('token');
    const isProtectedRoute = to.name !== "login";

    if (isProtectedRoute && !token) {
        next({
            name: "login",
        });
        return
    }
    next();

});


export default router;
