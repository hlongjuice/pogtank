@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('projectOrder')}}
@endsection

@section('content')
    <div id="project-order-index" class="row" v-cloak>
        <loading :show="showLoading"></loading>
        @include('admin.project_order.project_order_edit')
        {{--Porlor5--}}
        @include('admin.project_order.porlor_5.porlor_5_index')
        {{--Porlor6--}}
        @include('admin.project_order.porlor_6.porlor_6_index')
        {{--Referee--}}
        @include('admin.project_order.referee.referee_index')
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
                        </div>
                    </div>
                    <div class="table-responsive">
                        {{-- Types Table--}}
                        <table class="table table-striped table-hover table-bordered">
                            {{-- -- Table Header--}}
                            <thead>
                            <tr class="table-row-th-center">
                                {{--<th>ID</th>--}}
                                <th>โครงการ</th>
                                <th>คณะกรรมการ</th>
                                <th>ปร.4</th>
                                <th>ปร.5</th>
                                <th>ปร.6</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            {{-- -- Table Content--}}
                            <tbody>
                            <tr class="text-center" v-for="order in orders.data">
                                {{--Project Name--}}
                                <td class="text-left">@{{ order.project_name }}</td>
                                {{--Referee--}}
                                <td><a @click="openProjectReferee(order)" class="btn btn-info">คณะกรรมการ</a></td>
                                {{--Porlor 4--}}
                                <td>
                                    <a @click="openPorlor4Page(order)" class="btn btn-info">ปร.4</a>
                                    <a @click="exportPorlor4Excel(order.id)" class="margin-left-5 btn btn-default">
                                        Excel
                                        <i class="far fa-download"></i>
                                    </a>
                                </td>
                                {{--Porlor 5--}}
                                <td>
                                    <a @click="openPorlor5Modal(order)" class="btn btn-info">ปร.5</a>
                                    <a @click="exportPorlor5Excel(order.id)" class="margin-left-5 btn btn-default">
                                        Excel
                                        <i class="far fa-download"></i>
                                    </a>
                                </td>
                                {{--Porlor 6--}}
                                <td>
                                    <a @click="openPorlor6Modal(order)" class="btn btn-info">ปร.6</a>
                                    <a @click="exportPorlor6Excel(order.id)" class="margin-left-5 btn btn-default">
                                        Excel
                                        <i class="far fa-download"></i>
                                    </a>
                                </td>
                                {{--Edit--}}
                                <td><a class="btn btn-warning" @click="openProjectOrderEditModal(order)">แก้ไข</a></td>
                                {{--Delete--}}
                                <td><a class="btn btn-danger" @click="deleteProject(order)">ลบ</a></td>
                            </tr>
                            </tbody>
                        </table>
                        <pagination :data="orders"
                                    v-on:pagination-change-page="getSelectedProductPage"></pagination>
                    </div>
                </div>
            </div>
            <!-- END Types Table-->
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('views/admin/project_order/js/project_order_index.js')}}"></script>
@endsection