import {store} from "./store";
import VueRouter from 'vue-router';
import WebUrl from '../js/services/webUrl';
//Content
import Content from './views/admin/content/Content.vue';
import ContentList from './views/admin/content/ContentList';
import ContentCreate from './views/admin/content/ContentCreate.vue';
import ContentEdit from './views/admin/content/ContentEdit';
//Content Category
import ContentCategory from './views/admin/content/content_category/ContentCategory';
import ContentCategoryCreate from './views/admin/content/content_category/ContentCategoryCreate';
import ContentCategoryList from './views/admin/content/content_category/ContentCategoryList';
import ContentCategoryEdit from './views/admin/content/content_category/ContentCategoryEdit';
//Fixed Category Content
import FixedCategoryContent from './views/admin/content/FixedCategoryContent'


// window.VueRouter = VueRouter;
let pathName = window.location.pathname;
let webUrl = new WebUrl();
const routes = [
    //Fixed Category Content
    {path:'/fixed_category_content/:categoryTitle',component:FixedCategoryContent,meta:{breadcrumb: routeParams => routeParams.categoryTitle}},
    //Content
    {
        path: '/content/:categoryTitle', component: Content, meta: {breadcrumb: 'เนื้อหา'},
        children: [
            {path: '', name: 'content', component: ContentList},
            {path: 'create', name: 'content_create', component: ContentCreate, meta: {breadcrumb: 'สร้างใหม่'}},
            {path: 'edit/:id', name: 'content_edit', component: ContentEdit}
        ]
    },
    //Content Category
    {
        path: '/content_category/:categoryTitle', component: ContentCategory, meta: {breadcrumb: 'หมวดหมู่เนื้อหา'},
        children: [
            {path: '', name: 'content_category', component: ContentCategoryList},
            {
                path: 'create',
                name: 'content_category_create',
                component: ContentCategoryCreate,
                meta: {breadcrumb: 'สร้างใหม่'}
            },
            {
                path: 'edit/:id', name: 'content_category_edit', component: ContentCategoryEdit,
                meta: {breadcrumb: routeParams => `แก้ไข - ${routeParams.title}`}
            }
        ]
    },
];

const router = new VueRouter({
    routes,
    scrollBehavior(to, from, savedPosition) {
        return {x: 0, y: 0}
    }

});
// Set Middleware Guard
//รอเปิดใช้ตอนใช้งานจริง
router.beforeEach((to, from, next) => {
    let base_path = window.location.pathname;
    if (base_path == '/admin' || base_path == '/public/admin' || base_path == '/pogtank/public/admin') {
        store.dispatch('vuePageShow');
        next();
    }
    else if (base_path == 'login' || base_path == 'public/login' || base_path == '/pogtank/public/login') {
        console.log('Login Page', base_path);
    }
    else {
        if (to.fullPath !== '/') {
            window.location = webUrl.getRoute('/admin#' + to.fullPath);
        }
    }
});
export {
    router
};
