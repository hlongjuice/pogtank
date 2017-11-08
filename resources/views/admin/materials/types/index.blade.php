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
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{route('admin.materials.types.create')}}" class="btn btn-success">
                                        เพิ่มหมวดหมู่ <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group pull-right">
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
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
                    <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                        <thead>
                        <tr>
                            <th>
                                Username
                            </th>
                            <th>
                                Full Name
                            </th>
                            <th>
                                Points
                            </th>
                            <th>
                                Notes
                            </th>
                            <th>
                                Edit
                            </th>
                            <th>
                                Delete
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                alex
                            </td>
                            <td>
                                Alex Nilson
                            </td>
                            <td>
                                1234
                            </td>
                            <td class="center">
                                power user
                            </td>
                            <td>
                                <a class="edit" href="javascript:;">
                                    Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;">
                                    Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                lisa
                            </td>
                            <td>
                                Lisa Wong
                            </td>
                            <td>
                                434
                            </td>
                            <td class="center">
                                new user
                            </td>
                            <td>
                                <a class="edit" href="javascript:;">
                                    Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;">
                                    Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                nick12
                            </td>
                            <td>
                                Nick Roberts
                            </td>
                            <td>
                                232
                            </td>
                            <td class="center">
                                power user
                            </td>
                            <td>
                                <a class="edit" href="javascript:;">
                                    Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;">
                                    Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                goldweb
                            </td>
                            <td>
                                Sergio Jackson
                            </td>
                            <td>
                                132
                            </td>
                            <td class="center">
                                elite user
                            </td>
                            <td>
                                <a class="edit" href="javascript:;">
                                    Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;">
                                    Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                webriver
                            </td>
                            <td>
                                Antonio Sanches
                            </td>
                            <td>
                                462
                            </td>
                            <td class="center">
                                new user
                            </td>
                            <td>
                                <a class="edit" href="javascript:;">
                                    Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;">
                                    Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                gist124
                            </td>
                            <td>
                                Nick Roberts
                            </td>
                            <td>
                                62
                            </td>
                            <td class="center">
                                new user
                            </td>
                            <td>
                                <a class="edit" href="javascript:;">
                                    Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;">
                                    Delete </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    @endsection
@section('script')

    @endsection