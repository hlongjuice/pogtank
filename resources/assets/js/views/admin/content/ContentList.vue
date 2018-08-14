<template>
    <div>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    Contents
                </div>
            </div>
            <div class="portlet-body">
                <!--Table List-->
                <app-table
                        :columns="['ลำดับ','รายการ','แก้ไข']"
                        :columnWidths="[10,40,30]"
                        :hasCheckBox="true"
                        :items="content.data"
                        itemRowClass="text-center"
                        @deleteItems="deleteItems"
                >
                    <template slot="customTopBtn">
                        <div class="col-md-6">
                            <router-link :to="{name:'content_create'}" class="btn btn-primary">สร้างรายการใหม่
                            </router-link>
                        </div>
                    </template>
                    <template slot="itemColumn" slot-scope="props">
                        <td>{{(props.index +1)+(content.per_page * (content.current_page-1)) }}</td>
                        <td>{{props.item.title}}</td>
                        <td><a class="btn btn-warning" @click="editContent(props.item)">แก้ไข</a></td>
                    </template>
                </app-table>
                <pagination :data="content" @pagination-change-page="getContents"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import {ContentService} from "../../../services/content/content_service";

    let contentService = new ContentService();
    export default {
        name: "ContentList",
        data() {
            return {
                content:{
                    data:[],
                    current_page:1
                }
            }
        },
        computed: {
        },
        created() {
            this.$store.commit('loading');
            this.getContents();
        },
        mounted() {
        },
        activated() {
            if (this.$store.getters.refreshParentStatus) {
                this.getContents();
            }
        },
        deactivated() {
            console.log('deactivated')
        },
        methods: {

            getContents(page=1){
                contentService.getAllContents(page)
                    .then(result=>{
                        console.log('Content Result',result);
                        this.content=result;
                        console.log('Content :',result);
                        this.$store.commit('stopLoading');
                    }).catch(err=>{
                        console.log(err)
                })
            },
            editContent(item){
              this.$router.push({path:`edit/${item.id}`});
            },
            deleteItems(params) {
                console.log('Selected Items are' ,params);
                let item_names = params.checkedItems.map(item=>{
                    return item.title;
                }).join("<br />");
                this.$dialog.confirm("<h3>ยืนยันการลบ</h3>" +
                    "<h4>รายการ</h5>" +
                    "<p class='text-danger'>"+item_names+"</p>")
                    .then(() => {
                        this.$store.commit('loading');
                        contentService.deleteContents(params)
                            .then(result=>{
                                this.getContents();
                                console.log('Deleted Contents')
                            }).catch(err=>{console.log(err)})
                    }).catch(() => {
                })
            }
        }
    }
</script>

<style scoped>

</style>