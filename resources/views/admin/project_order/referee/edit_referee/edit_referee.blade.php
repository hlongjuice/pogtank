<modal
        name="project-referee-edit-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenProjectRefereeEditModal($event)"
        @opened="openedProjectRefereeEditModal"
        @before-close="beforeCloseProjectRefereeEditModal"
        width="90%"
        :max-width="600"
        :adaptive="true"
        height="auto"
        :scrollable="true"
>
    <loading
            :show='project_referee_add.isLoading'
    >
    </loading>
    <div class="row">
        <!-- FORM-->
        <form
                @submit.prevent="projectRefereeEdit_updateReferee('form',$event)"
                data-vv-scope="form"
                class="horizontal-form">
            {{csrf_field()}}
            <div class="col-xs-12">

                <div class="panel panel-default">
                    {{-- Close Button--}}
                    <div class="panel-heading">
                        <div class="panel-title text-center">
                            <h4>เพิ่มคณะกรรมการ</h4>
                        </div>
                        <button type="button" class="btn btn-danger" @click="closeProjectRefereeEditModal">Close
                        </button>
                        <button type="submit" class="col-md-3 pull-right btn btn-success">
                            บันทึก
                        </button>
                    </div>
                    <div v-if="project_referee_edit.form.referee" class="panel-body">
                            {{--Name--}}
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label class="control-label">
                                    ชื่อ-สกุล
                                </label>
                                <div :class="{'input-error':errors.has('form.project_referee_edit_referee_name')}">
                                    <input v-validate="'required'"
                                           type="text"
                                           :data-vv-name="'project_referee_edit_referee_name'"
                                           class="form-control"
                                           v-model="project_referee_edit.form.referee.name">
                                </div>
                                <span v-show="errors.has('form.project_referee_edit_referee_name')"
                                      class="text-error text-danger">กรุณาระบุข้อมูล</span>
                            </div>
                        </div>
                        {{--Rank--}}
                        <div class="col-xs-10 col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    ตำแหน่ง
                                </label>
                                <div :class="{'input-error':errors.has('form.project_referee_edit_referee_rank')}">
                                    <input class="form-control"
                                            v-validate="'required'"
                                            v-model="project_referee_edit.form.referee.rank"
                                            :data-vv-name="'project_referee_edit_referee_rank'"
                                    >
                                </div>
                                <span v-show="errors.has('form.project_referee_edit_referee_rank')"
                                      class="text-error text-danger">กรุณาระบุข้อมูล</span>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <hr>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</modal>