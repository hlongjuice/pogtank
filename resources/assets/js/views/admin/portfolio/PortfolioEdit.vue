<template>
    <div>
        <!-- Use Vue Form Validate-->
        <form @submit.prevent="updateContent('form',$event)"
              data-vv-scope="form"
        >
            <!-- Portlet -->
            <div class="portlet">
                <!-- Title -->
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>แก้ไขรายการ
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
    import {ContentService} from "../../../services/content/content_service";
    import {ContentCategoryService} from "../../../services/content_category/content_category_service";
    import {tinyMceConfig} from "../../../configs/tinymce";
    import TinyMce from '@tinymce/tinymce-vue';

    let contentService = new ContentService();
    let contentCategoryService = new ContentCategoryService();
    export default {
        name: "PortfolioEdit",
        components: {
            'tiny-mce': TinyMce
        },
        data(){
            return{
                form:{
                    id:this.$route.params.id,
                    title:'',
                    body:'',
                    category:''
                },
                categories:[],
                tinyMceInit:tinyMceConfig
            }
        },
        created(){
            this.$store.commit('loading');
            Promise.all([
                contentService.getContent(this.form.id)
                    .then(result=>{
                        this.form.title = result.title;
                        this.form.body = result.body;
                        this.form.category = result.category;
                    }).catch(err=>{console.log(err)}),
                contentCategoryService.getAllCategories('Portfolio')
                    .then(result=>{
                        this.categories= result;
                    }).catch(err=>{console.log(err)})
            ]).then(()=>{
                this.$store.commit('stopLoading')
            }).catch(()=>{
                this.$store.commit('stopLoading')
                alert('ไม่สามารถดึงข้อมูลได้ รีโหลดใหม่อีกครั้ง');
            })

        },
        methods:{
            updateContent(form){
                this.$validator.validateAll(form).then(result => {
                    //If All Input Validate
                    if (result) {
                        this.$store.commit('loading');
                        contentService.updateContent(this.form)
                            .then(result=>{
                                this.$store.commit('refreshParent');
                                this.$router.push({name:'content'});
                            }).catch(err=>{

                        })
                    }
                })
            },
            backToPreviousPage(){
                this.$router.push({name:'portfolio'})
            }
        }
    }
</script>

<style scoped>

</style>