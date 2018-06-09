<modal
        name="project-referee-add-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenProjectRefereeAddModal($event)"
        @opened="openedProjectRefereeAddModal"
        @before-close="beforeCloseProjectRefereeAddModal"
        width="99%"
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
                @submit.prevent="projectRefereeAdd_addReferees('form',$event)"
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
                        <button type="button" class="btn btn-danger" @click="closeProjectRefereeAddModal">Close
                        </button>
                        <button type="submit" class="col-md-3 pull-right btn btn-success">
                            บันทึก
                        </button>
                    </div>
                    <div class="panel-body">
                        {{--New Referee Form Inputs--}}
                        <template v-for="(referee,index) in project_referee_add.form.new_referees">
                            {{--Name--}}
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        ชื่อ-สกุล
                                    </label>
                                    <div :class="{'input-error':errors.has('form.project_referee_add_referee_name_'+index)}">
                                        <input v-validate="'required'"
                                               type="text"
                                               :data-vv-name="'project_referee_add_referee_name_'+index"
                                               class="form-control"
                                               v-model="referee.name">
                                    </div>
                                    <span v-show="errors.has('form.project_referee_add_referee_name_'+index)"
                                          class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                </div>
                            </div>
                            {{--Rank--}}
                            <div class="col-xs-10 col-md-4">
                                <div class="form-group">
                                    <label class="control-label">
                                        ตำแหน่ง
                                    </label>
                                    <div :class="{'input-error':errors.has('form.project_referee_add_referee_rank_'+index)}">
                                        <multiselect
                                                v-model="referee.rank"
                                                placeholder="" label="name" track-by="id"
                                                :options="project_referee_add.ranks" :option-height="104"
                                                :allow-empty="false"
                                                :show-labels="false">
                                            <template slot="option" slot-scope="props">
                                                <div class="option__desc">
                                                    <span class="option__title">@{{ props.option.name }}</span>
                                                </div>
                                            </template>
                                        </multiselect>
                                        <input
                                                v-validate="'required'"
                                                class="hidden"
                                                v-model="referee.rank"
                                                :data-vv-name="'project_referee_add_referee_rank_'+index"
                                        >
                                    </div>
                                    <span v-show="errors.has('form.project_referee_add_referee_rank_'+index)"
                                          class="text-error text-danger">กรุณาระบุข้อมูล</span>
                                </div>
                            </div>
                            {{--Remove Input--}}
                            {{--แสดงปุ่มลบถ้ามีรายการ Input มากกว่า 1--}}
                            <div v-if="project_referee_add.form.new_referees.length > 1" class="col-xs-2">
                                <div class="form-group">
                                    <label style="visibility: hidden">ลบ</label>
                                    <div class="clearfix"></div>
                                    <a @click="projectRefereeAdd_removeRefereeInput(index)" class="margin-top-5 btn btn-danger">ลบ</a>
                                </div>
                            </div>
                            <div class="col-xs-12">
                               <hr>
                            </div>
                            <div class="clearfix"></div>
                        </template>
                        {{--Add New Input--}}
                        <div class="clearfix"></div>
                        <div class="col-md-6 pull-right text-right">
                            <a @click="projectRefereeAdd_addRefereeInput" class="btn btn-info">เพิ่มรายชื่อ</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</modal>