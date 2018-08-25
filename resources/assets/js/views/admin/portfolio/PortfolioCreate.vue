<template>
    <div>
        <!-- Use Vue Form Validate-->
        <form @submit.prevent="addContent('form',$event)"
              data-vv-scope="form"
        >
            <!-- Portlet -->
            <div class="portlet">
                <!-- Title -->
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>สร้างรายการใหม่
                    </div>
                </div>
                <!-- Body -->
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="row">
                            <!--Back Button-->
                            <div class="col-md-2">
                                <a @click="backToPreviousPage" class="margin-top-10  btn btn-default">
                                    <i class="far fa-chevron-left"></i>
                                    ย้อนกลับ
                                </a>
                            </div>
                            <!--Save Button-->
                            <div class="col-md-3 pull-right text-right">
                                <button type="submit"
                                        class="margin-top-10 margin-bottom-10 btn btn-success btn-block">บันทึก
                                </button>
                            </div>
                        </div>
                        <!--Form-->
                        <div class="row">
                            <!-- --Tittle -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="content_title" class="control-label">หัวข้อ</label>
                                    <div :class="{'input-error':errors.has('form.content_title')}">
                                        <input
                                                v-validate="'required'"
                                                v-model="form.title" id="content_title"
                                                name="content_title" class="form-control">
                                    </div>
                                    <span v-show="errors.has('form.content_title')"
                                          class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                </div>
                            </div>
                            <!-- Category -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">หมวดหมู่รายการ</label>
                                    <div :class="{'input-error':errors.has('form.category')}">
                                        <!-- label คือ object key ที่จะใช้แสดงหลังเลือก เช่น name,title -->
                                        <multiselect
                                                v-model="form.category"
                                                placeholder="" label="title" track-by="id"
                                                :options="categories" :option-height="104"
                                                :show-labels="false"
                                                :allow-empty="false"
                                                :max-height="150"
                                        >
                                            <template slot="option" slot-scope="props">
                                                <div class="option__desc">
                                                    <span class="option__title"> {{ props.option.title }}</span>
                                                </div>
                                            </template>
                                        </multiselect>
                                        <label>
                                            <input
                                                    v-validate="'required'"
                                                    name="category" hidden
                                                    v-model="form.category">
                                        </label>
                                    </div>
                                    <span v-show="errors.has('form.category')"
                                          class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                </div>
                            </div>
                            <!-- --Tiny Mce -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label"></label>
                                    <tiny-mce
                                            v-model="form.body"
                                            :init="tinyMceInit"
                                    ></tiny-mce>
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
    import Editor from '@tinymce/tinymce-vue';
    import {tinyMceConfig} from "../../../configs/tinymce";
    import {ContentCategoryService} from "../../../services/content_category/content_category_service";
    import WebUrl from '../../../services/webUrl';
    import {ContentService} from "../../../services/content/content_service";

    let webUrl = new WebUrl();
    let contentCategoryService = new ContentCategoryService();
    let contentService = new ContentService();
    export default {
        name: "PortfolioCreate",
        data() {
            return {
                form: {
                    title: '',
                    body: '',
                    category: ''
                },
                categories: [],
                tinyMceInit: tinyMceConfig
            }
        },
        computed: {},
        created() {
            //กำหนด vuex state ไม่ใช้ refresh parent component
            this.$store.commit('notRefreshParent');
            //Get Categories
            contentCategoryService.getAllCategories()
                .then(result => {
                    this.categories = result;
                }).catch(err => {
                console.log(err)
            })
        },
        methods: {
            viewChange(event) {
                console.log('View Change', event)
            },
            addContent(form, event) {
                this.$validator.validateAll(form).then(result => {
                    //If All Input Validate
                    if (result) {
                        this.$store.commit('loading');
                        contentService.addContent(this.form)
                            .then(result => {
                                this.$store.commit('refreshParent');
                                this.$router.push({path:'/content/'});
                            }).catch(err => {
                                console.log(err)
                            }
                        )
                    }
                })
            },
            backToPreviousPage() {
                //ถ้ามีข้อความอยู่ จะถามก่อนที่จะทำการย้อนกลับ
                if (this.form.title.length > 0 || this.form.body.length > 0) {
                    this.$dialog.confirm("เอกสารยังไม่ได้รับการบันทึก ยืนยันการยกเลิก")
                        .then(() => {
                            this.$router.push({name: 'content'});
                        }).catch(() => {
                    })
                } else {
                    this.$router.push({name: 'content'});
                }
            },
            saveContent() {
                //ทำการ refresh component เพราะมีการ save data ใหม่
                this.$store.commit('refreshParent');
                //Route back to Content Page
                this.$router.push({name: 'content'});
            },
            tinyChange(event) {
                console.log('exeCommand :', event);
            }
        },
        components: {
            'tiny-mce': Editor
        }
    }
</script>

<style scoped>

</style>