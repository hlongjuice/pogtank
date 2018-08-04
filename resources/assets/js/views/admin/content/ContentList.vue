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
                        <td>{{props.item}}</td>
                        <td></td>
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
                tableItems: ['A', 'B', 'C'],
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
        methods: {
            deleteItems(params) {
                //params คือ checked Item from Table Component
                console.log('Delete Items Methods Data', params.checkedItems);
                //remove item ที่เลือก selected items
                this.tableItems = this.tableItems.filter(item => {
                        return !params.checkedItems.find(checkedItem => checkedItem === item)
                    }
                )
            }
        },
        activated() {

        },
        deactivated() {
            console.log('deactivated')
        }
    }
</script>

<style scoped>

</style>