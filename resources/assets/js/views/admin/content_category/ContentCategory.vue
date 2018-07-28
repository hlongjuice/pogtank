<template>
    <div>
        <keep-alive include="ContentCategoryList">
            <router-view
              @added="hey"
            >

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
        created(){

        },
        methods:{
            hey(){
                console.log('Hey')
            }
        }
    }
</script>