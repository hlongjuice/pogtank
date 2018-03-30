@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('product')}}
@endsection

@section('content')
    <div id="product-index" class="row" v-cloak>
        <loading :show="showLoading"></loading>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-edit"></i>รายการสินค้า
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
                                    <a href="{{route('admin.product.create')}}" class="btn btn-success">
                                        เพิ่มสินค้า <i class="fa fa-plus"></i>
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
                            <th>สินค้า</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        {{-- -- Table Content--}}
                        <tbody>
                            <tr v-for="product in products.data">
                                {{--<td></td>--}}
                                <td>@{{ product.name }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="products"
                                v-on:pagination-change-page="getSelectedProductPage"></pagination>
                </div>
            </div>
            <!-- END Types Table-->
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('views/admin/product/js/product_index.js')}}"></script>
@endsection