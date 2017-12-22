@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialTypeEdit',$oldType)}}
@endsection
@section('content')
    <div id="app" class="row">
        <div class="col-xs-12">
            <!-- BEGIN FORM-->
            <form @submit.prevent="validateForm('form')"
                  class="horizontal-form"
                  data-vv-scope="form"
            >
                {{ method_field('PUT') }}
                {{csrf_field()}}
                <div class="portlet">
                    <!-- -- Submit Button-->
                    <div class="form-submit-button">
                        <button type="submit" class="btn btn-success">บันทึก</button>
                    </div>
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i>แก้ไขหมวดหมู่
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
                                        <input name="name" v-model="form.name" type="text" id="name"
                                               class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                                <!-- -- Parent Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ลำดับหมวดหมู่</label>
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
                                        <input name="parentTypeID" hidden v-model="form.parentTypeID">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                {{-- -- Code Prefix --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">รหัสหมวดหมู่</label>
                                        <input name="codePrefix" v-model="form.codePrefix" type="text" id="codePrefix"
                                               class="form-control"
                                               placeholder="">
                                    </div>
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
<!-- SCRIPT -->
@section('script')
    <script>
        var oldType=JSON.parse('{!! $oldType !!}');
        var parentTypeModel=JSON.parse('{!! $parentTypes !!}');
        var indexRoute='{!! $indexRoute !!}';
    </script>
    <script src="{{asset('views/admin/materials/types/js/type_edit.js')}}"></script>
@endsection