@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('porlor4',$order)}}
@endsection

@section('content')
    <div id="porlor-4-index" class="row" v-cloak>
        <loading :show="showLoading"></loading>
        @include('admin.project_order.porlor_4.add_part_modal')
        @include('admin.project_order.porlor_4.edit_part_modal')
        <div class="col-md-12">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-edit"></i>โครงการ @{{ project_details.project_name }}
                    </div>
                </div>
                <div class="portlet-body">
                    {{--Order Details--}}
                    <div class="row">
                        <div class="col-md-10">
                            {{--Address--}}
                            <div class="row">
                                <div v-if="project_details.province" class="col-md-12">
                                    <p>สถานที่ก่อสร้าง : @{{ project_details.location }}
                                        @{{project_details.district.name}}
                                        @{{ project_details.amphoe.name }}
                                        @{{ project_details.province.name }}
                                    </p>
                                </div>
                            </div>
                            {{--Form Number and Form Number Release--}}
                            <div class="row">
                                <div class="col-md-6">
                                    <p>แบบเลขที่ : @{{ project_details.form_number }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>ออกเมื่อวันที่ : @{{ project_details.form_number_release }}</p>
                                </div>
                            </div>
                            {{--Owner and Agency--}}
                            <div class="row">
                                <div class="col-md-6">
                                    <p>หน่วยงานเจ้าของโครงการ :@{{ project_details.owner_name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>หน่วยงานประมาณการ : @{{ project_details.agency_name }}</p>
                                </div>
                            </div>
                            {{--Referee and Upadted at--}}
                            <div class="row">
                                <div class="col-md-6">
                                    <p>คำนวนราคากลางโดย : @{{ project_details.referee_name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>เมื่อวันที่ : @{{ project_details.referee_calculated_date }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-edit"></i>ส่วนงานปร.4
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
                                    <a @click="showAddNewPartModal" class="btn btn-success">
                                        เพิ่มส่วนใหม่ <i class="fa fa-plus"></i>
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
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            {{-- -- Table Header--}}
                            <thead>
                            <tr class="table-row-th-center">
                                {{--<th>ID</th>--}}
                                <th width="60%">ส่วนงาน</th>
                                <th>รายละเอียด</th>
                                <th>แก้ไข</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            {{-- -- Table Content--}}
                            <tbody>
                                <tr class="text-center" v-for="(item,index) in project_porlor_4_parts">
                                    <td class="text-left">@{{ index+1 }}. @{{ item.part.name }}</td>
                                    <td>
                                        <a class="btn btn-primary" @click="openPorlor4JobsPage(item.id)">รายละเอียด</a>
                                        {{--Excel--}}
                                        <a @click="porlor4_exportExcelByPartID(item.id)" class="margin-left-5 btn btn-default">
                                            Excel
                                            <i class="far fa-download"></i>
                                        </a>
                                    </td>
                                    <td><a class="btn btn-warning" @click="openEditPartModal(item)">แก้ไข</a> </td>
                                    <td><a class="btn btn-danger" @click="porlor4_deletePart(item)">ลบ</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Types Table-->
        </div>
    </div>
@endsection
@section('script')
    <script>
        var orderID='{!!$order->id!!}';
    </script>
    <script src="{{asset('views/admin/project_order/porlor_4/js/porlor_4_index.js')}}"></script>
@endsection