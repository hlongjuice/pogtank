<modal
        name="porlor-4-edit-child-job-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenEditChildJobModal($event)"
        @opened="openedEditChildJobModal"
        @before-close="beforeCloseEditChildJobModal"
        width="90%"
        height="auto"
        :scrollable="true"
>
    <loading :show='edit_child_job.showLoading'></loading>
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
                            <h4>แก้ไขกลุ่มงาน</h4>
                        </div>
                        <button type="button" class="btn btn-danger" @click="closeEditChildJobModal">Close</button>
                        <button type="submit" class="col-xs-3 pull-right btn btn-success margin-bottom-20">
                            บันทึก
                        </button>
                    </div>
                    <div class="panel-body">
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-reorder"></i>งาน
                                </div>
                            </div>
                            <div class="portlet-body form">

                                <div class="form-body">
                                    {{--Level--}}
                                    <div class="row">
                                        {{-- ***Hidden Page Number--}}
                                        <div class="hidden col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    แบบ ปร.4 แผ่นที่
                                                    {{--<span class="small text-secondary">(เช่น 1)</span>--}}
                                                </label>
                                                <div :class="{'input-error':errors.has('form.edit_child_job_page_number')}">
                                                    <input v-validate="'required'"
                                                           type="text"
                                                           name="edit_child_job_page_number"
                                                           class="form-control"
                                                           v-model="edit_child_job.form.page_number">
                                                </div>
                                                <span v-show="errors.has('form.edit_child_job_page_number')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                        {{-- -- Job Level--}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">กลุ่มรายการ</label>
                                                <div :class="{'input-error':errors.has('form.edit_child_job_parent')}">
                                                    <multiselect
                                                            v-model="edit_child_job.form.parent"
                                                            placeholder="" label="name" track-by="id"
                                                            :options="edit_child_job.parents" :option-height="104"
                                                            :show-labels="false"
                                                            :allow-empty="false"
                                                            :max-height="180"
                                                            :custom-label="editChildJob_childJobCustomLabel"
                                                    >
                                                        <template slot="option" slot-scope="props">
                                                            <div class="option__desc">
                                                                <span class="option__title">@{{ props.option.job_order_number }} @{{ props.option.name }}</span>
                                                            </div>
                                                        </template>
                                                    </multiselect>
                                                    <input v-validate="'required'"
                                                           name="edit_child_job_parent" hidden
                                                           v-model="edit_child_job.form.parent">
                                                </div>
                                                <span v-show="errors.has('form.edit_child_job_parent')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                        <!-- -- Job Name -->
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="control-label">ชื่องาน</label>
                                                <div :class="{'input-error':errors.has('form.edit_child_job_name')}">
                                                    <input v-validate="'required'"
                                                           name="edit_child_job_name"
                                                           class="form-control"
                                                           v-model="edit_child_job.form.name">
                                                </div>
                                                <span v-show="errors.has('form.edit_child_job_name')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                    </div>
                                    {{--Checker Quantity Factor and Unit--}}
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>
                                                <input v-model="edit_child_job.form.group_item_per_unit" type="checkbox">
                                                * กลุ่มงานระบุรายการวัสดุแยกต่อ 1 หน่วย
                                            </label>
                                        </div>
                                        {{--Quantity Factor--}}
                                        <div class="col-md-offset-1 col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">จำนวนทั้งหมด</label>
                                                <div :class="{'input-error':errors.has('form.edit_child_job_quantity_factory')}">
                                                    <input :disabled="!edit_child_job.form.group_item_per_unit"
                                                           v-validate="'required'"
                                                           name="edit_child_job_quantity_factor"
                                                           class="form-control"
                                                           v-model="edit_child_job.form.quantity_factor">
                                                </div>
                                                <span v-show="errors.has('form.edit_child_job_quantity_factory')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                        {{--Unit--}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">หน่วย</label>
                                                <div :class="{'input-error':errors.has('form.edit_child_job_unit')}">
                                                    <input :disabled="!edit_child_job.form.group_item_per_unit"
                                                           v-validate="'required'"
                                                           name="edit_child_job_unit"
                                                           class="form-control"
                                                           v-model="edit_child_job.form.unit">
                                                </div>
                                                <span v-show="errors.has('form.edit_child_job_unit')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
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