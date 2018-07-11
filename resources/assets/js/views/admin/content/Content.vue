<template>
    <div>
        <!--Keep All Component Alive that mean all data still store in memory until you refresh page-->
        <!--<keep-alive>-->
            <router-view></router-view>
        <!--</keep-alive>-->
    </div>

</template>
<script>
    import Breadcrumbs from "../../../components/Breadcrumbs";
    export default {
        name: "Content",
        components: {Breadcrumbs},
        mounted(){
            console.log('Home Routes :',this.$route)
        }
    }
</script>