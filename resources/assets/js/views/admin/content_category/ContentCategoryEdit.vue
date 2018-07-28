<template>
    <div>
        <!-- Use Vue Form Validate sssss-->
        <form @submit.prevent="updateCategory('form',$event)"
              data-vv-scope="form"
        >
            <!-- Portlet -->
            <div class="portlet">
                <!-- Title -->
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>แก้ไขหมวดหมู่
                    </div>
                    <!-- Option Button -->
                    <div class="actions">
                        <a class="btn btn-danger btn-sm">
                            <i class="fa fa-plus"></i>
                            Example Button
                        </a>
                    </div>
                </div>
                <!-- Body -->
                <div class="portlet-body form">
                    <div class="form-body">
                        <!-- Title -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title" class="control-label"></label>
                                <div :class="{'input-error':errors.has('form.title')}">
                                    <input type="text" id="title" name="title" class="form-control">
                                </div>
                                <span v-show="errors.has('form.title')"
                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
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
        name: "ContentCategoryEdit"
    }
</script>

<style scoped>

</style>