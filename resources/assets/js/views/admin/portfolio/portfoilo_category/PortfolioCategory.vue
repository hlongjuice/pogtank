<template>
    <div>
        <keep-alive include="PortfolioCategoryList">
            <router-view >
            </router-view>
        </keep-alive>
    </div>
</template>
<script>
    export default {
        data(){
            return {

            }
        },
        watch:{
            '$route'(to ,from){
                console.log('Master Route Changed')
            }
        },
        created(){
        },
        mounted(){
          console.log('Mounted Master Page')
        },
        methods:{
        }
    }
</script>