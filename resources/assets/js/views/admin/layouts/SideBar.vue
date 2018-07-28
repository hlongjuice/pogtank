<template>
    <!--<div class="page-sidebar-wrapper">-->
        <!--<div class="page-sidebar navbar-collapse collapse">-->
            <!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu">
                <router-link :to="{name:'content'}" tag="li">a</router-link>
                <router-link :to="{name:'content_category'}" tag="li">b</router-link>
            </ul>
        <!--</div>-->
    <!--</div>-->
</template>

<script>
    export default {
        name: "SideBar"
    }
</script>

<style scoped>

</style>