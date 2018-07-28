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
                                <a @click="saveContent" class="margin-top-10 btn btn-success btn-block">บันทึก</a>
                            </div>
                        </div>
                        <!--Form-->
                        <div class="row">
                            <!-- --Tittle -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content_title" class="control-label"></label>
                                    <div :class="{'input-error':errors.has('form.content_title')}">
                                        <input v-model="content.title" id="content_title"
                                               name="content_title" class="form-control">
                                    </div>
                                    <span v-show="errors.has('form.content_title')"
                                          class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                </div>
                            </div>
                            <!-- --Tiny Mce -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content_details" class="control-label"></label>
                                    <div :class="{'input-error':errors.has('form.content_details')}">
                                        <tiny-mce @onProgressState="viewChange"
                                                  model-event="change keyup selcetionchange" v-model="content.details"
                                                  :init="tinyMceInit"></tiny-mce>
                                    </div>
                                    <span v-show="errors.has('form.content_details')"
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
    // import tinymce from 'tinymce/tinymce'
    // import 'tinymce/themes/modern/theme'
    import Editor from '@tinymce/tinymce-vue';
    import {tinyMceConfig} from "../../../configs/tinymce";
    import WebUrl from '../../../services/webUrl';
    let webUrl = new WebUrl();
    export default {
        name: "ContentCreate",
        created() {
            this.$store.commit('notRefreshParent')
        },
        data() {
            return {
                content: {
                    title: '',
                    details: ''
                },
                tinyMceInit: tinyMceConfig,
            }
        },
        methods: {
            viewChange(event) {
                console.log('View Change', event)
            },
            addContent(form, event) {
                this.$validator.validateAll(form).then(result => {
                    //If All Input Validate
                    if (result) {

                    }
                })
            },
            backToPreviousPage() {
                if (this.content.title.length > 0 || this.content.details.length > 0) {
                    this.$dialog.confirm("เอกสารยังไม่ได้รับการบันทึก ยืนยันการยกเลิก")
                        .then(() => {
                            // this.$router.push({name:'contents'})
                            this.$router.back();
                        }).catch(() => {
                    })
                } else {
                    // this.$router.push({name:'contents'})
                    this.$router.back();
                }
            },
            saveContent() {
                this.$store.commit('refreshParent');
                // this.$store.dispatch('refreshParent');
                this.$router.push({name: 'content'});
            }
        },
        components: {
            'tiny-mce': Editor
        }
    }
</script>