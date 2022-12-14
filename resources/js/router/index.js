import {createWebHistory, createRouter} from "vue-router";
import Home from '../page/Mainpage';
import Registration from '../page/Registration';
import Login from '../page/Login';
import Admin from '../admin/AdminMain';
import AdminLibProfile from '../admin/AdminLibProfile';
import Collection from '../admin/AdminCollection';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
        children:[
        ]
    },
    {
        name: 'register',
        path: '/register',
        component: Registration
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin,
        children:[
            {
                name: 'adminlibprofile',
                path: 'lib-profile',
                component: AdminLibProfile
            },
            {
                name: 'admincollection',
                path: 'lib-resource-collection',
                component: Collection
            },
        ]
    }
    
    

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const openRoutes = [
     'home',
     'register',
     'login',
     'admin',
     'adminlibprofile',
     'admincollection',

];

const userRoutes = [
    'home',
   
   
];
const adminRoutes = [
   
    
];


router.beforeEach((to, from, next)=>{
    if(!window.Laravel.isLoggedin){
        if(openRoutes.includes(to.name)){
            return next();
        }
    }else{
        let user = window.Laravel.user;
        if(adminRoutes.includes(to.name) && user.role == 1){
            return next();
        }else if(userRoutes.includes(to.name) && user.role == 0){
            return next();
        }
    }
    if(openRoutes.includes(to.name)){
        return next();
    }else{
       // return next({name:'signin'});
    }
    
   
});
export default router;