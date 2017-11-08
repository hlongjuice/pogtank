@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialItemsCreate')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <form action="#">
                <div class="tabbable tabbable-custom">
                    <!--Tabs-->
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_0" data-toggle="tab">Form Actions</a>
                        </li>
                        <li>
                            <a href="#tab_1" data-toggle="tab">2 Columns</a>
                        </li>
                    </ul>
                    <!--Tab Content-->
                    <div class="tab-content">
                        <!--Tab 1-->
                        <div class="tab-pane active" id="tab_0">
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-reorder"></i>Form Sample
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                        <a href="javascript:;" class="reload"></a>
                                        <a href="javascript:;" class="remove"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">

                                    <div class="form-horizontal">
                                        <div class="form-body">
                                            <h3 class="form-section">รายละเอียดวัสดุ/อุปกรณ์</h3>


                                            <div class="row">
                                                <!--Name-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ชื่อ</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="name"
                                                                   placeholder="Chee Kin">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Types-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">หมวดหมู่</label>
                                                        <div class="col-md-9">
                                                            <select name="type"
                                                                    class="select2_category form-control"
                                                                    data-placeholder="Choose a Category"
                                                                    tabindex="1">
                                                                <option value="Category 1">Category 1</option>
                                                                <option value="Category 2">Category 2</option>
                                                                <option value="Category 3">Category 5</option>
                                                                <option value="Category 4">Category 4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--Unit--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">หน่วย</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="unit"
                                                                   placeholder="Chee Kin">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Global Price-->
                                            <h4 class="form-section">ราคากลาง</h4>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ทุน</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                   placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Invoice Price-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ขาย</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                   placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="form-section">ราคาจากใบเสนอราคา</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ทุน</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                   placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ขาย</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                   placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END FORM-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Tab2-->
                        <div class="tab-pane" id="tab_1">
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-reorder"></i>Form Sample
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
                                    <div class="form-horizontal">
                                        <div class="form-body">
                                            <h3 class="form-section">รายการที่: </h3>
                                            <div class="row">
                                                <!--Province-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">จังหวัด</label>
                                                        <div class="col-md-9">
                                                            <select class="select2_category form-control"
                                                                    data-placeholder="Choose a Category"
                                                                    tabindex="1">
                                                                <option value="Category 1">Category 1</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Amphoe-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">อำเภอ</label>
                                                        <div class="col-md-9">
                                                            <select class="select2_category form-control"
                                                                    data-placeholder="Choose a Category"
                                                                    tabindex="1">
                                                                <option value="Category 1">Category 1</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Tambon-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ตำบล</label>
                                                        <div class="col-md-9">
                                                            <select class="select2_category form-control"
                                                                    data-placeholder="Choose a Category"
                                                                    tabindex="1">
                                                                <option value="Category 1">Category 1</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ราคาทุน</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Chee Kin">
                                                            <span class="help-block">
																This is inline help </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ราคาขาย</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control"
                                                                   placeholder="Lim">
                                                            <span class="help-block">
																This field has error. </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                        </div>
                                    </div>
                                    <!-- END FORM-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        console.log(app);
    </script>
@endsection