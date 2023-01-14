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
import Report from '../admin/AdminReport';
import Dashboard from '../admin/AdminDashboard';

import UserMain from '../user/Dashboard';
import UserProfile from '../user/UserProfile';
import UserHome from '../user/Home';
import UserBook from '../user/UserBook';
import UserJournal from '../user/UserJournal';
import UserMagazine from '../user/UserMagazine';
import UserLinkage from '../user/UserLinkage';
import UserService from '../user/UserService';
import UserGallery from '../user/UserGallery';
import UserContact from '../user/UserContact';
import UserDash from '../user/Dash';


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
                path: 'about',
                component: UserHome
            },
            {
                name: 'userdashboard',
                path: '',
                component: UserDash
            },
            {
                name: 'userbook',
                path: 'books',
                component: UserBook
            },
            {
                name: 'userjournal',
                path: 'journal',
                component: UserJournal
            },
            {
                name: 'usermagazine',
                path: 'magazine',
                component: UserMagazine
            },
            {
                name: 'userlinkage',
                path: 'linkage',
                component: UserLinkage
            },
            {
                name: 'userservice',
                path: 'service',
                component: UserService
            },
            {
                name: 'usergallery',
                path: 'gallery',
                component: UserGallery
            },
            {
                name: 'usercontact',
                path: 'FAQ',
                component: UserContact
            },
        ]
    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin,
        children:[
            {
                name: 'admindashboard',
                path: '',
                component: Dashboard
            },
            {
                name: 'adminlibprofile',
                path: 'profile',
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
            {
                name: 'adminreport',
                path: 'report',
                component: Report
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
    'userhome',
    'userbook',
    'userjournal',
    'usermagazine',
    'userlinkage',
    'userservice',
    'usergallery',
    'usercontact',
    'userdashboard'
   
   
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
    'adminreport',
    'admindashboard',   
];


router.beforeEach((to, from, next)=>{
    if(!window.Laravel.isLoggedin){
        if(openRoutes.includes(to.name)){
            return next();
        }
    }else{
        let user = window.Laravel.user;
        if(adminRoutes.includes(to.name) && user.role == 3){
            return next();
        }else if(userRoutes.includes(to.name) && (user.role == 1 || user.role == 0 || user.role == 2)){
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