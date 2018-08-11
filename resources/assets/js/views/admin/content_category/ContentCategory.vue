<template>
    <div>
        <div class="col-xs-12">
            <router-link :to="{name:'content_category_edit',params:{id:30}}"  class="btn btn-default">A</router-link>
            <router-link :to="{name:'content_category_edit',params:{id:33}}" class="btn btn-default">B</router-link>
            <router-link to="/content_category/31"  class="btn btn-default">AA</router-link>
            <a @click="goToPage(44)" class="btn btn-default">BB</a>
        </div>
        <!--<keep-alive include="ContentCategoryList">-->
            <router-view >
            </router-view>
        <!--</keep-alive>-->
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