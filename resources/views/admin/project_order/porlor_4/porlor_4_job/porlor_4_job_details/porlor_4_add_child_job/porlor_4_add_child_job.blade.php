<modal
        name="porlor-4-add-child-job-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenAddChildJobModal($event)"
        {{--@before-close="beforeCloseAddRootJobModal"--}}
        width="90%"
        height="90%"
        :scrollable="true"
>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                {{-- Close Button--}}
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closeAddChildJobModal">Close</button>
                </div>
                <div class="panel-body">
                    <!-- FORM-->
                    <form
                            @submit.prevent="addChildJob('form',$event)"
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
                                    <i class="fa fa-reorder"></i>งาน
                                </div>
                            </div>
                            <div class="portlet-body form">

                                <div class="form-body">
                                    {{--Level--}}
                                    <div class="row">
                                        {{--Page Number--}}
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    แบบ ปร.4 แผ่นที่
                                                    {{--<span class="small text-secondary">(เช่น 1)</span>--}}
                                                </label>
                                                <div :class="{'input-error':errors.has('form.add_child_job_page_number')}">
                                                    <input v-validate="'required'"
                                                           type="text"
                                                           name="add_child_job_page_number"
                                                           class="form-control"
                                                           v-model="add_child_job.form.page_number">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_page_number')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                        {{-- -- Job Level--}}
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="control-label">กลุ่มรายการ</label>
                                                <div :class="{'input-error':errors.has('form.part')}">
                                                    <multiselect
                                                            v-model="add_child_job.form.parent"
                                                            placeholder="" label="name" track-by="id"
                                                            :options="add_child_job.parents" :option-height="104"
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
                                                    </multiselect>
                                                    <input v-validate="'required'"
                                                           name="add_child_job_parent" hidden
                                                           v-model="add_child_job.form.parent">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_parent')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                    </div>
                                    {{--Order Number and Job Name--}}
                                    <div class="row">
                                        <!-- -- Order Number -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    ลำดับที่
                                                    <span class="small text-secondary">(เช่น 1,1.1,1.2)</span>
                                                </label>
                                                <div :class="{'input-error':errors.has('form.add_child_job_order_number')}">
                                                    <input v-validate="'required'"
                                                           type="text"
                                                           name="add_child_job_order_number"
                                                           class="form-control"
                                                           v-model="add_child_job.form.job_order_number">
                                                </div>
                                                <span v-show="errors.has('form.add_child_job_order_number')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                        <!-- -- Job Name -->
                                        <div class="col-md-9">
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
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
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
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                    </div>
                                    {{--Job Details--}}
                                    <div class="row">

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