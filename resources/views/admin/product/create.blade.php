@extends('admin.layouts.master')

@section('breadcrumb')
    {{Breadcrumbs::render('productCreate')}}
@endsection
@section('content')
    <div id="product-create" class="row">
        <div class="col-xs-12">
            <!-- FORM-->
            <form
                    @submit.prevent="addNewProduct('form',$event)"
                    data-vv-scope="form"
                    class="horizontal-form">
            {{csrf_field()}}
            <!-- -- Submit Button-->
                <div class="form-submit-button">
                    <button type="submit" class="btn btn-success btn-block">บันทึก</button>
                </div>
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i>เพิ่มสินค้า
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body">
                            <h3 class="form-section">รายละเอียด</h3>
                            <div class="row">
                                <!-- -- Type Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ชื่อสินค้า</label>
                                        <input :class="{'input-error':errors.has('form.name')}"
                                               v-validate="'required'" name="name"
                                               v-model="form.name" type="text" id="name"
                                               class="form-control"
                                               placeholder="">
                                    </div>
                                    <span v-show="errors.has('form.name')"
                                          class="text-error text-danger">กรุณากรอกข้อมูล</span>
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
    <script src="{{asset('views/admin/product/js/product_create.js')}}"></script>
@endsection