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
                            <!-- -- File Upload-->
                            <div class="col-md-12">
                                <div class="row">
                                    <div v-if="form.images.length > 0" class="col-md-12">
                                        <app-table
                                                :columns="['ภาพตัวอย่าง','ชื่อภาพ']"
                                                :columnWidths="[50,50]"
                                                :hasCheckBox="true"
                                                :items="form.images"
                                                :checkedItemsInit="checkedImages"
                                                itemRowClass="text-center"
                                                @deleteItems="deleteImages"
                                        >
                                            <template slot="itemColumn" slot-scope="props">
                                                <td><img :src="props.item.thumb" width="150" height="auto"></td>
                                                <td>{{props.item.name}}</td>
                                            </template>
                                        </app-table>
                                    </div>
                                </div>
                                <file-upload
                                        ref="upload"
                                        v-model="form.images"
                                        class="btn btn-default"
                                        :multiple="true"
                                        @input-filter="inputFilter"
                                        @input-file="inputFile"
                                >
                                    Upload File <i class="fa fa-plus"></i>
                                </file-upload>
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
    import FileUpload from 'vue-upload-component';
    import {ContentImageService} from "../../../services/content/image_upload_service";

    let webUrl = new WebUrl();
    let contentCategoryService = new ContentCategoryService();
    let contentService = new ContentService();
    let contentImageService = new ContentImageService();
    export default {
        name: "PortfolioCreate",
        components: {
            'tiny-mce': Editor,
            FileUpload
        },
        data() {
            return {
                form: {
                    title: '',
                    body: '',
                    category: '',
                    images: [],
                    files: []
                },
                checkedImages:[],
                categories: [],
                tinyMceInit: tinyMceConfig
            }
        },
        computed: {
            formDataInput() {
                let formData = new FormData();
                formData.append('title', this.form.title);
                formData.append('body', this.form.body);
                formData.append('category', this.form.category);
                this.form.images.forEach(image => {
                    formData.append('images[]', image.file)
                });
                return formData;
            }
        },
        watch: {
            'form.images'() {
                console.log('Images Change');
                this.form.files.splice(0);
                this.form.images.forEach(image => {
                    this.form.files.push(image.file);
                })
            }
        },
        created() {
            //กำหนด vuex state ไม่ใช้ refresh parent component
            this.$store.commit('notRefreshParent');
            //Get Categories
            contentCategoryService.getAllCategories('Portfolio')
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
                                this.$router.push({name: 'portfolio'});
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
                            this.$router.push({name: 'portfolio'});
                        }).catch(() => {
                    })
                } else {
                    this.$router.push({name: 'portfolio'});
                }
            },
            saveContent() {
                //ทำการ refresh component เพราะมีการ save data ใหม่
                this.$store.commit('refreshParent');
                //Route back to Content Page
                this.$router.push({name: 'portfolio'});
            },
            tinyChange(event) {
                console.log('exeCommand :', event);
            },
            deleteImages(param){
                let result='';
                this.form.images=this.form.images.filter(image=>{
                    return param.checkedItems.findIndex(item=>{
                       return item.id === image.id
                    }) === -1;
                })
                console.log('images',result);

            },
            inputFilter(newFile, oldFile, prevent) {
                if (newFile && !oldFile) {
                    // Before adding a file
                    // 添加文件前
                    // Filter system files or hide files
                    // 过滤系统文件 和隐藏文件
                    if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
                        return prevent()
                    }
                    // Filter php html js file
                    // 过滤 php html js 文件
                    if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
                        return prevent()
                    }
                    // Automatic compression
                    // 自动压缩
                    if (newFile.file && newFile.type.substr(0, 6) === 'image/' && this.autoCompress > 0 && this.autoCompress < newFile.size) {
                        newFile.error = 'compressing'
                        const imageCompressor = new ImageCompressor(null, {
                            convertSize: Infinity,
                            maxWidth: 512,
                            maxHeight: 512,
                        })
                        imageCompressor.compress(newFile.file)
                            .then((file) => {
                                this.$refs.upload.update(newFile, {error: '', file, size: file.size, type: file.type})
                            })
                            .catch((err) => {
                                this.$refs.upload.update(newFile, {error: err.message || 'compress'})
                            })
                    }
                }
                if (newFile && (!oldFile || newFile.file !== oldFile.file)) {
                    // Create a blob field
                    // 创建 blob 字段
                    newFile.blob = ''
                    let URL = window.URL || window.webkitURL
                    if (URL && URL.createObjectURL) {
                        newFile.blob = URL.createObjectURL(newFile.file)
                    }
                    // Thumbnails
                    // 缩略图
                    newFile.thumb = ''
                    if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
                        newFile.thumb = newFile.blob
                    }
                }
            },
            inputFile(newFile, oldFile) {
                if (newFile && !oldFile) {
                    // Add file
                }

                if (newFile && oldFile) {
                    // Update file

                    // Start upload
                    if (newFile.active !== oldFile.active) {
                        console.log('Start upload', newFile.active, newFile)

                        // min size
                        if (newFile.size >= 0 && newFile.size < 100 * 1024) {
                            newFile = this.$refs.upload.update(newFile, {error: 'size'})
                        }
                    }

                    // Upload progress
                    if (newFile.progress !== oldFile.progress) {
                        console.log('progress', newFile.progress, newFile)
                    }

                    // Upload error
                    if (newFile.error !== oldFile.error) {
                        console.log('error', newFile.error, newFile)
                    }

                    // Uploaded successfully
                    if (newFile.success !== oldFile.success) {
                        console.log('success', newFile.success, newFile)
                    }
                }

                if (!newFile && oldFile) {
                    // Remove file

                    // Automatically delete files on the server
                    if (oldFile.success && oldFile.response.id) {
                        // $.ajax({
                        //   type: 'DELETE',
                        //   url: '/file/delete?id=' + oldFile.response.id,
                        // });
                    }
                }

                // Automatic upload
                if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
                    if (!this.$refs.upload.active) {
                        this.$refs.upload.active = true
                    }
                }
            },
        }
    }
</script>

<style scoped>

</style>