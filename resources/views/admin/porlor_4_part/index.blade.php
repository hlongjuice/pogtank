@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('porlor4Part')}}
@endsection

@section('content')
    <div id="porlor-4-part-index" class="row" v-cloak>
        <loading :show="showLoading"></loading>
        @include('admin.porlor_4_part.add_part_modal')
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-edit"></i>หมวดหมู่ ปร.4
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
                                        สร้างหมวดหมู่ใหม่ <i class="fa fa-plus"></i>
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
                                <th>ส่วน</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            {{-- -- Table Content--}}
                            <tbody>
                            <tr v-for="part in parts">
                                <td>@{{ part.name }}</td>
                                <td></td>
                                <td></td>
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
    <script src="{{asset('views/admin/porlor_4_part/js/porlor_4_part_index.js')}}"></script>
@endsection