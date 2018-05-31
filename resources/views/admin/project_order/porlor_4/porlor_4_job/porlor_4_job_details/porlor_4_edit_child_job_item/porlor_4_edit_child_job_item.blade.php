<modal
        name="porlor-4-edit-child-job-item-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenEditChildJobItemModal($event)"
        @opened="openedEditChildJobItemModal"
        @before-close="beforeCloseEditChildJobItemModal"
        width="90%"
        height="auto"
        :scrollable="true"
>
    <loading
            :show='edit_child_job_item.isLoading'
    >
    </loading>
    <div class="row">
        <!-- FORM-->
        <form
                @submit.prevent="editChildJobItem_updateItem('form',$event)"
                data-vv-scope="form"
                class="horizontal-form">
            {{csrf_field()}}
            <div class="col-xs-12">

                <div class="panel panel-default">
                    {{-- Close Button--}}
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            <h4>เพิ่มรายการวัสดุ</h4>
                        </div>
                        <button type="button" class="btn btn-danger" @click="closeEditChildJobItemModal">Close
                        </button>
                        <button type="submit" class="col-md-3 pull-right btn btn-success">
                            บันทึก
                        </button>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12">
                            <div class="row">
                                <h3 v-if="edit_child_job_item.form.child_job.name_per_unit!=''">
                                    @{{ edit_child_job_item.form.child_job.name_per_unit }}
                                </h3>
                                <h3 v-else>
                                    @{{ edit_child_job_item.form.child_job.name }}
                                </h3>
                                <hr>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <h4 class="text-danger">** ราคาที่แสดง เป็นราคากลางจากระบบ
                                ผู้ใช้สามารถปรับแก้ไขได้</h4>
                        </div>
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption"></div>
                            </div>
                            <div class="portlet-body">
                                {{--Order Number and Material Type Material Item--}}
                                <div class="row">
                                    {{--Material Item--}}
                                    {{--Material Item--}}
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">วัสดุ/งาน</label>
                                            <div :class="{'input-error':errors.has('form.edit_child_job_item_material_item')}">
                                                <multiselect
                                                        @search-change="editChildJobItem_searchItemsByName"
                                                        @close="editChildJobItem_getItemDetails(edit_child_job_item.form.material_item.approved_global_details)"
                                                        v-model="edit_child_job_item.form.material_item"
                                                        placeholder="พิมพ์เพื่อค้นหา" track-by="id"
                                                        :options="edit_child_job_item.form.material_items"
                                                        :option-height="104"
                                                        :show-labels="false"
                                                        :allow-empty="false"
                                                        :max-height="250"
                                                        :custom-label="editChildJobItem_materialItemCustomLabel"
                                                        {{--:loading="edit_child_job_item.isLoading"--}}
                                                >
                                                    <template slot="option" slot-scope="props">
                                                        <div class="option__desc">
                                                            <span class="option__title">@{{ props.option.approved_global_details.name }}</span>
                                                        </div>
                                                    </template>
                                                    <div class="row"
                                                         slot="noResult">
                                                        <div class="col-xs-12">
                                                            <p>ยังไม่มีรายการในระบบ</p>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <span>@{{edit_child_job_item.new_material_item.name}} </span>
                                                            <a @click="editChildJobItem_addNewMaterialItem"
                                                               class="pull-right btn btn-primary">เพิ่มรายใหม่</a>
                                                        </div>
                                                    </div>
                                                </multiselect>
                                                <input
                                                        data-vv-name="edit_child_job_item_material_item"
                                                        hidden
                                                        v-model="edit_child_job_item.form.material_item">
                                            </div>
                                            <span v-show="errors.has('form.edit_child_job_item_material_item')"
                                                  class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                        </div>
                                    </div>
                                </div>
                                {{-- Price and Wage and Quantity --}}
                                <div v-if="edit_child_job_item.form.material_item" class="row">
                                    <!-- -- Quantity and Unit -->
                                    <div class="col-xs-12 col-md-4">
                                        <div class="row">
                                            <div class="col-xs-8">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        จำนวน
                                                    </label>
                                                    <div :class="{'input-error':errors.has('form.edit_child_job_item_quantity')}">
                                                        {{--<input v-validate="'required'"--}}
                                                               {{--type="number"--}}
                                                               {{--step="0.001"--}}
                                                               {{--data-vv-name="'edit_child_job_item_quantity"--}}
                                                               {{--class="form-control"--}}
                                                               {{--v-model="edit_child_job_item.form.quantity">--}}
                                                        <vue-numeric
                                                                name="globalCost" :precision=2
                                                                class="form-control" separator=","
                                                                v-model="edit_child_job_item.form.quantity"></vue-numeric>
                                                    </div>
                                                    <span v-show="errors.has('form.edit_child_job_item_quantity')"
                                                          class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        หน่วย
                                                    </label>
                                                    <div :class="{'input-error':errors.has('form.edit_child_job_item_unit')}">
                                                        <input v-validate="'required'"
                                                               type="text"
                                                               :data-vv-name="'edit_child_job_item_unit'"
                                                               class="form-control"
                                                               v-model="edit_child_job_item.form.unit">
                                                    </div>
                                                    <span v-show="errors.has('form.edit_child_job_item_unit')"
                                                          class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- -- Price -->
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                ราคา/หน่วย
                                            </label>
                                            <vue-numeric
                                                    name="globalCost" :precision=2
                                                    class="form-control" separator=","
                                                    v-model="edit_child_job_item.form.local_price"></vue-numeric>
                                        </div>
                                    </div>
                                    <!-- -- Wage -->
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                ค่าแรง/หน่วย
                                            </label>
                                            <vue-numeric
                                                    name="globalCost" :precision=2
                                                    class="form-control" separator=","
                                                    v-model="edit_child_job_item.form.local_wage"></vue-numeric>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


</modal>