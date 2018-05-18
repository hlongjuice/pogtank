@extends('web.layouts.master')
@section('content')
    <div id="test-api-index" class="row" v-cloak>
        {{--Post--}}
        <div class="col-md-6">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        Api From ThaiDataHosting
                    </div>
                </div>
                <div class="portlet-body">
                    {{-- Types Table--}}
                    <table class="table table-striped table-hover table-bordered">
                        {{-- -- Table Header--}}
                        <thead>
                        <tr>
                            {{--<th>ID</th>--}}
                            <th>no</th>
                            <th>item</th>
                            <th></th>
                            <th></th>
                            {{--<th></th>--}}
                        </tr>
                        </thead>
                        {{-- -- Table Content--}}
                        <tbody>
                        <tr v-for="(item,index) in itemsThaiData">
                            {{--<td></td>--}}
                            <td>@{{ item.id}}</td>
                            <td>@{{ item.name }}</td>
                            <td>   <a
                                        onclick="event.preventDefault();
                            document.getElementById('update-item').submit();"
                                >
                                    แก้ไข</a>
                                <form id="update-item" action="{{ route('test_api.update_item',10) }}" method="POST" style="display: none;">
                                    <input name="_method" type="hidden" value="PUT">
                                    {{ csrf_field() }}
                                </form></td>
                            {{--<td><a class="btn btn-warning" @click="openProjectOrderEditModal(order)">แก้ไข</a></td>--}}
                            <td>   <a
                                        onclick="event.preventDefault();
                            document.getElementById('delete-item').submit();"
                                >
                                    ลบ</a>
                                <form id="delete-item" action="{{ route('test_api.delete',10) }}" method="POST" style="display: none;">
                                    <input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}
                                </form></td>
                        </tr>
                        </tbody>
                    </table>
                    <p> <span style="overflow-wrap: break-word">url : @{{ urlThaiData }}</span></p>
                </div>
            </div>
        </div>

        {{--Home Table--}}
        <div class="col-md-6">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        Api From Home Server
                    </div>
                </div>
                <div class="portlet-body">
                    {{-- Types Table--}}
                    <table class="table table-striped table-hover table-bordered">
                        {{-- -- Table Header--}}
                        <thead>
                        <tr>
                            {{--<th>ID</th>--}}
                            <th>no</th>
                            <th>item</th>
                            <th></th>
                            <th></th>
                            {{--<th></th>--}}
                        </tr>
                        </thead>
                        {{-- -- Table Content--}}
                        <tbody>
                        <tr v-for="(item,index) in itemsHome">
                            {{--<td></td>--}}
                            <td>@{{ item.id}}</td>
                            <td>@{{ item.name }}</td>
                            <td>   <a
                                        onclick="event.preventDefault();
                            document.getElementById('update-item').submit();"
                                >
                                    แก้ไข</a>
                                <form id="update-item" action="{{ route('test_api.update_item',10) }}" method="POST" style="display: none;">
                                    <input name="_method" type="hidden" value="PUT">
                                    {{ csrf_field() }}
                                </form></td>
                            {{--<td><a class="btn btn-warning" @click="openProjectOrderEditModal(order)">แก้ไข</a></td>--}}
                            <td>   <a
                                        onclick="event.preventDefault();
                            document.getElementById('delete-item').submit();"
                                >
                                    ลบ</a>
                                <form id="delete-item" action="{{ route('test_api.delete',10) }}" method="POST" style="display: none;">
                                    <input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}
                                </form></td>
                        </tr>
                        </tbody>
                    </table>
                    <p >url : <span style="overflow-wrap: break-word">@{{ urlHome }}</span></p>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('script')
    <script src="{{asset('views/web/test_api/index.js')}}"></script>
@endsection