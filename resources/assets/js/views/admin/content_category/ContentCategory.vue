<template>
    <div>
        <keep-alive include="ContentCategoryList">
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
        // beforeRouteUpdate (to, from, next) {
        //     console.log('Master Page');
        //     next();
        // },
        methods:{
            goToPage(page){
                this.$router.push({name:'content_category_edit',params:{id:page}})
            }
        }
    }
</script>