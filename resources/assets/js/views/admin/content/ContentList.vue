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
                        :items="tableItems"
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
                        <td>{{props.index +1 }}</td>
                        <td>{{props.item.name}}</td>
                        <td><a class="btn btn-warning" @click="editContent(props.item)">แก้ไข</a></td>
                    </template>
                </app-table>
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
                tableItems: [
                    {id:1,name:'A'},
                    {id:2,name:'B'},
                    {id:3,name:'C'}],
            }
        },
        computed: {
            refreshData() {
                console.log('Data Refresh', this.$store.getters.refreshParentStatus);
                return this.$store.getters.refreshParentStatus;
            }
        },
        created() {
        },
        mounted() {
        },
        beforeRouteUpdate (to, from, next) {
           console.log('Before Route Update');
        },
        activated() {

        },
        deactivated() {
            console.log('deactivated')
        },
        methods: {
            editContent(item){
              this.$router.push({name:'content_edit',params:{id:item.id}})
            },
            deleteItems(params) {
                //params คือ checked Item from Table Component
                console.log('Delete Items Methods Data', params.checkedItems);
                //remove item ที่เลือก selected items
                this.tableItems = this.tableItems.filter(item => {
                        return !params.checkedItems.find(checkedItem => checkedItem === item)
                    }
                )
            }
        }
    }
</script>

<style scoped>

</style>