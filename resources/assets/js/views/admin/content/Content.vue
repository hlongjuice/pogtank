<template>
    <div>
        <!--Keep All Component Alive that mean all data still store in memory until you refresh page-->
        <!--include Props use to define only Component Name matched by this will be cache in memory-->
        <keep-alive  include="ContentList">
            <router-view></router-view>
        </keep-alive>
    </div>

</template>
<script>
    export default {
        name: "Content",
        data(){
          return {
          }
        },
        computed:{

        },
        created() {
        },
        mounted() {
        }

    }
</script>