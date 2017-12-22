@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialTypes')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-edit"></i>Editable Table
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
                            {{-- Add New Type--}}
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{route('admin.materials.types.create')}}" class="btn btn-success">
                                        เพิ่มหมวดหมู่ <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group pull-right">
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i
                                                class="fa fa-angle-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Types Table--}}
                    <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                        {{-- -- Table Header--}}
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>
                                หมวดหมู่
                            </th>
                            <th>
                                Edit
                            </th>
                            <th>
                                Delete
                            </th>
                        </tr>
                        </thead>
                        {{-- -- Table Content--}}
                        <tbody>
                        {{-- -- -- Types--}}
                        {{-- -- --  --Type Lv 1--}}
                        @foreach($types as $type_lv1)
                            <tr >
                                <td>{{$type_lv1->id}}</td>
                                <td>
                                    {{$type_lv1->name}}
                                </td>
                                <td>
                                    <a class="btn btn-info" href="{{route('admin.materials.types.edit',$type_lv1->id)}}">Edit </a>
                                </td>
                                <td>
                                    <form method="POST" action="{{route('admin.materials.types.destroy',$type_lv1->id)}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button onclick="return confirm('ต้องการที่จะลบ')" class="btn btn-danger" type="submit">
                                            Delete </button>
                                    </form>
                                </td>
                            </tr>
                            {{-- -- -- --  -- Type Lv 2--}}
                            @if($type_lv1->children->count()>0)
                                @foreach($type_lv1->children as $type_lv2)
                                    <tr>
                                        <td>{{$type_lv2->id}}</td>
                                        <td>
                                            -- {{$type_lv2->name}}
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="{{route('admin.materials.types.edit',$type_lv2->id)}}">Edit</a>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{route('admin.materials.types.destroy',$type_lv2->id)}}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button onclick="return confirm('ต้องการที่จะลบ')" class="btn btn-danger" type="submit">
                                                    Delete </button>
                                            </form>
                                        </td>
                                    </tr>
                                    {{-- -- -- -- -- -- Type Lv 3--}}
                                    @if($type_lv2->children->count()>0)
                                        @foreach($type_lv2->children as $type_lv3)
                                            <tr>
                                                <td>{{$type_lv3->id}}</td>
                                                <td>
                                                    -- -- {{$type_lv3->name}}
                                                </td>
                                                <td>
                                                    <a class="btn btn-info" href="{{route('admin.materials.types.edit',$type_lv3->id)}}">Edit </a>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{route('admin.materials.types.destroy',$type_lv3->id)}}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button onclick="return confirm('ต้องการที่จะลบ')" class="btn btn-danger" type="submit">
                                                            Delete </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                @endforeach
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Types Table-->
        </div>
    </div>
@endsection
@section('script')
    <script>
        var submitted='{!! $submitted !!}';
        $('#sample_editable_1').dataTable({
            ordering: false
        });
        if(submitted>0){
            toastr.success('บันทึกเสร็จสมบูรณ์');
        }
    </script>
@endsection