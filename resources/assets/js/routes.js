import {store} from "./store";
import VueRouter from 'vue-router';
import WebUrl from '../js/services/webUrl';
//Content
import Content from './views/admin/content/Content.vue';
import ContentList from './views/admin/content/ContentList';
import ContentCreate from './views/admin/content/ContentCreate.vue';
import ContentEdit from './views/admin/content/ContentEdit';
//Content Category
import ContentCategory from './views/admin/content_category/ContentCategory';
import ContentCategoryCreate from './views/admin/content_category/ContentCategoryCreate';
import ContentCategoryList from './views/admin/content_category/ContentCategoryList';
import ContentCategoryEdit from './views/admin/content_category/ContentCategoryEdit';

//test_route
import TestRoute from './views/admin/test_route/Home';


// window.VueRouter = VueRouter;
let pathName = window.location.pathname;
let webUrl = new WebUrl();
const routes = [
    //region Content
    {
        path: '/content', component: Content, meta: {breadcrumb: 'เนื้อหา'},
        children: [
            {path: '', name: 'content', component: ContentList},
            {path: 'create', name: 'content_create', component: ContentCreate, meta: {breadcrumb: 'สร้างใหม่'}},
            {path:':id/edit',name:'content_edit',component:ContentEdit}
        ]
    },
    //endregion
    //region Content Category
    {
        path: '/content_category', component: ContentCategory, meta: {breadcrumb: 'หมวดหมู่เนื้อหา'},
        children:[
            {path:'',name:'content_category',component:ContentCategoryList},
            {path:'create',name:'content_category_create',component:ContentCategoryCreate,meta: {breadcrumb: 'สร้างใหม่'}},
            {path:'edit/:myID',name:'content_category_edit',component:ContentCategoryEdit,
                meta: {breadcrumb:routeParams=> `แก้ไข - ${routeParams.id}`}}
        ]
    },
    //endregion
    {path:'/test_route/',name:'test_route',component:TestRoute}
    // meta: {breadcrumb :'แก้ไขหมวดหมู่' }}
];

const router = new VueRouter({
    routes
});
store.dispatch('vuePageShow');
// Set Middleware Guard
//รอเปิดใช้ตอนใช้งานจริง
// router.beforeEach((to,from,next)=>{
//     let base_path = window.location.pathname;
//     if(base_path == '/admin' || base_path == '/public/admin' ||  base_path =='/pogtank/public/admin'){
//         store.dispatch('vuePageShow');
//         next();
//     }
//     else if(base_path == 'login' || base_path == 'public/login' ||  base_path =='/pogtank/public/login'){
//         console.log('Login Page',base_path);
//     }
//     else{
//         if(to.fullPath !== '/'){
//             window.location = webUrl.getRoute('/admin#'+to.fullPath);
//         }
//     }
// });
export {
    router
};
