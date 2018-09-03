<template>
    <div>
        <!-- Use Vue Form Validate-->
        <form @submit.prevent="updateOrCreateContent('form',$event)"
              data-vv-scope="form"
        >
            <!-- Portlet -->
            <div class="portlet">
                <!-- Title -->
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>About Us
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
                            <!--Old Image-->
                            <div v-if="form.images.length > 0" class="col-xs-12">
                                <h3>รูปภาพที่อัพโหลดไว้แล้ว</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <app-table
                                                :columns="['ภาพตัวอย่าง']"
                                                :columnWidths="[100]"
                                                :hasCheckBox="true"
                                                :items="form.images"
                                                :checkedItemsInit="checkedImages"
                                                itemRowClass="text-center"
                                                @deleteItems="deleteOldImage"
                                        >
                                            <template slot="itemColumn" slot-scope="props">
                                                <td><img :src="props.item.path" width="150" height="auto"></td>
                                            </template>
                                        </app-table>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <!-- -- New Image Upload-->
                            <div class="col-md-12">
                                <div class="row">
                                    <div v-if="form.newImages.length > 0" class="col-md-12">
                                        <h3>รูปภาพใหม่</h3>
                                        <app-table
                                                :columns="['ภาพตัวอย่าง','ชื่อภาพ']"
                                                :columnWidths="[50,50]"
                                                :hasCheckBox="true"
                                                :items="form.newImages"
                                                :checkedItemsInit="checkedImages"
                                                itemRowClass="text-center"
                                                @deleteItems="deleteNewImages"
                                        >
                                            <template slot="itemColumn" slot-scope="props">
                                                <td><img :src="props.item.thumb" width="150" height="auto"></td>
                                                <td>{{props.item.name}}</td>
                                            </template>
                                        </app-table>
                                    </div>
                                </div>
                                <!--@input-filter สำหรับกรองรูปและสร้าง thumbnail-->
                                <file-upload
                                        ref="upload"
                                        v-model="form.newImages"
                                        class="btn btn-info"
                                        :multiple="true"
                                        @input-filter="inputFilter"
                                >
                                    เพิ่มรูปภาพ <i class="fa fa-plus"></i>
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

    let webUrl = new WebUrl();
    let contentCategoryService = new ContentCategoryService();
    let contentService = new ContentService();
    export default {
        name: "FixedCategoryContent",
        components: {
            'tiny-mce': Editor,
            FileUpload
        },
        data() {
            return {
                categoryTitle:this.$route.params.categoryTitle,
                form: {
                    title: 'About Us',
                    body: '',
                    category: '',
                    images: [],
                    newImages:[]
                },
                checkedImages:[],
                tinyMceInit: tinyMceConfig
            }
        },
        computed: {
            formDataInput() {
                let formData = new FormData();
                formData.append('title', this.form.title);
                formData.append('body', this.form.body);
                formData.append('category', JSON.stringify(this.form.category));
                this.form.newImages.forEach(image => {
                    //formData.append('ชื่อตัวแปร',ไฟล์,'ชื่อไฟล์ใหม่ที่แก้ไขแล้ว')
                    formData.append('newImages[]', image.file,image.name)
                });
                return formData;
            }
        },
        watch:{
            '$route'(to,from){
                this.categoryTitle = to.params.categoryTitle;
                this.initData();
            }
        },
        created() {
            this.initData();
        },
        methods: {
            initData(){
                this.$store.commit('loading');
                //Get Categories
                this.form.newImages = [];

                contentCategoryService.getCategoryFromTitle(this.categoryTitle)
                    .then(result => {
                        console.log('About Us Category',result);
                        this.form.category = result;
                        if(result.latest_content){
                            this.form.title = result.latest_content.title;
                            this.form.body = result.latest_content.body;
                            this.form.images = result.latest_content.images
                        }
                        this.$store.commit('stopLoading');
                    }).catch(err => {
                    console.log(err)
                })
            },
            updateOrCreateContent(form, event) {
                this.$validator.validateAll(form).then(result => {
                    //If All Input Validate
                    if (result) {
                        this.$store.commit('loading');
                        contentService.updateOrCreateContent(this.formDataInput,this.categoryTitle)
                            .then(result => {
                                this.$store.commit('stopLoading')
                                // this.$store.commit('refreshParent');
                                this.initData();
                                toastr.success('บันทึกเสร็จสมบูรณ์');
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
                            this.$router.push({path: '/content/'+this.categoryTitle});
                        }).catch(() => {
                    })
                } else {
                    this.$router.push({path: '/content/'+this.categoryTitle});
                }
            },
            deleteOldImage(){

            },
            deleteNewImages(param){
                let result='';
                //วน filter เช็ค images ดูว่ามี image อันไหนที่ไม่ตรงกับที่จะลบออก
                this.form.newImages=this.form.newImages.filter(image=>{
                    //โดยใช้ findIndex มาหา index ที่เป็น -1 ก็คือไม่ตรงกับที่จะลบ และ ให้เก็บ image นั้นไว้
                    //อันที่ไม่ใช่ -1 คืออันที่ต้องการลบออก ดั้งนั้นจึงเป็นเหตุผลว่าทำไมต้องเป็น -1
                    return param.checkedItems.findIndex(item=>{
                        return item.id === image.id
                    }) === -1;
                });
            },
            inputFilter(newFile, oldFile, prevent) {
                if (newFile && !oldFile) {
                    console.log('Before Add NEw File ',newFile);
                    //newFile.name=
                    newFile.name = newFile.name.replace(/\s+/g,'-').toLowerCase();
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
            tinyChange(event) {
                console.log('exeCommand :', event);
            },
            viewChange(event) {
                console.log('View Change', event)
            },
        }
    }
</script>

<style scoped>

</style>