<modal
        name="edit-local-price-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeEditOpen($event)"
        @before-close="beforeClose"
        width="90%"
        height="auto"
        :scrollable="true"
>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closeEditPriceModal">Close</button>
                </div>
                <div class="panel-body">
                    <form @submit.prevent="updateLocalPrice('form',$event)"
                          data-vv-scope="form">
                        {{csrf_field()}}
                        <div class="col-xs-12">
                            <button type="submit" class="col-xs-3 pull-right btn btn-success margin-bottom-20">
                                บันทึก
                            </button>
                        </div>
                        <div v-for="(city,index) in form.cities" :key="index" class="portlet">
                            {{-- -- Title--}}
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
                            {{-- -- Begin Local Price FORM--}}
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
                                                        <input v-validate="'required'"
                                                               v-model="form.cities[index].province"
                                                               name="province" hidden>
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
                                                <div v-if="form.cities[index].amphoe" class="form-group">
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
                                            {{-- -- Wage--}}
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
                                        {{-- -- Cost/Price--}}
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</modal>