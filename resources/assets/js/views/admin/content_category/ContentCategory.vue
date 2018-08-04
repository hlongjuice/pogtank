<template>
    <div>
        <keep-alive include="ContentCategoryList">
            <router-view>
            </router-view>
        </keep-alive>
    </div>
</template>
<script>
    import {store} from "../../../store";
    export default {
        data(){
            return {

            }
        },
        created(){
            console.log('Store',store);
        },
        methods:{
        }
    }
</script>