@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('projectOrder')}}
@endsection

@section('content')
    <div id="project-order-index" class="row" v-cloak>
        <loading :show="showLoading"></loading>
        @include('admin.project_order.project_order_edit')
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-edit"></i>รายการสั่งซื้อ
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
                                    <a href="{{route('admin.project_order.create')}}" class="btn btn-success">
                                        สร้างรายการใหม่ <i class="fa fa-plus"></i>
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
                    <table class="table table-striped table-hover table-bordered">
                        {{-- -- Table Header--}}
                        <thead>
                        <tr>
                            {{--<th>ID</th>--}}
                            <th>โครงการ</th>
                            <th>ปร.4</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        {{-- -- Table Content--}}
                        <tbody>
                        <tr v-for="order in orders.data">
                            {{--<td></td>--}}
                            <td>@{{ order.project_name }}</td>
                            <td><a @click="openPorlor4Page(order)" class="btn btn-info">ปร.4</a></td>
                            <td><a class="btn btn-warning" @click="openProjectOrderEditModal(order)">แก้ไข</a></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <pagination :data="orders"
                                v-on:pagination-change-page="getSelectedProductPage"></pagination>
                </div>
            </div>
            <!-- END Types Table-->
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('views/admin/project_order/js/project_order_index.js')}}"></script>
@endsection