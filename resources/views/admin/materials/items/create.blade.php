@extends('admin.layouts.master')
@section('breadcrumb')
    {{Breadcrumbs::render('materialItemsCreate')}}
@endsection
@section('content')
    <div id="material-item-create" class="row" v-cloak>
        <loading
                :show="show"
        >
        </loading>
        {{-- Form--}}
        <form @submit.prevent="validateForm('form')"
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
                            <a href="#localPrice" data-toggle="tab">ราคาประจำท้องถิ่น</a>
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
                                                        <label :class="{'text-danger':errors.has('form.materialTypeID')}"
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
                                                            <vue-numeric name="globalPrice" :precision=2
                                                                         class="form-control" separator=","
                                                                         v-model="form.globalPrice"></vue-numeric>
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
                            <div v-for="(city,index) in form.cities" :key="index" class="portlet">
                                {{-- -- -- Title--}}
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-reorder"></i> รายการที่: @{{index+1}}
                                        <span v-if="form.cities[index].province">จังหวัด :</span>
                                        @{{form.cities[index].province.name }}
                                        <span v-if="form.cities[index].amphoe">อำเภอ :</span>
                                        @{{form.cities[index].amphoe.name}}
                                        <span v-if="form.cities[index].district">ตำบล :</span>
                                        @{{ form.cities[index].district.name }}
                                    </div>
                                    <div class="tools">
                                        <a ref="toolIcon" class="collapse"></a>
                                    </div>
                                </div>
                                {{-- -- -- Begin Local Price FORM--}}
                                <div :ref="'displayForm'" class="portlet-body form">
                                    <div class="form-horizontal">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <h3 class="form-section">รายการที่: @{{index+1}}
                                                        <!-- -- -- -- Delete Local Price-->
                                                        <span @click="deleteLocalPrice(index)"
                                                              class="pull-right btn btn-danger btn-danger-delete"> - </span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!-- -- -- Province-->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="province"
                                                               class="control-label col-md-3">จังหวัด</label>
                                                        <div class="col-md-9">
                                                            <multiselect @close="getAmphoes(index)"
                                                                         v-model="form.cities[index].province"
                                                                         placeholder="" label="name" track-by="id"
                                                                         :options="provinces" :option-height="104"
                                                                         :allow-empty="false"
                                                                         :show-labels="false">
                                                                <template slot="option" slot-scope="props">
                                                                    <div class="option__desc">
                                                                        <span class="option__title">@{{ props.option.name }}</span>
                                                                    </div>
                                                                </template>
                                                            </multiselect>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -- -- Amphoe-->
                                                <div class="col-md-6">
                                                    <div v-if="form.cities[index].province" class="form-group">
                                                        <label class="control-label col-md-3">อำเภอ</label>
                                                        <div class="col-md-9">
                                                            <multiselect @close="getDistricts(index)"
                                                                         v-model="form.cities[index].amphoe"
                                                                         placeholder="" label="name" track-by="id"
                                                                         :options="form.cities[index].amphoes"
                                                                         :option-height="104"
                                                                         :allow-empty="false"
                                                                         :show-labels="false">
                                                                <template slot="option" slot-scope="props">
                                                                    <div class="option__desc">
                                                                        <span class="option__title">@{{ props.option.name }}</span>
                                                                    </div>
                                                                </template>
                                                            </multiselect>
                                                            <input v-validate="'required'"
                                                                   v-model="form.cities[index].amphoe"
                                                                   name="amphoe" hidden>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -- -- Districts-->
                                                <div class="col-md-6">
                                                    <div  v-if="form.cities[index].amphoe" class="form-group">
                                                        <label class="control-label col-md-3">ตำบล</label>
                                                        <div class="col-md-9">
                                                            <multiselect v-model="form.cities[index].district"
                                                                         placeholder=""
                                                                         label="name" track-by="id"
                                                                         :options="form.cities[index].districts"
                                                                         :allow-empty="false"
                                                                         :option-height="104" :show-labels="false">
                                                                <template slot="option" slot-scope="props">
                                                                    <div class="option__desc">
                                                                        <span class="option__title">@{{ props.option.name }}</span>
                                                                    </div>
                                                                </template>
                                                            </multiselect>
                                                            <input v-validate="'required'"
                                                                   v-model="form.cities[index].district"
                                                                   name="district" hidden>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- -- -- Wage--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ค่าแรง</label>
                                                        <div class="col-md-9">
                                                            <vue-numeric class="form-control"
                                                                         v-model="form.cities[index].wage"
                                                                         placeholder=""
                                                                         :precision=2 separator=","></vue-numeric>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- -- -- Cost/Price--}}
                                            <div class="row">
                                                {{--Cost--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ราคาทุน</label>
                                                        <div class="col-md-9">
                                                            <vue-numeric class="form-control"
                                                                         v-model="form.cities[index].localCost"
                                                                         placeholder="" :precision=2
                                                                         separator=","></vue-numeric>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--Price--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">ราคาขาย</label>
                                                        <div class="col-md-9">
                                                            <vue-numeric class="form-control"
                                                                         v-model="form.cities[index].localPrice"
                                                                         placeholder="" :precision=2
                                                                         separator=","></vue-numeric>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                        </div>
                                    </div>
                                    <!-- END FORM-->
                                </div>
                            </div>
                            <!-- -- Add More Button-->
                            <div class="row">
                                <div class="col-xs-2 pull-right">
                                    <button class="pull-right btn btn-primary" type="button" @click="addPriceInput">+
                                    </button>
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
    <script src="{{asset('views/admin/materials/items/js/item_create.js')}}"></script>
@endsection

