<template>
    <div>
        <!--Keep All Component Alive that mean all data still store in memory until you refresh page-->
        <!--<keep-alive>-->
            <router-view></router-view>
        <!--</keep-alive>-->
    </div>

</template>
<script>
    export default {
        name: "Content",
        mounted(){
            console.log('Home Routes :',this.$route)
        }
    }
</script>