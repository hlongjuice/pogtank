<template>
    <div>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i>หมวดหมู่
                </div>
            </div>
            <div class="portlet-body">
                <!--Category List-->
                <app-table
                        :columns="['ลำดับ','รายการ','แก้ไข']"
                        :columnWidths="[10,60,10]"
                        :hasCheckBox="true"
                        :items="categories"
                        itemRowClass="text-center"
                        @deleteItems="deleteCategories"
                >

                    >
                    <template slot="customTopBtn">
                        <div class="col-md-6">
                            <router-link :to="{name:'content_category_create'}" class="btn btn-primary">
                                สร้างรายการใหม่
                            </router-link>
                        </div>
                    </template>
                    <template slot="itemColumn" slot-scope="props">
                        <td>{{props.index +1 }}</td>
                        <td class="text-left">{{props.item.title}}</td>
                        <!--<td><router-link tag="a" :to="'/content_category/edit/'+props.item.id" class="btn btn-warning">แก้ไข</router-link></td>-->
                        <td><a @click="editCategory(props.item)" class="btn btn-warning">แก้ไข</a></td>
                    </template>
                </app-table>
            </div>
        </div>
    </div>
</template>

<script>
    import {ContentCategoryService} from "../../../../services/content_category/content_category_service";

    let contentCategoryService = new ContentCategoryService();
    export default {
        name: "ContentCategoryList",
        data() {
            return {
                categories: [],
                refreshPageStatus: false,
                form: {
                    selectedCategories: []
                }
            }
        },
        computed: {},
        created() {
            this.$store.commit('loading');
            this.getCategories();
        },
        mounted() {
            // this.showLoading=true;
        },
        //Activated amd Deactivated fired when enable keep-alive for this component
        activated() {
            if (this.$store.getters.refreshParentStatus) {
                this.getCategories();
            }
        },
        deactivated() {

        },
        methods: {
            //Get All Categories
            getCategories() {
                this.showLoading = true;
                contentCategoryService.getAllCategories()
                    .then(result => {
                        this.categories = result;
                        this.$store.commit('stopLoading');
                    }).catch(err => {
                    console.log(err);
                    alert(err);
                    this.$store.commit('stopLoading');
                })
            },
            //Edit Category
            editCategory(item) {
                this.$router.push({
                    path: `edit/${item.id}`
                });
            },
            //Delete Categories
            deleteCategories(event) {
                this.$dialog.confirm("<h3>ยืนยันการลบ</h3>" +
                    "<p class='text-danger'>*** การลบหมวดหมู่หลัก จะลบหมวดหมู่รองไปด้วย</p>")
                    .then(() => {
                        this.$store.commit('loading');
                        contentCategoryService.deleteCategories(event)
                            .then(result => {
                                this.getCategories();
                            }).catch(err => {
                            console.log(err)
                        })
                    }).catch(() => {
                });
            }
        },
    }
</script>

<style scoped>

</style>