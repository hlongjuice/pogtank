@extends('admin.layouts.master')

@section('breadcrumb')
    {{Breadcrumbs::render('materialTypeCreate')}}
@endsection
@section('content')
    <div id="app" class="row">
        <div class="col-xs-12">
            <!-- FORM-->
            <form
                    @submit.prevent="validateForm('form',$event)"
                    data-vv-scope="form"
                    class="horizontal-form">
                {{csrf_field()}}
                <div class="portlet">
                    <!-- -- Submit Button-->
                    <div class="form-submit-button">
                        <button type="submit" class="btn btn-success btn-block">บันทึก</button>
                    </div>
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i>เพิ่มหมวดหมู่ใหม่
                        </div>
                    </div>
                    <div class="portlet-body form">

                        <div class="form-body">
                            <h3 class="form-section">ลายละเอียด</h3>
                            <div class="row">
                                <!-- -- Type Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ชื่อหมวดหมู่</label>
                                        <input :class="{'input-error':errors.has('form.typeName')}"
                                               v-validate="'required'" name="typeName"
                                               v-model="form.typeName" type="text" id="name"
                                               class="form-control"
                                               placeholder="">
                                    </div>
                                    <span v-show="errors.has('form.typeName')"
                                          class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                </div>
                                <!-- -- Parent Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ลำดับหมวดหมู่</label>
                                        <div :class="{'input-error':errors.has('form.parentTypeID')}">
                                            <multiselect
                                                    v-model="form.parentType"
                                                    placeholder="" label="name" track-by="id"
                                                    :options="parentTypes" :option-height="104"
                                                    :show-labels="false"
                                                    :allow-empty="false"
                                            >
                                                <template slot="option" slot-scope="props">
                                                    <div class="option__desc">
                                                        <span class="option__title">@{{ props.option.name }}</span>
                                                    </div>
                                                </template>
                                            </multiselect>
                                            <input v-validate="'required'"
                                                   name="parentTypeID" hidden
                                                   v-model="form.parentTypeID">
                                        </div>
                                        <span v-show="errors.has('form.parentTypeID')"
                                              class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                {{-- -- Code Prefix--}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">รหัสหมวดหมู่</label>
                                        <input
                                                v-validate="'required'"
                                                :class="{'input-error':errors.has('form.codePrefix')}"
                                                name="codePrefix" v-model="form.codePrefix"
                                                type="text" id="codePrefix"
                                                class="form-control"
                                                placeholder="">
                                    </div>
                                    <span v-show="errors.has('form.codePrefix')"
                                          class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                </div>
                                {{-- -- Details--}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">ลายละเอียดเพิ่มเติม</label>
                                        <textarea v-model="form.details" class="ckeditor form-control" id="editor1"
                                                  name="details" rows="6"></textarea>
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
    {{--Script--}}
    <script>
        var parentTypeModel = JSON.parse('{!! $parentTypes !!}');
        var indexRoute = '{!! $indexRoute !!}';
    </script>
    <script src="{{asset('views/admin/materials/types/js/type_create.js')}}"></script>
@endsection