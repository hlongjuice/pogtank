@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialItems')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tabbable tabbable-custom">
                {{--Tabs Header--}}
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#items" data-toggle="tab">รายการอุปกรณ์</a>
                    </li>
                    <!-- -- Tab New Requested-->
                    <li>
                        <a href="#requested-items" data-toggle="tab">
                            รายการใหม่รออนุมัติ
                            <span class="badge badge-danger badge-notify">{{$waitingMaterials->count()}} รายการ</span>
                        </a>
                    </li>
                </ul>
                {{--Tab Contents--}}
                <div class="tab-content">
                    {{-- --Approved Items--}}
                    <div class="tab-pane active" id="items">
                        <div class="portlet">
                            {{-- -- --Title--}}
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-edit"></i>วัสดุ/อุปกรณ์
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                    <a href="#portlet-config" data-toggle="modal" class="config">
                                    </a>
                                    <a href="javascript:;" class="reload">
                                    </a>
                                    <a href="javascript:;" class="remove">
                                    </a>
                                </div>
                            </div>
                            {{-- -- --Body--}}
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <!-- Add New Item -->
                                        <div class="col-md-6">
                                            <div class="btn-group">
                                                <a href="{{route('admin.materials.items.create')}}"
                                                   class="btn btn-success">
                                                    เพิ่มวัสดุ / อุปกรณ์ <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- -- --Approved Table -->
                                <table class="table table-striped table-hover table-bordered" id="approved_table">
                                    <!-- -- -- --Table Header -->
                                    <thead>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>ชื่อวัสดุ/อุปกรณ์</td>
                                        <td>หมวดหมู่</td>
                                        <td>สถาณะ</td>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <!-- -- -- --Table Body -->
                                    <tbody>
                                    @foreach($approvedMaterials as $material)
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>
                                                {{-- -- -- -- --Edit Button--}}
                                                <a href="{{route('admin.materials.items.edit',$material->id)}}">
                                                    {{$material->approvedGlobalDetails->name}}
                                                </a></td>
                                            <td>{{$material->approvedGlobalDetails->type ? $material->approvedGlobalDetails->type->name:''}}</td>
                                            <td class=""><p class=" text-success">{{$material->published->name}}</p>
                                            </td>
                                            <td>
                                                <a class="btn btn-info"
                                                   href="{{route('admin.materials.items.edit',$material->id)}}">
                                                    <i class="far fa-edit"></i>
                                                    <span class="hidden-xs">Edit</span>
                                                </a>
                                            </td>
                                            {{-- -- -- -- --Delete--}}
                                            <td>
                                                <form onsubmit="return confirm('ยืนยันการลบ')" method="POST"
                                                      action="{{route('admin.materials.items.destroy',$material->id)}}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button class="btn btn-danger" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                        <span class="hidden-xs">Delete</span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- --Waiting Items--}}
                    <div class="tab-pane" id="requested-items">
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-edit"></i>รายการแก้ไขล่าสุด
                                </div>
                                <div class="tools">
                                    {{--<a><i href="javascript:;" class="collapse far fa-angle-down fa-lg"></i></a>--}}
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                    </div>
                                </div>
                                <!-- --  Waiting Materials Table -->
                                <table class="table table-hover table-bordered" id="sample_editable_1">
                                    <!-- -- -- Table Header -->
                                    <thead>
                                    <tr>
                                        <td>ชื่อวัสดุ/อุปกรณ์</td>
                                        <td>หมวดหมู่</td>
                                        <th>รายละเอียด</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <!-- -- -- Table Body -->
                                    <tbody>
                                    {{--{{dd($waitingMaterials)}}--}}
                                    @foreach($waitingMaterials as $waitingMaterial)
                                        @if($waitingMaterial->approvedGlobalDetails)
                                            <tr>
                                                <td>
                                                    {{-- -- -- -- --Edit Button--}}
                                                    <a href="{{route('admin.materials.items.edit',$waitingMaterial->id)}}">
                                                        {{$waitingMaterial->approvedGlobalDetails->name}}
                                                    </a>
                                                </td>
                                                <td>{{$waitingMaterial->approvedGlobalDetails->type ? $waitingMaterial->approvedGlobalDetails->type->name:''}}</td>
                                                <td>
                                                    <a class="btn btn-primary"
                                                       href="{{route('admin.materials.items.edit',$waitingMaterial->id)}}">
                                                        <i class="fal fa-file-alt"></i>
                                                        <span class="hidden-xs">ดูรายละเอียด</span>
                                                    </a>
                                                </td>
                                                {{-- -- -- -- --Delete--}}
                                                <td>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    {{-- -- -- -- --Edit Button--}}
                                                    <a href="{{route('admin.materials.items.edit',$waitingMaterial->id)}}">
                                                        {{$waitingMaterial->waitingGlobalDetails->name}}
                                                    </a>
                                                </td>
                                                <td>{{$waitingMaterial->waitingGlobalDetails->type ? $waitingMaterial->waitingGlobalDetails->type->name:''}}</td>
                                                <td>
                                                    <a class="btn btn-primary"
                                                       href="{{route('admin.materials.items.edit',$waitingMaterial->id)}}">
                                                        <i class="fal fa-file-alt"></i>
                                                        <span class="hidden-xs">ดูรายละเอียด</span>
                                                    </a>
                                                </td>
                                                {{-- -- -- -- --Delete--}}
                                                <td>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var submitted = '{!! $submitted !!}';
        $('#sample_editable_1').dataTable();
        $('#approved_table').dataTable();
        if (submitted == 'added') {
            toastr.success('การบันทึกเสร็จสมบูรณ์')
        } else if (submitted == 'updated') {
            toastr.success('การแก้ไข้เสร็จสมบูรณ์')
        } else if (submitted == 'deleted') {
            toastr.success('การลบเสร็จสมบูรณ์')
        }
    </script>
@endsection