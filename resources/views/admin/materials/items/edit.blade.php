@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialItemsCreate')}}
@endsection
@section('content')
    {{--Include Modal--}}
    @include('admin.materials.items.edit_add_modal')
    <div id="app" class="row">
        {{-- Form--}}
        <form method="POST" action="{{route('admin.materials.items.store')}}" @submit="validateForm('form',$event)"
              data-vv-scope="form">
            {{csrf_field()}}
            <div class="col-xs-12">
                <button type="submit" class="visible-xs col-xs-6 pull-right btn btn-success margin-bottom-20">บันทึก
                </button>
            </div>
            <div class="col-xs-12">
                <div class="tabbable tabbable-custom">
                    <!-- -- Submit Button-->
                    <div class="hidden-xs form-submit-button-tab">
                        <button name="button" type="submit" class="btn btn-success">บันทึก</button>
                    </div>
                    <!--Tabs Header-->
                    <ul class="nav nav-tabs">
                        <!-- -- Tab Item Details-->
                        <li class="active">
                            <a href="#item-details" data-toggle="tab">รายละเอียดสินค้า</a>
                        </li>
                        <!-- -- Tab Local Price-->
                        <li>
                            <a href="#localPrice" data-toggle="tab">ราคาประจำตำบล</a>
                        </li>
                    </ul>
                    <!--Tab Content-->
                    <div class="tab-content">
                        <!--  -- Item Details-->
                        <div class="tab-pane active" id="item-details">
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-reorder"></i>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                        <a href="javascript:;" class="reload"></a>
                                        <a href="javascript:;" class="remove"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-horizontal">
                                        <div class="form-body">
                                            <h3 class="form-section">
                                                รายละเอียดวัสดุ/อุปกรณ์
                                            </h3>
                                            <div class="row">
                                                <!-- -- -- Material Name-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label :class="{'text-danger':errors.has('form.materiaName')}"
                                                               class="control-label col-md-3">ชื่อ</label>
                                                        <div class="col-md-9">
                                                            <input :class="{'input-error':errors.has('form.materialName')}"
                                                                   v-validate="'required'"
                                                                   data-vv-as="รายชื่อ"
                                                                   data-vv-name="materialName"
                                                                   type="text" class="form-control"
                                                                   name="materialName"
                                                                   v-model="form.materialName"
                                                                   placeholder="">
                                                            <span v-show="errors.has('form.materialName')"
                                                                  class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -- -- Material Types-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label :class="{'text-danger':errors.has('form.materialTypeID')}"
                                                               class="control-label col-md-3">หมวดหมู่</label>
                                                        <div class="col-md-9">
                                                            <div :class="{'input-error':errors.has('form.materialTypeID')}">
                                                                <multiselect
                                                                        name="materialType"
                                                                        v-model="form.materialType"
                                                                        placeholder="เลือกหมวดหมู่" label="name"
                                                                        track-by="id"
                                                                        :options="materialTypes" :option-height="104"
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
                                                                       v-model="form.materialTypeID"
                                                                       name="materialTypeID" hidden>
                                                            </div>
                                                            <span v-show="errors.has('form.materialTypeID')"
                                                                  class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                {{-- -- -- Unit--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label :class="{'text-danger':errors.has('form.materialTypeID')}"
                                                               class="control-label col-md-3">หน่วย</label>
                                                        <div class="col-md-9">
                                                            <input
                                                                    v-validate="'required'"
                                                                    :class="{'input-error':errors.has('form.materialUnit')}"
                                                                    name="materialUnit"
                                                                    v-model="form.materialUnit"
                                                                    type="text" class="form-control"
                                                                    :class="{'input-error':errors.has('materialUnit')}"
                                                                    placeholder="">
                                                            <span v-show="errors.has('form.materialTypeID')"
                                                                  class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- -- -- Vendor--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">แหล่งที่มา</label>
                                                        <div class="col-md-9">
                                                            <input name="materialVendor"
                                                                   v-model="form.materialVendor"
                                                                   type="text" class="form-control"
                                                                   placeholder="">
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
                                                                    v-model="form.globalCost"></vue-numeric>
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
                                                                         v-model="form.invoicePrice"></vue-numeric>
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
                                                                         v-model="form.invoiceCost"></vue-numeric>
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
                                                                         v-model="form.invoicePrice"></vue-numeric>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- -- End Details Tab--}}
                    <!-- --  Local Price-->
                        <div class="tab-pane" id="localPrice">
                            <div class="col-xs-12 col-md-4">
                                <button class="btn btn-primary" @click="showAddPriceModal" type="button">เพิ่มรายการ</button>
                            </div>
                            <!-- Table -->
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <!-- -- Table Header -->
                                <thead>
                                <tr>
                                    <td>จังหวัด</td>
                                    <td>อำเภอ</td>
                                    <td>ตำบล</td>
                                    <td>ราคาทุน</td>
                                    <td>ราคาขาย</td>
                                    <td>ค่าแรง</td>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <!-- -- Table Body -->
                                <tbody>
                                {{--{{dd($material)}}--}}
                                @foreach($material->localPrices as $localPrice)
                                    <tr>
                                        <td>{{$localPrice->province->name}}</td>
                                        <td>{{$localPrice->amphoe->name}}</td>
                                        <td>{{$localPrice->district->name}}</td>
                                        <td>{{$localPrice->cost}}</td>
                                        <td>{{$localPrice->price}}</td>
                                        <td>{{$localPrice->wage}}</td>
                                        <td>
                                            <a class="btn btn-info"
                                               href="{{route('admin.materials.items.edit',$localPrice->id)}}">Edit </a>
                                        </td>
                                        <td>
                                            <form onsubmit="return confirm('ยืนยันการลบ')" method="POST"
                                                  action="{{route('admin.materials.items.destroy',$localPrice->id)}}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-danger" type="submit">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
        var materialTypes = JSON.parse('{!! $materialTypes !!}');
        var provinces = JSON.parse('{!! $provinces !!}');
        var material = JSON.parse('{!! $material !!}');
        var indexRoute = '{!! $indexRoute !!}';
    </script>
    <script src="{{asset('views/admin/materials/items/js/item_edit.js')}}"></script>
    <script src="{{asset('views/admin/materials/items/js/item_edit_add_modal.js')}}"></script>
@endsection

