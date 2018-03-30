<modal
        name="porlor-4-job-add-root-job-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenAddRootJobModal($event)"
        @before-close="beforeCloseAddRootJobModal"
        width="50%"
        height="auto"
        :scrollable="true"
>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                {{-- Close Button--}}
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closeAddRootJobModal">Close</button>
                </div>
                <div class="panel-body">
                    <!-- FORM-->
                    <form
                            @submit.prevent="addRootJob('form',$event)"
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
                                    <i class="fa fa-reorder"></i>งาน
                                </div>
                            </div>
                            <div class="portlet-body form">

                                <div class="form-body">
                                    <div class="row">
                                        <!-- -- Parts -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">ชื่องาน</label>
                                                <div :class="{'input-error':errors.has('form.root_job_name')}">
                                                    <input v-validate="'required'"
                                                           name="root_job_name"
                                                           class="form-control"
                                                           v-model="form.root_job_name">
                                                </div>
                                                <span v-show="errors.has('form.root_job_name')"
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