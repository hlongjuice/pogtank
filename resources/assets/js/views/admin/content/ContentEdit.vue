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
    import {ContentService} from "../../../services/content/content_service";
    import {ContentCategoryService} from "../../../services/content_category/content_category_service";
    import {tinyMceConfig} from "../../../configs/tinymce";
    import TinyMce from '@tinymce/tinymce-vue';
    import FileUpload from 'vue-upload-component';

    let contentService = new ContentService();
    let contentCategoryService = new ContentCategoryService();
    export default {
        name: "ContentEdit",
        components: {
            'tiny-mce': TinyMce,
            FileUpload
        },
        data(){
          return{
              categoryTitle:this.$route.params.categoryTitle,
              form:{
                  id:this.$route.params.id,
                  title:'',
                  body:'',
                  category:'',
                  images:[],
                  newImages:[]
              },
              checkedImages:[],
              checkedNewImages:[],
              categories:[],
              tinyMceInit:tinyMceConfig
          }
        },
        computed:{
            formDataInput() {
                let formData = new FormData();
                formData.append('id',this.form.id);
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
        created(){
            this.$store.commit('loading');
            Promise.all([
                contentService.getContent(this.form.id)
                    .then(result=>{
                        console.log('result',result);
                        this.form.title = result.title;
                        this.form.body = result.body;
                        this.form.category = result.category;
                        this.form.images = result.images;
                    }).catch(err=>{console.log(err)}),
                contentCategoryService.getAllCategories()
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
            backToPreviousPage(){
                this.$router.push({path:'/content/'+this.categoryTitle})
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
            updateContent(form){
                this.$validator.validateAll(form).then(result => {
                    //If All Input Validate
                    if (result) {
                        this.$store.commit('loading');
                        contentService.updateContent(this.formDataInput)
                            .then(result=>{
                                this.$store.commit('refreshParent');
                                this.$router.push({path:'/content/'+this.categoryTitle});
                            }).catch(err=>{

                        })
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>