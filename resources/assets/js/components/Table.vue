<template>
    <div>
        <div class="row">
            <slot name="customTopBtn">

            </slot>
            <div class="col-md-6 pull-right text-right margin-bottom-10">
                <a @click="deleteItems" v-if="hasCheckBox" class="btn btn-danger">ลบหลายรายการ</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <!-- -- -- --Table Header -->
                        <thead>
                        <tr :class="headerRowClass">
                            <!--Has Checkbox ?-->
                            <th v-if="hasCheckBox" class="text-center" width="5%">
                                <label>
                                    <input v-model="checkedAllItems" type="checkbox">
                                </label>
                            </th>
                            <template v-for="(column,index) in columns">
                                <!--ถ้ามี custom Header จะไม่แสดงส่วนนี้-->
                                <template v-if="!customHeaderColumn">
                                    <th
                                            :class="columnClass[index] || ''"
                                            :width="(columnWidths[index] || '') +'%'"
                                            :colspan="colSpan"
                                            :rowspan="rowSpan">
                                        {{column}}
                                    </th>
                                </template>
                            </template>
                            <th v-if="hasDeleteSingleItemBtn">ลบ</th>
                            <!--Custom Header Slot-->
                            <slot v-if="customHeaderColumn" name="customHeaderColumn">
                            </slot>
                        </tr>
                        </thead>
                        <!-- -- -- --Table Body -->
                        <tbody>
                        <!--Table Items-->
                        <tr  :class="itemRowClass" v-for="(item,index) in items">
                            <td class="text-center" v-if="hasCheckBox">
                                <label><input :value="item" v-model="checkedItems" type="checkbox"/></label>
                            </td>
                            <slot name="itemColumn" :item="item" :index="index">

                            </slot>
                            <td v-if="hasDeleteSingleItemBtn" class="text-center">
                                <a class="btn btn-danger" @click="deleteSingleItem(item)">ลบ</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Pagination from 'laravel-vue-pagination';

    export default {
        props: {
            items: {
                type: Array
            },
            columns: {
                type: Array
            },
            //Optional Option
            columnWidths: {
                type: Array,
                default: () => []
            },
            columnClass:{
              type:Array,
              default:()=>[]
            },
            headerRowClass:{
              type:String,
              default:'table-row-th-center'
            },
            itemRowClass:{
                type:String,
                default:''
            }
            ,
            hasCheckBox: {
                type: Boolean,
                default: false
            },
            hasDeleteSingleItemBtn:{
                type:Boolean,
                default:true
            },
            colSpan: {
                type: Number,
                default: null
            },
            rowSpan: {
                type: Number,
                default: null
            },
            customHeaderColumn: {
                type: Boolean,
                default: false
            },
            showPage: {
                default: false
            }
        },
        data(){
            return{
                checkedAllItems:false,
                checkedItems: []
            }
        },
        computed: {
        },
        components: {
            'pagination': Pagination
        },
        watch: {
            checkedAllItems(state) {
                this.checkedItems.splice(0);
                if(state)
                this.items.forEach(item => {
                    this.checkedItems.push(item);
                });
            },
            items(){
                if(this.items.length===0){
                    this.checkedAllItems = false;
                }
            }
        },
        methods: {
            //send checkedItems back to parent
            deleteSingleItem(item){
                this.checkedAllItems=false;
                this.checkedItems.splice(0);
                this.checkedItems.push(item);
                this.deleteItems();
            }
            ,
            deleteItems(){
                this.$emit('deleteItems',{
                    checkedItems:this.checkedItems
                })
            }
        }
    }
</script>