import {store} from "./store";
import VueRouter from 'vue-router';
import WebUrl from '../js/services/webUrl';
//Content
import Content from './views/admin/content/Content.vue';
import ContentList from './views/admin/content/ContentList';
import ContentCreate from './views/admin/content/ContentCreate.vue';
//Content Category
import ContentCategory from './views/admin/content_category/ContentCategory';
import ContentCategoryCreate from './views/admin/content_category/ContentCategoryCreate';
import ContentCategoryList from './views/admin/content_category/ContentCategoryList';


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
        ]
    },
    //endregion
    //region Content Category
    {
        path: '/content_category', component: ContentCategory, meta: {breadcrumb: 'หมวดหมู่เนื้อหา'},
        children:[
            {path:'',name:'content_category',component:ContentCategoryList},
            {path:'create',name:'content_category_create',component:ContentCategoryCreate}
        ]
    },
    //endregion
];

const router = new VueRouter({
    routes
});
// Set Middleware Guard
//รอเปิดใช้ตอนใช้งานจริง
router.beforeEach((to,from,next)=>{
    let base_path = window.location.pathname;
    console.log('Before Route');
    if(base_path == '/admin' || base_path == '/public/admin' ||  base_path =='/pogtank/public/admin'){
        store.dispatch('vuePageShow');
        next();
    }
    else if(base_path == 'login' || base_path == 'public/login' ||  base_path =='/pogtank/public/login'){
        console.log('Login Page',base_path);
    }
    else{
        if(to.fullPath !== '/'){
            window.location = webUrl.getRoute('/admin#'+to.fullPath);
        }
    }
});
export {
    router
};
