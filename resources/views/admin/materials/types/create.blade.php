@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialTypesCreate')}}
    @endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>เพิ่มหมวดหมู่ใหม่
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="#portlet-config" data-toggle="modal" class="config"></a>
                        <a href="javascript:;" class="reload"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="horizontal-form">
                        <div class="form-body">
                            <h3 class="form-section">ลายละเอียด</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ชื่อหมวดหมู่</label>
                                        <input type="text" id="name" class="form-control" placeholder="">
                                        {{--<span class="help-block">--}}
															{{--This is inline help </span>--}}
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">ลำดับหมวดหมู่</label>
                                        <input type="text" id="lastName" class="form-control" placeholder="">
                                        {{--<span class="help-block"></span>--}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">ลายละเอียดเพิ่มเติม</label>
                                        <textarea class="ckeditor form-control" name="editor1" rows="6"></textarea>
                                    </div>
                                </div>

                                <!--/span-->
                            </div>
                        </div>
                        <div class="form-actions right">
                            <button type="button" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
@endsection