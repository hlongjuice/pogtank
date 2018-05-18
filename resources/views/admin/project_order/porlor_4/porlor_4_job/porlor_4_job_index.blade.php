@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('porlor4Job',$porlor4)}}
@endsection

@section('content')
    <div id="porlor-4-job-index" class="row" v-cloak>
        <loading :show="showLoading"></loading>
        {{-- Add Root Job Modal--}}
        @include('admin.project_order.porlor_4.porlor_4_job.porlor_4_job_add_root.porlor_4_job_add_root')
        {{--Show Job Details Modal--}}
        @include('admin.project_order.porlor_4.porlor_4_job.porlor_4_job_details.porlor_4_job_details')
        {{--Edit Root Job Modal--}}
        @include('admin.project_order.porlor_4.porlor_4_job.porlor_4_job_edit_root_job.porlor_4_job_edit_root_job')
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-edit"></i>ส่วนที่ @{{ partDetails.position }} : @{{ partDetails.name }}
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
                            {{-- Add New Button--}}
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a @click="showAddRootJobModal" class="btn btn-success">
                                        เพิ่มงานใหม่ <i class="fa fa-plus"></i>
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
                            <tr>
                                {{--<th>ID</th>--}}
                                <th>งาน</th>
                                <th>
                                    <i class="fal fa-file-alt"></i>
                                    <span class="hidden-xs"> รายละเอียด</span>
                                </th>
                                <th></th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            {{-- -- Table Content--}}
                            <tbody>
                            <tr v-for="job in jobs">
                                <td>@{{ job.name }}</td>
                                <td><a class="btn btn-info" @click="showJobDetailsModal(job)">
                                        <i class="fal fa-file-alt"></i>
                                        <span class="hidden-xs"> รายละเอียด</span>
                                    </a></td>
                                <td><a class="btn btn-warning" @click="showEditRootJobModal(job)">แก้ไข</a></td>
                                <td><a class="btn btn-danger" @click="porlor4Job_deleteRootJob(job)">ลบ</a></td>
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
        var porlor4FromBlade = JSON.parse('{!!($porlor4)!!}');
    </script>
    <script src="{{asset('views/admin/project_order/js/porlor_4_job_index.js')}}"></script>
@endsection