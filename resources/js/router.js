import VueRouter from 'vue-router'


import Home from "./components/Home";
import Login from "./components/Auth/login";
import Register from "./components/Auth/register";
import LineNotify from "./components/LineNotify";
import OverFlowNotification from "./components/OverFlowNotification";
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

const routes = [
    {
        path: '/',
        component: Home,
        name: 'Home',
        beforeEnter: guest,
    },
    {
        path: '/overflownotification',
        component: OverFlowNotification,
        name: 'OverFlowNotification',
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
        redirect: { name: 'Home' },
        name: '404',
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});


export default router
