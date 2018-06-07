<modal
        name="project-referee-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenProjectRefereeModal($event)"
        @opened="openedProjectRefereeModal"
        @before-close="beforeCloseProjectRefereeModal"
        width="99%"
        height="auto"
        :scrollable="true"
>
    <div class="row">
        <loading :show="project_referee.is_loading"></loading>
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closePorlor5Modal">Close</button>
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
                            {{-- Types Table--}}
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    {{-- -- Table Header--}}
                                    <thead>
                                    <tr class="table-header-green">
                                        <th>ลำดับ</th>
                                        <th>รายชื่อ</th>
                                        <th>ตำแหน่ง</th>
                                        <th>แก้ไข</th>
                                        <th>ลบ</th>
                                    </tr>
                                    </thead>
                                    {{-- -- Table Content --}}
                                    <tbody>
                                    <template v-for="(referee,index) in project_referee.referees">
                                        <tr>
                                            <td>@{{ index+1 }}</td>
                                            <td>@{{ referee.prefix }} @{{ referee.name }}</td>
                                            <td>@{{ referee.rank }}</td>
                                            <td><a @click="projectReferee_editRefereeModal(referee)" class="btn btn-warning">แก้ไข</a></td>
                                            <td><a @click="projectReferee_deleteReferee(referee)" class="btn btn-danger">ลบ</a></td>
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