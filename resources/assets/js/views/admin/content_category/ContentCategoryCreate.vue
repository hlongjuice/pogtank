<template>
    <div>
        <!-- Use Vue Form Validate sssss-->
        <form @submit.prevent="addCategory('form',$event)"
              data-vv-scope="form"
        >
            <!-- Portlet -->
            <div class="portlet">
                <!-- Title -->
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>สร้างหมวดหมู่ใหม่
                    </div>
                </div>
                <!-- Body -->
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <a @click="back" class="btn btn-default">ย้อนกลับ</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-">
                                <!-- Input -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "ContentCategoryCreate",
        methods:{
            back(){
                this.$emit('added');
                this.$router.back();
            }
        }
    }
</script>

<style scoped>

</style>