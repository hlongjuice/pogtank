import VueRouter from 'vue-router';
import Content from './views/admin/content/Content.vue';
import ContentCategory from './views/admin/content_category/ContentCategory.vue';
// window.VueRouter = VueRouter;
let pathName = window.location.pathname;
const routes = [
    {
        path: '/contents',
        name: 'contents',
        component: Content,
    },
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
router.beforeEach((to,from,next)=>{
    let base_path = window.location.pathname;
    console.log('Before Route');
    console.log('Window location path',base_path);
    if(base_path == '/admin' || base_path == '/public/admin'){
        next();
    }else{
        console.log('Not Found route')
    }
});
export {
    router
};
