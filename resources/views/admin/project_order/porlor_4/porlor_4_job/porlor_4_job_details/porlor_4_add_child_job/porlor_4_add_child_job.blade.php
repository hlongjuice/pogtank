<modal
        name="porlor-4-add-child-job-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenAddChildJobModal($event)"
        @opened="openedAddChildJobModal"
        @before-close="beforeCloseAddChildJobModal"
        width="90%"
        height="auto"
        :scrollable="true"
>
    <loading :show='add_child_job.is_loading'></loading>
    <div class="row">
        <!-- FORM-->
        <form
                @submit.prevent="addChildJob('form',$event)"
                data-vv-scope="form"
                class="horizontal-form">
            {{csrf_field()}}
            <div class="col-xs-12">
                <div class="panel panel-default">
                    {{-- Close Button--}}
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            <h4>เพิ่มกลุ่มงาน</h4>
                        </div>
                        <button type="button" class="btn btn-danger" @click="closeAddChildJobModal">Close</button>
                        <button type="submit" class="col-xs-3 pull-right btn btn-success margin-bottom-20">
                            บันทึก
                        </button>
                    </div>
                    <div class="panel-body">
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-reorder"></i>แบบ ปร.4 แผ่นที่ @{{ add_child_job.form.page_number
                                    }}/@{{ add_child_job.total_page_number }}
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">
                                    {{--Level--}}
                                    <div class="row">
                                        {{-- -- Job Level--}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">กลุ่มรายการ
                                                    <span class="small text-secondary">("รายการหลัก" คือรายการที่มีลำดับเป็น 1,2,3,4,...)</span>
                                                </label>
                                                <div :class="{'input-error':errors.has('form.add_child_job_parent')}">
                                                    <multiselect
                                                            v-model="add_child_job.form.parent"
                                                            placeholder="" label="name" track-by="id"
                                                            :options="add_child_job.parents" :option-height="104"
                                                            :show-labels="false"
                                                            :allow-empty="false"
                                                            :max-height="150"
                                                            :custom-label="addChildJob_childJobCustomLabel"
                                                    >
                                                        <template slot="option" slot-scope="props">
                                                            <div class="option__desc">
                                                                <span class="option__title">@{{ props.option.job_order_number }} @{{ props.option.name }}</span>
                                                            </div>
                                                        </template>
                                                    </multiselect>
                                                    <input v-validate="'required'"
                                                           name="add_child_job_parent" hidden
                                                           v-model="add_child_job.form.parent">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_parent')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                        <!-- -- Job Name -->
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="control-label">ชื่องาน</label>
                                                <div :class="{'input-error':errors.has('form.add_child_job_name')}">
                                                    <input v-validate="'required'"
                                                           name="add_child_job_name"
                                                           class="form-control"
                                                           v-model="add_child_job.form.name">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_name')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                    </div>
                                    {{--Order Number and Job Name--}}
                                    <div class="row">
                                    </div>
                                    {{--Checker Quantity Factor and Unit--}}
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>
                                                <input v-model="add_child_job.form.group_item_per_unit" type="checkbox">
                                                * กลุ่มงานระบุรายการวัสดุแยกต่อ 1 หน่วย
                                            </label>
                                        </div>
                                        {{--Quantity Factor--}}
                                        <div class="col-md-offset-1 col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">จำนวนทั้งหมด</label>
                                                <div :class="{'input-error':errors.has('form.add_child_job_quantity_factory')}">
                                                    <input :disabled="!add_child_job.form.group_item_per_unit"
                                                           v-validate="'required'"
                                                           name="add_child_job_quantity_factor"
                                                           class="form-control"
                                                           v-model="add_child_job.form.quantity_factor">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_quantity_factory')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                        {{--Unit--}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">หน่วย</label>
                                                <div :class="{'input-error':errors.has('form.add_child_job_unit')}">
                                                    <input :disabled="!add_child_job.form.group_item_per_unit"
                                                           v-validate="'required'"
                                                           name="add_child_job_unit"
                                                           class="form-control"
                                                           v-model="add_child_job.form.unit">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_unit')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                    </div>
                                    {{--Job Details--}}
                                    <div class="row">
                                        <div class="col-xs-12">
                                            {{--<p class="text-danger">* เลือกกลุ่มงานระบุรายการวัสดุ แยกต่อ 1 หน่วย </p>--}}
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
</modal>