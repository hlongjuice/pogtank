
<modal
        name="project-order-edit-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenProjectOrderEditModal($event)"
        @opened="openedProjectOrderEditModal"
        @before-close="beforeCloseProjectOrderEditModal"
        width="90%"
        height="auto"
        :scrollable="true"
>
    <div style="overflow: auto;" class="row">
        <div class="col-xs-12">
            <!-- FORM-->
            <form
                    @submit.prevent="projectOrderEditModal_updateDetails('form',$event)"
                    data-vv-scope="form"
            >
                {{csrf_field()}}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title text-center">
                        <h4>แก้ไข</h4>
                    </div>
                    <button type="button" class="btn btn-danger" @click="closeProjectOrderEditModal">Close
                    </button>
                    <button type="submit" class="col-md-3 pull-right btn btn-success">
                        บันทึก
                    </button>
                </div>
                <div class="panel-body">
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-reorder"></i>แบบฟอร์มใหม่
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">
                                    <h3 class="form-section">รายละเอียด</h3>
                                    <div class="row">
                                        <!-- -- Project Name -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">ชื่อโครงการ</label>
                                                <input :class="{'input-error':errors.has('form.project_name')}"
                                                       v-validate="'required'" name="project_name"
                                                       v-model="project_order_edit.form.project_name" type="text" id="project_name"
                                                       class="form-control"
                                                       placeholder="">
                                            </div>
                                            <span v-show="errors.has('form.project_name')"
                                                  class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                        </div>

                                        <div class="clearfix"></div>
                                        {{--Clear Fix--}}
                                        {{-- Form Number --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">แบบเลขที่</label>
                                                <input :class="{'input-error':errors.has('form.form_number')}"
                                                       v-validate="'required'" name="form_number"
                                                       v-model="project_order_edit.form.form_number" type="text" id="form_number"
                                                       class="form-control"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        {{-- Form Number --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">ออกเมื่อวันที่</label>
                                                <datepicker language="th" v-model="project_order_edit.form.form_number_release"
                                                            :input-class="{'form-control':true,'input-error':errors.has('form.form_number_release')}">
                                                </datepicker>
                                            </div>
                                        </div>
                                        <!-- -- -- Provinces-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="province"
                                                       class="control-label">จังหวัด</label>
                                                <multiselect @close="getAmphoes()"
                                                             @input="getAmphoes"
                                                             v-model="project_order_edit.form.province"
                                                             placeholder="" label="name" track-by="id"
                                                             :options="project_order_edit.provinces" :option-height="104"
                                                             :allow-empty="false"
                                                             :show-labels="false">
                                                    <template slot="option" slot-scope="props">
                                                        <div class="option__desc">
                                                            <span class="option__title">@{{ props.option.name }}</span>
                                                        </div>
                                                    </template>
                                                </multiselect>
                                                <input v-validate="'required'"
                                                       v-model="project_order_edit.form.province"
                                                       name="province" hidden>
                                            </div>
                                        </div>
                                        <!-- -- -- Amphoe-->
                                        <div class="col-md-6">
                                            <div v-if="project_order_edit.form.province" class="form-group">
                                                <label class="control-label">อำเภอ</label>
                                                <multiselect @close="getDistricts()"
                                                             @input="getDistricts"
                                                             v-model="project_order_edit.form.amphoe"
                                                             placeholder="" label="name" track-by="id"
                                                             :options="project_order_edit.amphoes"
                                                             :option-height="104"
                                                             :allow-empty="false"
                                                             :show-labels="false">
                                                    <template slot="option" slot-scope="props">
                                                        <div class="option__desc">
                                                            <span class="option__title">@{{ props.option.name }}</span>
                                                        </div>
                                                    </template>
                                                </multiselect>
                                                <input v-validate="'required'"
                                                       v-model="project_order_edit.form.amphoe"
                                                       name="amphoe" hidden>
                                            </div>
                                        </div>
                                        <!-- -- -- Districts-->
                                        <div class="col-md-6">
                                            <div v-if="project_order_edit.form.amphoe" class="form-group">
                                                <label class="control-label">ตำบล</label>
                                                <multiselect v-model="project_order_edit.form.district"
                                                             placeholder=""
                                                             label="name" track-by="id"
                                                             :options="project_order_edit.districts"
                                                             :allow-empty="false"
                                                             :option-height="104" :show-labels="false">
                                                    <template slot="option" slot-scope="props">
                                                        <div class="option__desc">
                                                            <span class="option__title">@{{ props.option.name }}</span>
                                                        </div>
                                                    </template>
                                                </multiselect>
                                                <input v-validate="'required'"
                                                       v-model="project_order_edit.form.district"
                                                       name="district" hidden>
                                            </div>
                                        </div>
                                        {{-- -- -- Localtion--}}
                                        <div class="col-md-6">
                                            <div v-if="project_order_edit.form.district" class="form-group">
                                                <label class="control-label">รายละเอียดสถานที่เพิ่มเติม</label>
                                                <input name="location"
                                                       v-model="project_order_edit.form.location" type="text" id="location"
                                                       class="form-control"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        {{--Clear Fix--}}
                                        {{-- Owner Name--}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">หน่วยงานเจ้าของโครงการ</label>
                                                <input :class="{'input-error':errors.has('form.owner_name')}"
                                                       v-validate="'required'" name="owner_name"
                                                       v-model="project_order_edit.form.owner_name" type="text" id="owner_name"
                                                       class="form-control"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        {{-- Agency Name--}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">หน่วยงานประมาณการ</label>
                                                <input :class="{'input-error':errors.has('form.agency_name')}"
                                                       v-validate="'required'" name="agency_name"
                                                       v-model="project_order_edit.form.agency_name" type="text" id="agency_name"
                                                       class="form-control"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        {{-- Referee Name--}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">คำนวนราคากลางโดย</label>
                                                <input :class="{'input-error':errors.has('form.referee_name')}"
                                                       v-validate="'required'" name="referee_name"
                                                       v-model="project_order_edit.form.referee_name" type="text" id="referee_name"
                                                       class="form-control"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        {{--  Referee Approved Date --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">เมื่อวันที่</label>
                                                <datepicker language="th" v-model="project_order_edit.form.referee_calculated_date"
                                                            :input-class="{'form-control':true,'input-error':errors.has('form.referee_calculated_date')}">
                                                </datepicker>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <!-- END FORM-->
                </div>
            </div>
            </form>
        </div>
    </div>
</modal>
