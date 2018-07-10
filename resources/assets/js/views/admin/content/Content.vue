<template>
    <div v-cloak class="row">
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
                            @checkedItems="testEmit"
                    >
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
        data() {
            return {
                tableItems: ['A','B','C']
            }
        },
        created() {
        },
        mounted() {
        },
        methods:{
            testEmit(event){
                console.log(event)
            }
        }
    }
</script>