@extends('admin.layouts.master')

@section('breadcrumb')
    {{Breadcrumbs::render('projectOrderCreate')}}
@endsection
@section('content')
    <div id="project-order-create" class="row" v-cloak>
        <loading :show="showLoading"></loading>
        <div class="col-xs-12">
            <!-- FORM-->
            <form
                    @submit.prevent="addNewOrder('form',$event)"
                    data-vv-scope="form"
            >
            {{csrf_field()}}
            <!-- -- Submit Button-->
                <div class="form-submit-button">
                    <button type="submit" class="btn btn-success btn-block">บันทึก</button>
                </div>
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
                                               v-model="form.project_name" type="text" id="project_name"
                                               class="form-control"
                                               placeholder="">
                                    </div>
                                    <span v-show="errors.has('form.project_name')"
                                          class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                </div>
                                <!-- -- -- Products-->
                                {{--<div class="col-md-4">--}}
                                {{--<div class="form-group">--}}
                                {{--<label for="province"--}}
                                {{--class="control-label">สินค้า</label>--}}
                                {{--<multiselect--}}
                                {{--v-model="form.product"--}}
                                {{--placeholder="" label="name" track-by="id"--}}
                                {{--:options="products" :option-height="104"--}}
                                {{--:allow-empty="false"--}}
                                {{--:show-labels="false">--}}
                                {{--<template slot="option" slot-scope="props">--}}
                                {{--<div class="option__desc">--}}
                                {{--<span class="option__title">@{{ props.option.name }}</span>--}}
                                {{--</div>--}}
                                {{--</template>--}}
                                {{--</multiselect>--}}
                                {{--<input v-validate="'required'"--}}
                                {{--v-model="form.product"--}}
                                {{--name="product" hidden>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div class="clearfix"></div>
                                {{--Clear Fix--}}
                                {{-- Form Number --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">แบบเลขที่</label>
                                        <input :class="{'input-error':errors.has('form.form_number')}"
                                               v-validate="'required'" name="form_number"
                                               v-model="form.form_number" type="text" id="form_number"
                                               class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                {{-- Form Number --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ออกเมื่อวันที่ (เช่น 01/12/61)</label>
                                        <cleave v-model="form.form_number_release" class="form-control"
                                                :raw="false"
                                                :options=" {
                                                        date: true,
                                                        datePattern: ['d', 'm', 'Y'],
                                                        delimiter: '/',
                                                    }"
                                                placeholder="ว/ด/ป">
                                        </cleave>
                                    </div>
                                </div>
                                <!-- -- -- Provinces-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province"
                                               class="control-label">จังหวัด</label>
                                        <multiselect @close="getAmphoes()"
                                                     v-model="form.province"
                                                     placeholder="" label="name" track-by="id"
                                                     :options="provinces" :option-height="104"
                                                     :allow-empty="false"
                                                     :show-labels="false">
                                            <template slot="option" slot-scope="props">
                                                <div class="option__desc">
                                                    <span class="option__title">@{{ props.option.name }}</span>
                                                </div>
                                            </template>
                                        </multiselect>
                                        <input v-validate="'required'"
                                               v-model="form.province"
                                               name="province" hidden>
                                    </div>
                                </div>
                                <!-- -- -- Amphoe-->
                                <div class="col-md-6">
                                    <div v-if="form.province" class="form-group">
                                        <label class="control-label">อำเภอ</label>
                                        <multiselect @close="getDistricts()"
                                                     v-model="form.amphoe"
                                                     placeholder="" label="name" track-by="id"
                                                     :options="amphoes"
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
                                               v-model="form.amphoe"
                                               name="amphoe" hidden>
                                    </div>
                                </div>
                                <!-- -- -- Districts-->
                                <div class="col-md-6">
                                    <div v-if="form.amphoe" class="form-group">
                                        <label class="control-label">ตำบล</label>
                                        <multiselect v-model="form.district"
                                                     placeholder=""
                                                     label="name" track-by="id"
                                                     :options="districts"
                                                     :allow-empty="false"
                                                     :option-height="104" :show-labels="false">
                                            <template slot="option" slot-scope="props">
                                                <div class="option__desc">
                                                    <span class="option__title">@{{ props.option.name }}</span>
                                                </div>
                                            </template>
                                        </multiselect>
                                        <input v-validate="'required'"
                                               v-model="form.district"
                                               name="district" hidden>
                                    </div>
                                </div>
                                {{-- -- -- Localtion--}}
                                <div class="col-md-6">
                                    <div v-if="form.district" class="form-group">
                                        <label class="control-label">รายละเอียดสถานที่เพิ่มเติม</label>
                                        <input name="location"
                                               v-model="form.location" type="text" id="location"
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
                                               v-model="form.owner_name" type="text" id="owner_name"
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
                                               v-model="form.agency_name" type="text" id="agency_name"
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
                                               v-model="form.referee_name" type="text" id="referee_name"
                                               class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">เมื่อวันที่  (เช่น 01/12/61)</label>
                                        <cleave v-model="form.referee_calculated_date" class="form-control"
                                                :raw="false"
                                                :options=" {
                                                        date: true,
                                                        datePattern: ['d', 'm', 'Y'],
                                                        delimiter: '/',
                                                    }"
                                                placeholder="ว/ด/ป">
                                        </cleave>
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
@endsection
@section('script')
    <script src="{{asset('views/admin/project_order/js/project_order_create.js')}}"></script>
@endsection