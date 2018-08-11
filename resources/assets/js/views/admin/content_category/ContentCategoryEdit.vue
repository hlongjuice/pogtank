<template>
    <div>
        <!-- Use Vue Form Validate-->
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
                                <button type="submit" class="margin-bottom-10 btn btn-success btn-block">บันทึกรายการ
                                </button>
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
                            </div>
                            <!-- Parent Categories -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">หมวดหมู่รายการ</label>
                                    <div :class="{'input-error':errors.has('form.parent_categories')}">
                                        <multiselect
                                                v-model="form.parent"
                                                placeholder="" label="title" track-by="id"
                                                :options="parentCategoryList" :option-height="120"
                                                :show-labels="false"
                                                :allow-empty="false"
                                                :max-height="180"
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
        name: "ContentCategoryEdit",
        data() {
            return {
                form: {
                    id:'',
                    title:'',
                    parent:''
                },
                category_id: this.$route.params.id,
                parentCategoryList: [],
                showLoading:''
            }
        },
        watch:{
            '$route'(to,from){
                console.log('Edit Page Route Changed');
            }
        },
        created() {
            this.showLoading=true;
            Promise.all([
                this.getCategory(),
                this.getParentCategories()
            ]).then(()=>{
            });

        },
        mounted(){
        },
        // beforeRouteUpdate (to, from, next) {
        //     // react to route changes...
        //     // don't forget to call next()
        //     console.log('BeforeRouteUpdate EditPage To:',to);
        //     this.form.id = to.params.id;
        //     this.getCategory();
        //     next();
        // },
        methods: {
            getCategory() {
                contentCategoryService.getCategory(this.category_id)
                    .then(result => {
                        this.form.id = result.id;
                        this.form.title =result.title;
                        this.form.parent = result.parent;
                        if(result.parent === null){
                            this.form.parent = {
                                id:0,
                                title:'หมวดหมู่หลัก'
                            }
                        }else{this.form.parent = result.parent}
                    }).catch(err => {
                    console.log(err)
                })
            },
            getParentCategories() {
                contentCategoryService.getAllCategoriesWithoutID(this.category_id)
                    .then(result => {
                        this.parentCategoryList = result;
                    }).catch(err => {
                    console.log(err)
                })
            },
            updateCategory(form) {
                this.$validator.validateAll(form).then(result => {
                    //If All Input Validate
                    if (result) {
                        contentCategoryService.updateCategory(this.form)
                    }
                })
            },
            back() {
                this.$router.push({name: 'content_category'});
                // this.$router.back();
            }

        }
    }
</script>

<style scoped>

</style>