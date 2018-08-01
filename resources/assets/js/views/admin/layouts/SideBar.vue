<template>
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu">
                <li class="sidebar-toggler-wrapper">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler">
                    </div>
                    <div class="clearfix">
                    </div>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                </li>
                <!--Dashboard-->
                <li class="start">
                    <a href="">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <!--Product-->
                <li class="">
                    <a @click="goToPage(routes.product)">
                        <i class="fab fa-product-hunt"></i>
                        <span class="title">สินค้า</span>
                    </a>
                </li>
                <!--Ordering-->
                <li class="">
                    <a href="javascript:;">
                        <i class="far fa-shopping-cart"></i>
                        <span class="title">ระบบ ปร.4,5,6</span>
                        <span class="selected"></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" style="">
                        <!--Porlor4PartMenu-->
                        <li class="">
                            <a @click="goToPage(routes.porlor4_part)">
                                <span class="title">- หมวดหมู่ปร.4</span>
                            </a>
                        </li>
                        <!--OrderingListMenu-->
                        <li class="">
                            <a @click="goToPage(routes.project_order)">
                                <span class="title">- โครงการ</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--Materials-->
                <li class="">
                    <a href="javascript:;">
                        <i class="far fa-wrench"></i>
                        <span class="title">วัสดุอุปกรณ์</span>
                        <span class="selected"></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" style="">
                        <!--Material Types-->
                        <li class="">
                            <a href="">- หมวดหมู่วัสดุ/อุปกรณ์</a>
                        </li>
                        <!--Material Item-->
                        <li class="">
                            <a href="">- วัสดุ/อุปกรณ์</a>
                        </li>
                    </ul>
                </li>
                <!--Content-->
                <router-link tag="li" :to="{name:'content'}">
                    <a href="javascript:;">
                        <i class="fab fa-product-hunt"></i>
                        <span class="title">เนื้อหา</span>
                    </a>
                </router-link>
                <!--Content Category-->
                <router-link tag="li" :to="{name:'content_category'}">
                    <a href="javascript:;">
                        <i class="fab fa-product-hunt"></i>
                        <span class="title">หมวดหมู่เนื้อหา</span>
                    </a>
                </router-link>
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </div>
</template>

<script>
    import WebUrl from '../../../services/webUrl';

    let webUrl = new WebUrl();
    let routes = {
        project_order: {url: '/admin/project_order', active: false},
        porlor4_part:{url:'/admin/porlor_4_parts',active: false},
        product:{url:'/admin/product',active:false}
    };
    export default {
        name: "SideBar",
        data() {
            return {
                routes
            }
        },
        methods: {
            goToPage(page) {
                window.location = webUrl.getRoute(page.url);
                this.$store.commit('vuePageHidden')
            }
        }
    }
</script>

<style scoped>

</style>