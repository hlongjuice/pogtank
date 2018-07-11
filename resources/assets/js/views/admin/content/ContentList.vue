<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        Contents
                    </div>
                </div>
                <div class="portlet-body">
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
                                <router-link :to="{name:'contents-create'}" class="btn btn-primary">สร้างรายการใหม่</router-link>
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
    </div>
</template>

<script>
    export default {
        name: "ContentList",
        data() {
            return {
                tableItems: ['A', 'B', 'C']
            }
        },
        created() {
            console.log('Create Content');
        },
        mounted() {
        },
        methods: {
            deleteItems(params) {
                console.log('Delete Items Methods Data',params.checkedItems);
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