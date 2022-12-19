import {createWebHistory, createRouter} from "vue-router";
import Home from '../page/Mainpage';
import Registration from '../page/Registration';
import Login from '../page/Login';
import Admin from '../admin/AdminMain';
import AdminLibProfile from '../admin/AdminLibProfile';
import Collection from '../admin/AdminCollection';
import Books from '../admin/AdminBooks';
import Journals from '../admin/AdminJournals';
import Magazines from '../admin/AdminMagazine';
import Gallery from '../admin/AdminGallery';
import Linkage from '../admin/AdminLinkage';
import Services from '../admin/AdminService';
import Faculty from '../admin/AdminFaculty';
import User from '../admin/AdminUser';

import UserMain from '../user/Dashboard';
import UserProfile from '../user/UserProfile';
import UserHome from '../user/Home';


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
        name: 'user',
        path: '/user',
        component: UserMain,
        children:[
            {
                name: 'userprofile',
                path: 'profile',
                component: UserProfile
            },
            {
                name: 'userhome',
                path: '',
                component: UserHome
            },
        ]
    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin,
        children:[
            {
                name: 'adminlibprofile',
                path: '',
                component: AdminLibProfile
            },
            {
                name: 'admincollection',
                path: 'lib-resource-collection',
                component: Collection,
                children:[
                    {
                        name: 'books',
                        path: 'books',
                        component: Books
                    },
                    {
                        name: 'journals',
                        path: 'journals',
                        component: Journals
                    },
                    {
                        name: 'magazines',
                        path: 'magazines',
                        component: Magazines
                    },
                ]
            },
            {
                name: 'admingallery',
                path: 'gallery',
                component: Gallery
            },
            {
                name: 'adminservices',
                path: 'services',
                component: Services
            },
            {
                name: 'adminlinkage',
                path: 'linkages',
                component: Linkage
            },
            {
                name: 'adminfaculty',
                path: 'faculty',
                component: Faculty
            },
            {
                name: 'adminuser',
                path: 'user',
                component: User
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
     

];

const userRoutes = [
    'user',
    'userprofile',
    'userhome'
   
   
];
const adminRoutes = [
    'admin',
    'adminlibprofile',
    'admincollection',
    'books',
    'journals',
    'magazines',
    'admingallery',
    'adminlinkage',
    'adminservices',
    'adminfaculty',
    'adminuser',
    
];


router.beforeEach((to, from, next)=>{
    if(!window.Laravel.isLoggedin){
        if(openRoutes.includes(to.name)){
            return next();
        }
    }else{
        let user = window.Laravel.user;
        if(adminRoutes.includes(to.name) && user.role == 2){
            return next();
        }else if(userRoutes.includes(to.name) && user.role == 1){
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