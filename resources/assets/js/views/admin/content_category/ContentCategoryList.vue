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
                        :columnWidths="[10,40,30]"
                        :hasCheckBox="true"
                        :items="tableItems"
                        itemRowClass="text-center">
                        <!--@deleteItems="deleteItems"-->
                >
                    <template slot="customTopBtn">
                        <div class="col-md-6">
                            <router-link :to="{name:'content_category_create'}" class="btn btn-primary">สร้างรายการใหม่</router-link>
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
    export default {
        name: "ContentCategoryList",
        data(){
            return {
                tableItems:[]
            }
        }
    }
</script>

<style scoped>

</style>