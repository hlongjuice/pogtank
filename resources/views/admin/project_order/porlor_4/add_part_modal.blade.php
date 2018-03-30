<modal
        name="porlor-4-add-new-part-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenAddNewPartModal($event)"
        @before-close="beforeCloseAddNewPartModal"
        width="50%"
        height="60%"
        :scrollable="true"
>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closeAddNewPartModal">Close</button>
                </div>
                <div class="panel-body">
                    <!-- FORM-->
                    <form
                            @submit.prevent="addPart('form',$event)"
                            data-vv-scope="form"
                            class="horizontal-form">
                        {{csrf_field()}}
                        <div class="col-xs-12">
                            <button type="submit" class="col-xs-3 pull-right btn btn-success margin-bottom-20">
                                บันทึก
                            </button>
                        </div>
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-reorder"></i>หมวดหมู่ ปร.4
                                </div>
                            </div>
                            <div class="portlet-body form">

                                <div class="form-body">
                                    <div class="row">
                                        <!-- -- Parts -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">หมวดหมู่</label>
                                                <div :class="{'input-error':errors.has('form.part')}">
                                                    <multiselect
                                                            v-model="form.part"
                                                            placeholder="" label="name" track-by="id"
                                                            :options="parts" :option-height="104"
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
                                                           name="part" hidden
                                                           v-model="form.part">
                                                </div>
                                                <span v-show="errors.has('form.part')"
                                                      class="text-error text-danger">กรุณากรอกข้อมูล</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>

        </div>
    </div>
</modal>