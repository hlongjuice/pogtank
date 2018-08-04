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
                        <td></td>
                    </template>
                </app-table>
            </div>
        </div>
    </div>
</template>

<script>
    import {ContentCategoryService} from "../../../services/content_category/content_category_service";

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
        computed: {
        },
        created() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                console.log('Get Categories');
                contentCategoryService.getAllCategories()
                    .then(result => {
                        this.categories = result;
                    }).catch(err => {
                    console.log(err)
                })
            },
            //Delete Categories
            deleteCategories(event) {
                console.log('Delete Event : ', event);
            }
        },
        //Activated amd Deactivated fired when enable keep-alive for this component
        activated(){
            if(this.$store.getters.refreshParentStatus){
                this.getCategories();
            }
        },
        deactivated(){

        }
    }
</script>

<style scoped>

</style>