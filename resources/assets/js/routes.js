import VueRouter from 'vue-router';
import Content from './views/admin/content/Content.vue';
import ContentList from './views/admin/content/ContentList';
import ContentCreate from './views/admin/content/ContentCreate.vue';
import ContentCategory from './views/admin/content_category/ContentCategory.vue';
// window.VueRouter = VueRouter;
let pathName = window.location.pathname;
const routes = [
    {
        path: '/contents',component: Content,meta:{breadcrumb:'เนื้อหา'},
        children:[
            {path:'',name: 'contents',component:ContentList},
            {path:'create', name:'contents-create', component:ContentCreate,meta:{breadcrumb:'สร้างใหม่'}},
        ]
    },
    {path:'/content/create',name:'create-content',component:ContentCreate},
    {
        path: '/content_categories',
        name: 'content_categories',
        component: ContentCategory
    }
];

const router = new VueRouter({
    routes
});
// Set Middleware Guard
//รอเปิดใช้ตอนใช้งานจริง
// router.beforeEach((to,from,next)=>{
//     let base_path = window.location.pathname;
//     console.log('Before Route');
//     console.log('Window location path',base_path);
//     if(base_path == '/admin' || base_path == '/public/admin'){
//         next();
//     }else{
//         console.log('Not Found route')
//     }
// });
export {
    router
};
