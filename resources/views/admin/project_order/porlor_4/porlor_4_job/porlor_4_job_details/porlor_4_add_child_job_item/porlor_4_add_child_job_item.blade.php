<modal
        name="porlor-4-add-child-job-item-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenAddChildJobItemModal($event)"
        @opened="openedAddChildJobItemModal"
        @before-close="beforeCloseAddChildJobItemModal"
        width="90%"
        height="auto"
        :scrollable="true"
>
    <loading
            :show='add_child_job_item.isLoading'
    >
    </loading>
    <div class="row">
        <!-- FORM-->
        <form
                @submit.prevent="addChildJobItem('form',$event)"
                data-vv-scope="form"
                class="horizontal-form">
            {{csrf_field()}}
            <div class="col-xs-12">

                <div class="panel panel-default">
                    {{-- Close Button--}}
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            <h4>เพิ่มรายการวัสดุ</h4>
                        </div>
                        <button type="button" class="btn btn-danger" @click="closeAddChildJobItemModal">Close
                        </button>
                        <button type="submit" class="col-md-3 pull-right btn btn-success">
                            บันทึก
                        </button>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12">
                            <div class="row">
                                <h3 v-if="add_child_job_item.form.child_job.name_per_unit!=''">
                                    @{{ add_child_job_item.form.child_job.name_per_unit }}
                                </h3>
                                <h3 v-else>
                                    @{{ add_child_job_item.form.child_job.name }}
                                </h3>
                                <hr>
                            </div>
                        </div>
                        {{--Job Parent กลุ่มรายการ--}}
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption"></div>
                            </div>
                            <div class="portlet-body">
                                {{-- -- Job Level--}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">กลุ่มรายการ</label>
                                            <div :class="{'input-error':errors.has('form.add_child_job_item_child_job')}">
                                                <multiselect
                                                        v-model="add_child_job_item.form.child_job"
                                                        placeholder="พิมพ์เพื่อค้นหา" label="name"
                                                        track-by="id"
                                                        :options="add_child_job_item.leaf_jobs"
                                                        :option-height="104"
                                                        :show-labels="false"
                                                        :allow-empty="false"
                                                        :max-height="180"
                                                        :custom-label="childJobCustomLabel"
                                                >
                                                    <template slot="option" slot-scope="props">
                                                        <div class="option__desc">
                                                            <span class="option__title">@{{ props.option.job_order_number }} @{{ props.option.name }}</span>
                                                        </div>
                                                    </template>
                                                    <span class="text-secondary"
                                                          slot="noResult">ไม่พบข้อมูลที่ค้นหา</span>
                                                </multiselect>
                                                <input v-validate="'required'"
                                                       name="add_child_job_item_child_job" hidden
                                                       v-model="add_child_job_item.form.child_job">
                                            </div>
                                            <span v-show="errors.has('form.add_child_job_item_child_job')"
                                                  class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <h4 class="text-danger">** ราคาที่แสดง เป็นราคากลางจากระบบ
                                ผู้ใช้สามารถปรับแก้ไขได้</h4>
                        </div>

                        <div class="col-md-4">
                            <a @click="addChildJobItem_AddMoreInputs"
                               class="pull-right btn btn-primary margin-bottom-10">
                                + เพิ่มรายการ</a>
                        </div>
                        {{--Items Loop--}}
                        <template v-for="(item,index) of add_child_job_item.form.items">
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">รายการที่ : @{{ index+1 }}</div>
                                    <div class="actions">
                                        <a v-if="add_child_job_item.form.items.length > 1"
                                           @click="addChildJobItemDeleteInput(index)" class="btn btn-danger btn-sm">
                                            <i class="far fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    {{--Order Number and Material Type Material Item--}}
                                    <div class="row">
                                        {{--ยกเลิกการแยกประเภท items ตาม type มาเป็นเลือก 200 items ล่าสุดแทน--}}
                                        {{--Material Types--}}
                                        {{--<div class="col-xs-12 col-md-4">--}}
                                        {{--<div class="form-group">--}}
                                        {{--<label class="control-label">หมวดหมู่วัสดุ/งาน</label>--}}
                                        {{--<div :class="{'input-error':errors.has('form.add_child_job_item_material_type_'+index)}">--}}
                                        {{--<multiselect--}}
                                        {{--@close="getMaterialItemsOfType(index)"--}}
                                        {{--v-model="item.material_type"--}}
                                        {{--placeholder="พิมพ์เพื่อค้นหา" label="name"--}}
                                        {{--track-by="id"--}}
                                        {{--:options="item.material_types"--}}
                                        {{--:option-height="104"--}}
                                        {{--:show-labels="false"--}}
                                        {{--:allow-empty="false"--}}
                                        {{--:max-height="250"--}}
                                        {{-->--}}
                                        {{--<template slot="option" slot-scope="props">--}}
                                        {{--<div class="option__desc">--}}
                                        {{--<span class="option__title">@{{ props.option.name }}</span>--}}
                                        {{--</div>--}}
                                        {{--</template>--}}
                                        {{--<span class="text-secondary"--}}
                                        {{--slot="noResult">ไม่พบข้อมูลที่ค้นหา</span>--}}
                                        {{--</multiselect>--}}
                                        {{--<input v-validate="'required'"--}}
                                        {{--:data-vv-name="'add_child_job_item_material_type_'+index"--}}
                                        {{--hidden--}}
                                        {{--v-model="item.material_type">--}}
                                        {{--</div>--}}
                                        {{--<span v-show="errors.has('form.add_child_job_item_material_type_'+index)"--}}
                                        {{--class="text-error text-danger">กรุณาระบุข้อมูล</span>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}

                                        {{--Material Item--}}
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">วัสดุ/งาน</label>
                                                <div :class="{'input-error':errors.has('form.add_child_job_item_material_item_'+index)}">
                                                    <multiselect
                                                            @search-change="addChildJobItem_SearchItemsByName(item,$event)"
                                                            :id="index"
                                                            @close="addChildJobItemGetItemDetails(index,item.material_item.approved_global_details)"
                                                            v-model="item.material_item"
                                                            placeholder="พิมพ์เพื่อค้นหา" track-by="id"
                                                            :options="item.material_items"
                                                            :option-height="104"
                                                            :show-labels="false"
                                                            :allow-empty="false"
                                                            :max-height="250"
                                                            :custom-label="materialItemCustomLabel"
                                                            :loading="add_child_job_item.new_material_item.is_loading"
                                                            ref="myMulti"
                                                            {{--:loading="add_child_job_item.isLoading"--}}
                                                    >
                                                        <template v-if="props.option.approved_global_details"
                                                                  slot="option" slot-scope="props">
                                                            <div class="option__desc">
                                                                <span class="option__title">
                                                                    @{{ props.option.approved_global_details.name }}
                                                                </span>
                                                            </div>
                                                        </template>
                                                        <template slot="clear" slot-scope="props">
                                                            <div class="multiselect-add-new-item-btn"
                                                                 v-if="item.material_items.length ">
                                                                <template v-if="props.search">
                                                                    <a v-if="add_child_job_item.show_real_time_add_new_material_button"
                                                                       @click="addChildJobItem_AddNewMaterialItem(item,index,$event)"
                                                                       class=" btn btn-primary">เพิ่มรายการใหม่</a>
                                                                </template>
                                                            </div>
                                                        </template>
                                                        <div class="row"
                                                             slot="noResult">
                                                            <div class="col-xs-12">
                                                                <p>ยังไม่มีรายการในระบบ</p>
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <span>@{{add_child_job_item.new_material_item.name}} </span>
                                                                <a v-if="add_child_job_item.show_add_new_material_button"
                                                                   @click="addChildJobItem_AddNewMaterialItem(item,index)"
                                                                   class="pull-right btn btn-primary">เพิ่มรายการใหม่</a>
                                                            </div>
                                                        </div>
                                                    </multiselect>
                                                    <input
                                                            :data-vv-name="'add_child_job_item_material_item_'+index"
                                                            hidden
                                                            v-model="item.material_item">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_item_material_item_'+index)"
                                                      class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div>
                                                <a @click="test_click" ref="testClick" class="btn btn-danger">Test Click</a>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Price and Wage and Quantity --}}
                                    <div v-if="item.material_item" class="row">
                                        <!-- -- Quantity and Unit -->
                                        <div class="col-xs-12 col-md-4">
                                            <div class="row">
                                                <div class="col-xs-8">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            จำนวน
                                                        </label>
                                                        <div :class="{'input-error':errors.has('form.add_child_job_item_quantity_'+index)}">
                                                            {{--<input v-validate="'required'"--}}
                                                            {{--type="number"--}}
                                                            {{--step="0.001"--}}
                                                            {{--:data-vv-name="'add_child_job_item_quantity_'+index"--}}
                                                            {{--class="form-control"--}}
                                                            {{--v-model="item.quantity"--}}
                                                            {{-->--}}
                                                            <vue-numeric
                                                                    name="itemQuantity" :precision=2
                                                                    class="form-control" separator=","
                                                                    v-model="item.quantity"></vue-numeric>
                                                        </div>
                                                        <span v-show="errors.has('form.add_child_job_item_quantity_'+index)"
                                                              class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            หน่วย
                                                        </label>
                                                        <div :class="{'input-error':errors.has('form.add_child_job_item_unit_'+index)}">
                                                            <input v-validate="'required'"
                                                                   type="text"
                                                                   :data-vv-name="'add_child_job_item_unit_'+index"
                                                                   class="form-control"
                                                                   v-model="item.unit">
                                                        </div>
                                                        <span v-show="errors.has('form.add_child_job_item_unit_'+index)"
                                                              class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- -- Price -->
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    ราคา/หน่วย
                                                </label>
                                                <vue-numeric
                                                        name="globalCost" :precision=2
                                                        class="form-control" separator=","
                                                        v-model="item.local_price"></vue-numeric>
                                            </div>
                                        </div>
                                        <!-- -- Wage -->
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    ค่าแรง/หน่วย
                                                </label>
                                                <vue-numeric
                                                        name="globalCost" :precision=2
                                                        class="form-control" separator=","
                                                        v-model="item.local_wage"></vue-numeric>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </form>
    </div>

</modal>