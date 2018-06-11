<modal
        name="project-referee-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenProjectRefereeModal($event)"
        @opened="openedProjectRefereeModal"
        @before-close="beforeCloseProjectRefereeModal"
        width="90%"
        :max-width="650"
        :adaptive="true"
        height="auto"
        :scrollable="project_referee.isScrollable"
        :draggable="false"
>
    <div class="row">
        <loading :show="project_referee.is_loading"></loading>
        @include('admin.project_order.referee.add_referee.add_referee')
        @include('admin.project_order.referee.edit_referee.edit_referee')
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closeProjectRefereeModal">Close</button>
                </div>
                <div class="panel-body">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                {{--แบบ ปร.4 แผ่นที่ @{{ child_job.page }} / @{{ child_job.total_page }}--}}
                                <i class="fa fa-edit"></i>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                {{-- Add New Type--}}
                                <div class="col-md-6">
                                    <a @click="openProjectRefereeAddModal" class="margin-bottom-10 btn btn-success">
                                        เพิ่มคณะกรรมการ <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="col-md-6 pull-right text-right">
                                    <a @click="projectReferee_deleteMultipleReferees" class="margin-bottom-10 btn btn-danger">
                                        ลบหลายรายการ <i class="far fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                            {{-- Types Table--}}
                            <div v-if="project_referee.referees" class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    {{-- -- Table Header--}}
                                    <thead>
                                    <tr class="table-header-green">
                                        <th class="text-center">
                                            <input
                                                    @change="projectReferee_selectAllReferees"
                                                    type="checkbox"
                                                    v-model="project_referee.select_all_referees"
                                            >
                                        </th>
                                        <th class="text-center" width="6%">ลำดับ</th>
                                        <th class="text-center" width="40%">รายชื่อ</th>
                                        <th class="text-center" width="30%">ตำแหน่ง</th>
                                        <th class="text-center">แก้ไข</th>
                                        <th class="text-center">ลบ</th>
                                    </tr>
                                    </thead>
                                    {{-- -- Table Content --}}
                                    <tbody>
                                    <template v-for="(referee,index) in project_referee.referees">
                                        <tr class="text-center">
                                            <td>
                                                <input
                                                        type="checkbox"
                                                        v-model="project_referee.form.selected_referees"
                                                        :value="referee"
                                                >
                                            </td>
                                            <td>@{{ index+1 }}</td>
                                            <td>@{{ referee.prefix }} @{{ referee.name }}</td>
                                            <td>@{{ referee.rank }}</td>
                                            <td><a @click="openProjectRefereeEditModal(referee)"
                                                   class="btn btn-warning">แก้ไข</a></td>
                                            <td><a @click="projectReferee_deleteReferee(referee)"
                                                   class="btn btn-danger">ลบ</a></td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</modal>