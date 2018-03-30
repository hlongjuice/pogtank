@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialItemEdit',$material)}}
@endsection
@section('content')
    {{--Include Modal--}}
    <div id="material-item-edit" class="row" v-cloak>
        {{--Add Modal--}}
        @include('admin.materials.items.edit_add_modal')
        {{--Edit Modal--}}
        @include('admin.materials.items.edit_edit_modal')
        <loading :show="showLoading"></loading>
        {{-- Form--}}
        <form @submit.prevent="validateForm('form',$event)"
              data-vv-scope="form">
            {{ method_field('PUT') }}
            {{csrf_field()}}
            {{--Close Button--}}
            <div class="col-xs-6 pull-right">
                <a href="{{route('admin.materials.items.index')}}"
                   class="visible-xs btn btn-danger margin-right-10 margin-bottom-20">ปิด
                </a>
            </div>
            {{--Portlets--}}
            <div class="col-xs-12">
                <div class="tabbable tabbable-custom">
                    <!-- -- Submit Button-->
                    <div class="hidden-xs form-submit-button-tab">
                        <a href="{{route('admin.materials.items.index')}}" name="button" type="submit"
                           class="btn btn-danger">
                            <i class="far fa-times"></i> ปิด
                        </a>
                    </div>
                    <!--Tabs Header-->
                    <ul class="nav nav-tabs">
                        <!-- -- Tab Item Details-->
                        <li class="active">
                            <a href="#item-details" data-toggle="tab">รายละเอียดสินค้า</a>
                        </li>
                        <!-- -- Tab Local Price-->
                        <li>
                            <a href="#localPrice" data-toggle="tab">ราคาประจำท้องถิ่น</a>
                        </li>
                        <li>
                            <a href="#lastUpdated" data-toggle="tab">
                                รายการแก้ไขรออนุมัติ
                                <span class="badge badge-danger badge-notify">
                                        @{{waitingItemNumber}}
                                    รายการ
                                    </span>
                            </a>
                        </li>
                    </ul>
                    <!--Tab Content-->
                    <div class="tab-content">
                        <!-- --Approved Global Price and  Details Tab-->
                        <div class="tab-pane active" id="item-details">
                            <div class="portlet">
                                {{-- -- --Global Details--}}
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-reorder"></i>
                                    </div>
                                    <div class=tools">
                                        {{--<a href="javascript:;" class="collapse"></a>--}}
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div v-if="approvedGlobalDetails" class="form-horizontal">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-xs-9">
                                                    <h3 class="form-section">
                                                        รายละเอียดวัสดุ/อุปกรณ์
                                                        <span class="small text-info">
                                                        อัพเดทล่าสุด : @{{approvedGlobalDetails.updated_at}}
                                                    </span>
                                                        <small v-if="material.published"
                                                               class="margin-top-10 pull-right">
                                                    <span :class="'text-'+ material.published.color">
                                                        สถาณะ:@{{material.published.name}}
                                                    </span>
                                                        </small>
                                                    </h3>
                                                </div>
                                                {{-- --Global Details Edit Save Button--}}
                                                <div class="col-xs-3 text-right">
                                                    <a @click="updateGlobalDetails" class="btn btn-success">บันทึก</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!-- -- -- Material Name-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label :class="{'text-danger':errors.has('approvedGlobalDetails.name')}"
                                                               class="control-label col-md-3">ชื่อ</label>
                                                        <div class="col-md-9">
                                                            <input :class="{'input-error':errors.has('approvedGlobalDetails.name')}"
                                                                   v-validate="'required'"
                                                                   data-vv-as="รายชื่อ"
                                                                   data-vv-name="materialName"
                                                                   type="text" class="form-control"
                                                                   name="materialName"
                                                                   v-model="approvedGlobalDetails.name"
                                                                   placeholder="">
                                                            <span v-show="errors.has('approvedGlobalDetails.name')"
                                                                  class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -- -- Material Types-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label :class="{'text-danger':errors.has('approvedGlobalDetails.type_id')}"
                                                               class="control-label col-md-3">หมวดหมู่</label>
                                                        <div class="col-md-9">
                                                            <div :class="{'input-error':errors.has('approvedGlobalDetails.type_id')}">
                                                                <multiselect
                                                                        name="materialType"
                                                                        v-model="approvedGlobalDetails.type"
                                                                        placeholder="เลือกหมวดหมู่" label="name"
                                                                        track-by="id"
                                                                        :options="materialTypes"
                                                                        :option-height="104"
                                                                        :show-labels="false"
                                                                        :allow-empty="false"
                                                                >
                                                                    <template slot="option" slot-scope="props">
                                                                        <div class="option__desc">
                                                                            <span class="option__title">@{{ props.option.name }}</span>
                                                                        </div>
                                                                    </template>
                                                                </multiselect>
                                                                <input v-validate="'required'"
                                                                       v-model="approvedGlobalDetails.type_id"
                                                                       name="materialTypeID" hidden>
                                                            </div>
                                                            <span v-show="errors.has('approvedGlobalDetails.type_id')"
                                                                  class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                {{-- -- -- Unit--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label :class="{'text-danger':errors.has('materialUnit')}"
                                                               class="control-label col-md-3">หน่วย</label>
                                                        <div class="col-md-9">
                                                            <input
                                                                    v-validate="'required'"
                                                                    :class="{'input-error':errors.has('approvedGlobalDetails.unit')}"
                                                                    name="materialUnit"
                                                                    v-model="approvedGlobalDetails.unit"
                                                                    type="text" class="form-control"
                                                                    :class="{'input-error':errors.has('materialUnit')}"
                                                                    placeholder="">
                                                            <span v-show="errors.has('materialUnit')"
                                                                  class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- -- -- Vendor--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">แหล่งที่มา</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control"
                                                                   v-model="approvedGlobalDetails.vendor">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- -- -- Global Cost-->
                                            <h4 class="form-section">ราคากลาง</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ทุน</label>
                                                        <div class="col-md-9">
                                                            <vue-numeric
                                                                    :class="{'input-error':errors.has('globalPrice')}"
                                                                    v-validate="'required'"
                                                                    name="globalCost" :precision=2
                                                                    class="form-control" separator=","
                                                                    v-model="approvedGlobalDetails.global_cost"></vue-numeric>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -- -- Global Price-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ขาย</label>
                                                        <div class="col-md-9">
                                                            <vue-numeric name="invoiceCost" :precision=2
                                                                         class="form-control" separator=","
                                                                         v-model="approvedGlobalDetails.global_price"></vue-numeric>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 class="form-section">ราคาจากใบเสนอราคา</h4>
                                            <div class="row">
                                                {{-- -- -- Invoice Cost--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ทุน</label>
                                                        <div class="col-md-9">
                                                            <vue-numeric name="invoiceCost" :precision=2
                                                                         class="form-control" separator=","
                                                                         v-model="approvedGlobalDetails.invoice_cost"></vue-numeric>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- -- -- Invoice Price--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ขาย</label>
                                                        <div class="col-md-9">
                                                            <vue-numeric name="invoicePrice" :precision=2
                                                                         class="form-control" separator=","
                                                                         v-model="approvedGlobalDetails.invoice_price"></vue-numeric>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- -- -- IF not apprvoed--}}
                                    <div v-else class="text-center">
                                        <h4>รอการอนุมัติ</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- -- End Details Tab--}}
                    <!-- --Approved Local Price Tab-->
                        <div class="tab-pane" id="localPrice">
                            {{-- --  -- Add New Local Price--}}
                            <div class="col-xs-12 col-md-4">
                                <button class="margin-bottom-15 btn btn-primary" @click="showAddLocalPriceModal"
                                        type="button">เพิ่มรายการ
                                </button>
                            </div>
                            {{-- -- -- Approved Local Price--}}
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i>ราคาตามพื้นที่
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <!-- -- -- --Approved Local Price Table -->
                                    <table class="table table-striped table-hover table-bordered"
                                           id="sample_editable_1">
                                        <!-- -- -- -- --Approved Local Price Table Header -->
                                        <thead>
                                        <tr>
                                            <th>จังหวัด</th>
                                            <th>อำเภอ</th>
                                            <th>ตำบล</th>
                                            <th>ค่าแรง</th>
                                            <th>ราคาทุน</th>
                                            <th>ราคาขาย</th>
                                            <th>Edit</th>
                                            @if(Auth::user()->hasRole('admin'))
                                                <th>Delete</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <!-- -- -- -- --Approved Local Price Table Body -->
                                        <tbody>
                                        <tr v-for="(localPrice,index) in approvedLocalPrices.data" :key="index">
                                            <td>@{{localPrice.approved_price.province.name}}</td>
                                            <td>@{{localPrice.approved_price.amphoe.name}}</td>
                                            <td>@{{localPrice.approved_price.district.name}}</td>
                                            <td>@{{localPrice.approved_price.wage}}</td>
                                            <td>@{{localPrice.approved_price.cost}}</td>
                                            <td>@{{localPrice.approved_price.price}}</td>
                                            <td>
                                                {{--Edit Button--}}
                                                <a @click="showEditLocalPriceModal(approvedLocalPrices.data[index],'approved')"
                                                   class="btn btn-info">Edit</a>
                                            </td>
                                            @if(Auth::user()->hasRole('admin'))
                                                <td>

                                                    {{--Delete Button--}}
                                                    <a @click="deleteLocalPrice(localPrice)"
                                                       class="btn btn-danger">Delete</a>
                                                </td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- -- Waiting For Approval Tabs --}}
                        <div class="tab-pane" id="lastUpdated">
                            {{-- -- -- Waiting Global Price--}}
                            <div v-if="waitingGlobalDetails != null" class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i>รายละเอียดหลัก
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <!-- -- -- --Waiting Global Price Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered">
                                            <!-- -- Table Header -->
                                            <thead>
                                            <tr>
                                                <th>ชื่อ</th>
                                                <th>หมวดหมู่</th>
                                                <th>หน่วย</th>
                                                <th>แหล่งที่มา</th>
                                                <th>ราคาทุนกลาง</th>
                                                <th>ราคาขายกลาง</th>
                                                <th>ราคาทุนใบเสนอราคา</th>
                                                <th>ราคาขายใบเสนอราคา</th>
                                                <th>แก้ไข</th>
                                            </tr>
                                            </thead>
                                            <!-- -- -- -- --Table Waiting Global Price Table Body -->
                                            <tbody>
                                            <tr>
                                                <td>@{{waitingGlobalDetails.name}}</td>
                                                <td>
                                                    <span v-if="waitingGlobalDetails.type">
                                                          @{{waitingGlobalDetails.type.name}}
                                                    </span>
                                                </td>
                                                <td>@{{waitingGlobalDetails.unit}}</td>
                                                <td>
                                                    <span v-if="waitingGlobalDetails.vendor">
                                                        @{{waitingGlobalDetails.vendor}}
                                                    </span>
                                                    <span v-else> - </span>
                                                </td>
                                                <td>@{{waitingGlobalDetails.global_cost}}</td>
                                                <td>@{{waitingGlobalDetails.global_price}}</td>
                                                <td>@{{waitingGlobalDetails.invoice_cost}}</td>
                                                <td>@{{waitingGlobalDetails.invoice_price}}</td>
                                                <td>
                                                    {{--Approved--}}
                                                    @if(Auth::user()->hasRole('admin'))
                                                        <a @click="updateGlobalDetailsStatus(waitingGlobalDetails)"
                                                           class="btn btn-success">อนุมัติ</a>
                                                    @endif
                                                    {{--Reject--}}
                                                    {{--Delete--}}
                                                    <a v-if="approvedGlobalDetails != null"
                                                       @click="deleteWaitingGlobalDetails(waitingGlobalDetails)"
                                                       class="btn btn-danger">
                                                        <i class="far fa-trash-alt"></i>
                                                        <span class="hidden-xs">ปฏิเสธ</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- -- -- Waiting  Local Price--}}
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i>ราคาตามพื้นที่
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <!-- -- -- --Waiting Local Price Table -->
                                    @if(Auth::user()->hasRole('admin'))
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <a @click="updateLocalPriceStatus" class=" btn btn-success">
                                                    อนุมัติ
                                                </a>
                                            </div>
                                            <div class="col-xs-6 pull-right text-right margin-bottom-5">
                                                <a @click="deleteMultipleWaitingLocalPrices" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered"
                                               id="waiting-local-price">
                                            <!-- -- -- -- --Table Header -->
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>จังหวัด</th>
                                                <th>อำเภอ</th>
                                                <th>ตำบล</th>
                                                <th>ค่าแรง</th>
                                                <th>ราคาทุน</th>
                                                <th>ราคาขาย</th>
                                                <th>ลบ</th>
                                            </tr>
                                            </thead>
                                            <!-- -- -- -- --Waiting Local Price Table Body -->
                                            <tbody v-if="1">
                                            <tr v-for="(localItem,index) in waitingLocalPrices.data" :key="index">
                                                <td><input v-model="checkedWaitingLocalPrices"
                                                           :value="localItem.waiting_price"
                                                           type="checkbox"></td>
                                                <td>@{{localItem.waiting_price.province.name}}</td>
                                                <td>@{{localItem.waiting_price.amphoe.name}}</td>
                                                <td>@{{localItem.waiting_price.district.name}}</td>
                                                <td>@{{localItem.waiting_price.wage}}</td>
                                                <td>@{{localItem.waiting_price.cost}}</td>
                                                <td>@{{localItem.waiting_price.price}}</td>
                                                <td>
                                                    {{--Delete--}}
                                                    <a @click="deleteWaitingLocalPrice(localItem)"
                                                       class="btn btn-danger">
                                                        <i class="far fa-trash-alt"></i>
                                                        <span class="hidden-xs"> Delete</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <pagination :data="waitingLocalPrices"
                                                    v-on:pagination-change-page="getWaitingLocalPriceResults"></pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    {{--Scirpt--}}
    <script>
        $('#sample_editable_1').dataTable({
            "paging": false
        });
    </script>
    <script src="{{asset('views/admin/materials/items/js/item_edit.js')}}"></script>
@endsection

