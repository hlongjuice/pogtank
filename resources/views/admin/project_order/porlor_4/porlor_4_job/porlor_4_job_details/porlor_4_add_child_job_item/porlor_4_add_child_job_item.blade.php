<modal
        name="porlor-4-add-child-job-item-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenAddChildJobItemModal($event)"
        @opened="openedAddChildJobItemModal"
        @before-close="beforeCloseAddChildJobItemModal"
        width="90%"
        height="90%"
        :scrollable="true"
>
    <loading
            :show='add_child_job_item.isLoading'
    >
    </loading>
    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-default">
                {{-- Close Button--}}
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closeAddChildJobItemModal">Close</button>
                </div>
                <div class="panel-body">
                    <!-- FORM-->
                    <form
                            @submit.prevent="addChildJobItem('form',$event)"
                            data-vv-scope="form"
                            class="horizontal-form">
                        {{csrf_field()}}
                        <div class="col-xs-12">
                            <button type="submit" class="col-xs-3 pull-right btn btn-success margin-bottom-20">
                                บันทึก
                            </button>
                        </div>
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-reorder"></i>รายการวัสดุ/งาน
                                </div>
                            </div>
                            <div class="portlet-body form">

                                <div class="form-body">
                                    {{--Level--}}
                                    <div class="row">
                                        {{-- -- Job Level--}}
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
                                    {{--Order Number and Material Type Material Item--}}
                                    <div class="row">
                                        {{--Material Types--}}
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">หมวดหมู่วัสดุ/งาน</label>
                                                <div :class="{'input-error':errors.has('form.add_child_job_item_material_type')}">
                                                    <multiselect
                                                            @close="getMaterialItemsOfType"
                                                            v-model="add_child_job_item.form.material_type"
                                                            placeholder="พิมพ์เพื่อค้นหา" label="name"
                                                            track-by="id"
                                                            :options="add_child_job_item.material_types"
                                                            :option-height="104"
                                                            :show-labels="false"
                                                            :allow-empty="false"
                                                            :max-height="180"
                                                    >
                                                        <template slot="option" slot-scope="props">
                                                            <div class="option__desc">
                                                                <span class="option__title">@{{ props.option.name }}</span>
                                                            </div>
                                                        </template>
                                                        <span class="text-secondary"
                                                              slot="noResult">ไม่พบข้อมูลที่ค้นหา</span>
                                                    </multiselect>
                                                    <input v-validate="'required'"
                                                           name="add_child_job_item_material_type" hidden
                                                           v-model="add_child_job_item.form.material_type">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_item_material_type')"
                                                      class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                            </div>
                                        </div>
                                        {{--Material Item--}}
                                        <div class="col-xs-12 col-md-4">
                                            <div v-if="add_child_job_item.form.material_type"
                                                 class="form-group">
                                                <label class="control-label">วัสดุ/งาน</label>
                                                <div :class="{'input-error':errors.has('form.add_child_job_item_material_item')}">
                                                    <multiselect
                                                            @search-change="searchMaterialItemsOfType"
                                                            v-model="add_child_job_item.form.material_item"
                                                            placeholder="พิมพ์เพื่อค้นหา" track-by="id"
                                                            :options="add_child_job_item.material_items"
                                                            :option-height="104"
                                                            :show-labels="false"
                                                            :allow-empty="false"
                                                            :max-height="180"
                                                            :custom-label="materialItemCustomLabel"
                                                            {{--:loading="add_child_job_item.isLoading"--}}
                                                    >
                                                        <template slot="option" slot-scope="props">
                                                            <div class="option__desc">
                                                                <span class="option__title">@{{ props.option.approved_global_details.name }}</span>
                                                            </div>
                                                        </template>
                                                        <span class="text-secondary"
                                                              slot="noResult">ไม่พบข้อมูลที่ค้นหา</span>
                                                    </multiselect>
                                                    <input v-validate="'required'"
                                                           name="add_child_job_item_material_item" hidden
                                                           v-model="add_child_job_item.form.material_item">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_item_material_item')"
                                                      class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                            </div>
                                        </div>

                                        {{--Quantity Factor and Unit--}}
                                        <div v-if="add_child_job.form.parent.id >0" class="row">
                                            {{--Quantity Factor--}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">จำนวน</label>
                                                    <div :class="{'input-error':errors.has('form.add_child_job_quantity_factory')}">
                                                        <input v-validate="'required'"
                                                               name="add_child_job_quantity_factor"
                                                               class="form-control"
                                                               v-model="add_child_job.form.quantity_factor">
                                                    </div>
                                                    <span v-show="errors.has('form.add_child_job_quantity_factory')"
                                                          class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                                </div>
                                            </div>
                                            {{--Unit--}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">หน่วย</label>
                                                    <div :class="{'input-error':errors.has('form.add_child_job_unit')}">
                                                        <input v-validate="'required'"
                                                               name="add_child_job_unit"
                                                               class="form-control"
                                                               v-model="add_child_job.form.unit">
                                                    </div>
                                                    <span v-show="errors.has('form.add_child_job_unit')"
                                                          class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Price and Wage and Quantity --}}
                                    <div v-if="add_child_job_item.form.material_item" class="row">
                                        <div class="col-xs-12">
                                            <h4 class="text-danger">** ราคาที่แสดงเป็นราคากลางจากระบบ
                                                ผู้ใช้สามารถปรับแก้ไขได้</h4>
                                            <hr>
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
                                                        v-model="add_child_job_item.form.local_price"></vue-numeric>
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
                                                        v-model="add_child_job_item.form.local_wage"></vue-numeric>
                                            </div>
                                        </div>
                                        <!-- -- Quantity and Unit -->
                                        <div class="col-xs-12 col-md-4">
                                            <div class="row">
                                                <div class="col-xs-8">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            จำนวน
                                                        </label>
                                                        <div :class="{'input-error':errors.has('form.add_child_job_item_quantity')}">
                                                            <input v-validate="'required'"
                                                                   type="number"
                                                                   name="add_child_job_item_quantity"
                                                                   class="form-control"
                                                                   v-model="add_child_job_item.form.quantity">
                                                        </div>
                                                        <span v-show="errors.has('form.add_child_job_item_quantity')"
                                                              class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            หน่วย
                                                        </label>
                                                        <div :class="{'input-error':errors.has('form.add_child_job_item_unit')}">
                                                            <input v-validate="'required'"
                                                                   type="text"
                                                                   name="add_child_job_item_unit"
                                                                   class="form-control"
                                                                   v-model="add_child_job_item.form.unit">
                                                        </div>
                                                        <span v-show="errors.has('form.add_child_job_item_unit')"
                                                              class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>

        </div>
    </div>

</modal>