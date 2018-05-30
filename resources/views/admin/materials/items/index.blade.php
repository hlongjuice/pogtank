@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialItems')}}
@endsection
@section('content')
    <div id="material-item-index" class="row" v-cloak>
        <loading :show="is_loading"></loading>
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
                                        <div class="col-md-6 text-right">
                                            <div class="btn-group">
                                                <a @click="deleteApprovedItems"
                                                   class="btn btn-danger">
                                                    ลบหลายรายการ <i class="far fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- -- --Approved Table -->
                                <table class="table table-hover table-bordered">
                                    <!-- -- -- --Table Header -->
                                    <thead>
                                    <tr>
                                        <td class="text-center" width="5%">
                                            <input @change="selectAllApprovedItems"
                                                   type="checkbox"
                                                   v-model="chk_all_approved_items"
                                                   id="chk_all_approved_items"
                                            >
                                        </td>
                                        <td>ชื่อวัสดุ/อุปกรณ์</td>
                                        <td>หมวดหมู่</td>
                                        <td>สถาณะ</td>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <!-- -- -- --Table Body -->
                                    <tbody>
                                    <template v-for="(item,index) in approvedItems">
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox"
                                                       v-model="selected_items.approved_items"
                                                       :value="item.id"
                                                >
                                            </td>
                                            <td>
                                                {{-- -- -- -- --Edit Button--}}
                                                <a @click="openMaterialItemEdit(item.id)">
                                                    @{{item.approved_global_details.name}}
                                                </a></td>
                                            <td v-if="item.approved_global_details.type">
                                                @{{item.approved_global_details.type.name}}
                                            </td>
                                            <td class=""><p class=" text-success">@{{item.published.name}}</p>
                                            </td>
                                            <td>
                                                <a class="btn btn-info"
                                                   @click="openMaterialItemEdit(item.id)">
                                                    <span class="hidden-xs">แก้ไข</span>
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </td>
                                            {{-- -- -- -- --Delete--}}
                                            <td>
                                                <a @click="deleteSingleApprovedItem(item)" class="btn btn-danger">
                                                    <span class="hidden-xs">ลบ</span>
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </template>
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
                                <table class="table table-hover table-bordered">
                                    <!-- -- -- --Table Header -->
                                    <thead>
                                    <tr>
                                        <td class="text-center" width="5%">
                                            <input @change="selectAllWaitingItems"
                                                   type="checkbox"
                                                   v-model="chk_all_waiting_items"
                                                   id="chk_all_waiting_items"
                                            >
                                        </td>
                                        <td>ชื่อวัสดุ/อุปกรณ์</td>
                                        <td>หมวดหมู่</td>
                                        <td>สถาณะ</td>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <!-- -- -- --Table Body -->
                                    <tbody>
                                    <template v-for="(item,index) in waitingItems">
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox"
                                                       v-model="selected_items.waiting_items"
                                                       :value="item.id"
                                                >
                                            </td>
                                            <td>
                                                {{-- -- -- -- --Edit Button--}}
                                                <a @click="openMaterialItemEdit(item.id)">
                                                    @{{item.approved_global_details.name}}
                                                </a></td>
                                            <td v-if="item.approved_global_details.type">
                                                @{{item.approved_global_details.type.name}}
                                            </td>
                                            <td class=""><p class=" text-success">@{{item.published.name}}</p>
                                            </td>
                                            <td>
                                                <a class="btn btn-info"
                                                   @click="openMaterialItemEdit(item.id)">
                                                    <span class="hidden-xs">แก้ไข</span>
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </td>
                                            {{-- -- -- -- --Delete--}}
                                            <td>
                                                <a @click="deleteSingleApprovedItem(item)" class="btn btn-danger">
                                                    <span class="hidden-xs">ลบ</span>
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </template>
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
    <script src="{{asset('views/admin/materials/items/index.js')}}"></script>
@endsection