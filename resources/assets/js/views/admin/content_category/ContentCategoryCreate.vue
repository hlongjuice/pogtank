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
                            <!--Back Button-->
                            <div class="col-md-2">
                                <a @click="back" class="margin-bottom-10 btn btn-default">ย้อนกลับ</a>
                            </div>
                            <!--Add Button-->
                            <div class="col-md-4 pull-right text-right">
                                <button type="submit" class="margin-bottom-10 btn btn-success btn-block">บันทึกรายการ</button>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title" class="control-label">ชื่อ</label>
                                    <div :class="{'input-error':errors.has('form.title')}">
                                        <input
                                                v-validate="'required'"
                                                type="text" v-model="form.title" id="title" name="title"
                                               class="form-control">
                                    </div>
                                    <span v-show="errors.has('form.title')"
                                          class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                </div>
                                {{errors}}
                            </div>
                            <!-- Parent Categories -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">หมวดหมู่รายการ</label>
                                    <div :class="{'input-error':errors.has('form.parent_categories')}">
                                        <multiselect
                                                v-model="form.parentCategory"
                                                placeholder="" label="title" track-by="id"
                                                :options="parentCategoryList" :option-height="104"
                                                :show-labels="false"
                                                :allow-empty="false"
                                                :max-height="150"
                                        >
                                            <template slot="option" slot-scope="props">
                                                <div class="option__desc">
                                                    <span class="option__title">{{ props.option.title}}</span>
                                                </div>
                                            </template>
                                        </multiselect>
                                        <input v-validate="'required'"
                                               name="parent_categories" hidden
                                               v-model="form.parentCategory">
                                    </div>
                                    <span v-show="errors.has('form.parent_categories')"
                                          class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import {ContentCategoryService} from "../../../services/content_category/content_category_service";

    let contentCategoryService = new ContentCategoryService();
    export default {
        name: "ContentCategoryCreate",
        data() {
            return {
                form: {
                    title: '',
                    parentCategory: ''
                },
                parentCategoryList: []
            }
        },
        methods: {
            addCategory(form) {
                this.$validator.validateAll(form).then(result => {
                    //If All Input Validate
                    if (result) {
                        contentCategoryService.addCategory(this.form)
                            .then(result=>{
                                this.$router.back();
                            }).catch(err=>console.log(err))
                    }
                })
            },
            getAllCategories() {
                contentCategoryService.getAllCategories()
                    .then(result => {
                        this.parentCategoryList = result;
                    }).catch(err => {
                    console.log(err)
                })
            },
            back() {
                this.$router.back();
            }
        },
        created() {
            this.getAllCategories();
        }
    }
</script>

<style scoped>

</style>