<template>
    <div>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i>
                </div>
                <!-- Option Button -->
                <div class="actions">
                    <a class="btn btn-danger btn-sm">
                        <i class="fa fa-plus"></i>
                        Example Button
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <a @click="back()" class="btn btn-default">ย้อนกลับ</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ContentEdit",
        beforeRouteUpdate (to, from, next) {
            next();
        },
        methods:{
            back(){
                this.$router.push({name:'content'})
            }
        }
    }
</script>

<style scoped>

</style>