<template>
    <div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <!-- -- -- --Table Header -->
                <thead>
                <tr :class="headerRowClass">
                    <!--Has Checkbox ?-->
                    <th v-if="hasCheckBox" class="text-center" width="5%">
                        <label>
                            <input v-model="chkAllItems" type="checkbox">
                        </label>
                    </th>
                    <template v-for="(column,index) in columns">
                        <!--ถ้ามี custom Header จะไม่แสดงส่วนนี้-->
                        <template v-if="!customColumn">
                            <th
                                    :class="columnClass[index] || ''"
                                    :width="(columnWidths[index] || '') +'%'"
                                    :colspan="colSpan"
                                    :rowspan="rowSpan">
                                {{column}}
                            </th>
                        </template>
                        <!--Custom Header Slot-->
                        <slot v-if="customColumn" name="customColumn" :column="column">
                        </slot>
                    </template>
                </tr>
                </thead>
                <!-- -- -- --Table Body -->
                <tbody>
                <!--Table Items-->
                <tr  :class="itemRowClass" v-for="(item,index) in items">
                    <td class="text-center" v-if="hasCheckBox">
                        <label><input :value="item" v-model="chkItems" type="checkbox"/></label>
                    </td>
                    <slot name="itemColumn" :item="item" :index="index">

                    </slot>
                </tr>
                </tbody>
            </table>
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
            colSpan: {
                type: Number,
                default: null
            },
            rowSpan: {
                type: Number,
                default: null
            },
            customColumn: {
                type: Boolean,
                default: false
            },
            showPage: {
                default: false
            }
        },
        data(){
            return{
                chkAllItems:false,
                chkItems: []
            }
        },
        computed: {
        },
        components: {
            'pagination': Pagination
        },
        watch: {
            chkAllItems(state) {
                this.chkItems.splice(0);
                if(state)
                this.items.forEach(item => {
                    this.chkItems.push(item);
                });
            },
            chkItems(){
                //Call CheckedItems Method to send checkedItems back to parent
                this.checkedItems()
            }
        },
        methods: {
            //send checkedItems back to parent
            checkedItems(){
                this.$emit('checkedItems',{
                    items:this.chkItems
                })
            }
        }

    }
</script>