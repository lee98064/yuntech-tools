import VueRouter from 'vue-router'


import Home from "./components/Home";
import Login from "./components/Auth/login";
import Register from "./components/Auth/register";
import LineNotify from "./components/LineNotify";
import OverFlowNotification from "./components/OverFlowNotification";
import Course from "./components/Course";
import User from "./components/User";
import ExampleComponent from "./components/ExampleComponent";

const guest = (to, from, next) => {
    if (!window.Laravel.isLoggedin) {
        window.location.href = "/auth/login";
    }
    next();
}

const isauth = (to, from, next) => {
    if (window.Laravel.isLoggedin) {
        return next('Home');
    }
    next();
}

const auth = (to, from, next) => {
    if (!window.Laravel.isLoggedin) {
        return next('Login');
    }
    next();
}

const routes = [{
        path: '/',
        component: Home,
        name: 'Home',
        beforeEnter: guest,
    },
    {
        path: '/user',
        component: User,
        name: 'User',
        beforeEnter: auth
    },
    {
        path: '/overflownotification',
        component: OverFlowNotification,
        name: 'OverFlowNotification',
        beforeEnter: auth
    },
    {
        path: '/course',
        component: Course,
        name: 'Course',
        beforeEnter: auth
    },
    {
        path: '/LineNotify',
        component: LineNotify,
        name: 'LineNotify',
        beforeEnter: auth
    },
    {
        path: '/auth/login',
        component: Login,
        name: 'Login',
        beforeEnter: isauth
    },
    {
        path: '/auth/register',
        component: Register,
        name: '註冊',
        beforeEnter: isauth
    },
    {
        path: '*',
        redirect: {
            name: 'Home'
        },
        name: '404',
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});


export default router
