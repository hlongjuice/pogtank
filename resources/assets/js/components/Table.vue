<template>
    <div>
        <div class="row">
            <!-- Custom 1 Button-->
            <slot name="customTopBtn">

            </slot>
            <!--Delete  Multiple Item Button-->
            <div class="col-md-6 pull-right text-right margin-bottom-10">
                <a @click="deleteItems" v-if="hasCheckBox" class="btn btn-danger">ลบหลายรายการ</a>
            </div>
            <div class="clearfix"></div>
            <!--Custom 2  Search-->
            <!--Search Text Box-->
            <div v-if="hasSearchBox" class="col-md-6 text-right margin-bottom-10">
                <div class="input-group">
                    <input v-model="searchText" type="text" class="form-control">
                    <span class="input-group-btn">
                        <a class="btn btn-default">
                            ค้นหา <i class="fa fa-search"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!--Search By Category-->
            <div v-if="hasSearchByCategory" class="col-md-4 text-right pull-right margin-bottom-10">
                <!-- label คือ object key ที่จะใช้แสดงหลังเลือก เช่น name,title -->
                <multiselect
                        @select="getSelectedCategory"
                        v-model="selectedCategory"
                        placeholder="กรองด้วยหมวดหมู่" label="title" track-by="id"
                        :options="categories" :option-height="104"
                        :show-labels="false"
                        :allow-empty="false"
                        :max-height="150"
                >
                    <template slot="option" slot-scope="props">
                        <div class="option__desc">
                            <span class="option__title"> {{ props.option.title }}</span>
                        </div>
                    </template>
                </multiselect>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <!-- -- -- --Table Header -->
                        <thead v-if="columns.length > 0">
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
                        <tr :class="itemRowClass" v-for="(item,index) in items">
                            <!--CheckBox-->
                            <td class="text-center" v-if="hasCheckBox">
                                <label><input :value="item" v-model="checkedItems" type="checkbox"/></label>
                            </td>
                            <slot name="itemColumn" :item="item" :index="index">

                            </slot>
                            <!--Delete Button-->
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
    import MultiSelect from 'vue-multiselect';

    export default {
        components: {
            'pagination': Pagination,
            'multiselect': MultiSelect
        },
        props: {
            columns: {
                type: Array
            },
            //Optional Option
            columnWidths: {
                type: Array,
                default: () => []
            },
            columnClass: {
                type: Array,
                default: () => []
            },
            checkedItemsInit: {
                type: Array,
                default: () => []
            },
            colSpan: {
                type: Number,
                default: null
            },
            customHeaderColumn: {
                type: Boolean,
                default: false
            },
            categories: {
                type: Array,
                default: () => []
            },
            headerRowClass: {
                type: String,
                default: 'table-row-th-center'
            },
            hasCheckBox: {
                type: Boolean,
                default: false
            },
            hasSearchBox: {
                type: Boolean,
                default: false
            },
            hasSearchByCategory: {
                type: Boolean,
                default: false
            }
            ,
            hasDeleteSingleItemBtn: {
                type: Boolean,
                default: true
            },
            itemRowClass: {
                type: String,
                default: ''
            },
            items: {
                type: Array
            }
            ,
            rowSpan: {
                type: Number,
                default: null
            },
            showPage: {
                default: false
            }
        },
        data() {
            return {
                checkedAllItems: false,
                checkedItems: [],
                selectedCategory: '',
                searchText: ''
            }
        },
        computed: {},
        watch: {
            checkedAllItems(state) {
                this.checkedItems.splice(0);
                if (state)
                    this.items.forEach(item => {
                        this.checkedItems.push(item);
                    });
            },
            items() {
                if (this.items.length === 0) {
                    this.checkedAllItems = false;
                }
            },
            checkedItemsInit(state) {
                //ถ้าไม่มี data เลยให้ checkAllItem เป็น false
                if (state.length === 0) {
                    this.checkedAllItems = false;
                }
                //ปรับให้ checkedItems  =  ค่าที่เปลี่ยนใหม่ของ Props
                this.checkedItems = state;
                //Emit ค่าที่เช็คได้กลับไปทุกครั้ง
                this.$emit('checkedItemsList', {
                    checkedItems: this.checkedItems
                })
            },
            searchText(){
                this.$emit('searchChange', {
                    searchText: this.searchText
                })
            }
        },
        methods: {
            getSelectedCategory(params){
                this.$emit('selectedCategory',{
                    selectedCategory:params
                })
            },
            //send checkedItems back to parent
            deleteSingleItem(item) {
                this.checkedAllItems = false;
                this.checkedItems.splice(0);
                //ใช้ SetTimeOut เพราะทุกครั้ง ที่ checkedAllItems ผูกกับ Watch หากมี Watch CheckedAllItems fired จะทำให้ค่าที่ push มาใหม่โดนเคลียไปด้วย
                //เลยต้องทำให้เป็น Async โดยใช้ setTimeout
                setTimeout(() => {
                    this.checkedItems.push(item);
                    this.deleteItems();
                }, 1);
            }
            ,
            deleteItems() {
                this.$emit('deleteItems', {
                    checkedItems: this.checkedItems
                })
            }
        }
    }
</script>