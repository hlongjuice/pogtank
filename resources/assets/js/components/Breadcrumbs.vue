<template>
    <ul class="page-breadcrumb">
        <template v-for="(breadcrumb,index) in breadcrumbs">
            <template v-if="index < breadcrumbs.length">
                <li>
                    <i class="fa fa-angle-right"></i>
                </li>
            </template>
            <template v-else>
                <li >
                    {{ breadcrumb }}
                </li>
            </template>
        </template>
    </ul>
</template>

<script>
    export default {
        name: "Breadcrumbs",
        data(){
            return{
                breadcrumbs:[]
            }
        }
    }
</script>

<style scoped>

</style>