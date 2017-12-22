@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialItems')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
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
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <!-- Add New Item -->
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{route('admin.materials.items.create')}}" class="btn btn-success">
                                         เพิ่มวัสดุ / อุปกรณ์ <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group pull-right">
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i
                                                class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="#">
                                                Print </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Save as PDF </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Export to Excel </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                    <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                        <!-- -- Table Header -->
                        <thead>
                        <tr>
                            <td>ชื่อวัสดุ/อุปกรณ์</td>
                            <td>หมวดหมู่</td>
                            <td>สถาณะ</td>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <!-- -- Table Body -->
                        <tbody>
                        @foreach($materials as $material)
                            <tr>
                                <td>{{$material->name}}</td>
                                <td>{{$material->type ? $material->type->name:''}}</td>
                                <td class=""><p class=" text-success">{{$material->published->name}}</p></td>
                                <td>
                                    <a class="btn btn-info" href="{{route('admin.materials.items.edit',$material->id)}}">Edit </a>
                                </td>
                                <td>
                                    <form onsubmit="return confirm('ยืนยันการลบ')" method="POST" action="{{route('admin.materials.items.destroy',$material->id)}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger" type="submit">
                                            Delete </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection
@section('script')
    <script>
        var submitted='{!! $submitted !!}';
        $('#sample_editable_1').dataTable();
        if(submitted=='added'){
            toastr.success('การบันทึกเสร็จสมบูรณ์')
        }else if(submitted=='updated'){
            toastr.success('การแก้ไข้เสร็จสมบูรณ์')
        }else if(submitted=='deleted'){
            toastr.success('การลบเสร็จสมบูรณ์')
        }
    </script>
@endsection