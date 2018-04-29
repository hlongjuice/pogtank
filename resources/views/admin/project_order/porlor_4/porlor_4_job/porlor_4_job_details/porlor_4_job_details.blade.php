<modal
        name="porlor-4-job-details-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenJobDetailsModal($event)"
        @opened="openedJobDetailsModal"
        @before-close="beforeCloseJobDetailsModal"
        width="99%"
        height="auto"
        :scrollable="detailScrollable"
>
    <loading :show='showLoadingJobDetails'></loading>
    <div id="porlor-4-job-index" class="row" v-cloak>
        @include('admin.project_order.porlor_4.porlor_4_job.porlor_4_job_details.porlor_4_add_child_job.porlor_4_add_child_job')
        @include('admin.project_order.porlor_4.porlor_4_job.porlor_4_job_details.porlor_4_add_child_job_item.porlor_4_add_child_job_item')
        {{--Edit Child Job Modal--}}
        @include('admin.project_order.porlor_4.porlor_4_job.porlor_4_job_details.porlor_4_edit_child_job.porlor_4_edit_child_job')
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="panel panel-default">
                {{-- Close Button--}}
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closePorlor4JobDetailsModal">Close</button>
                </div>
                <div class="panel-body">
                    {{--Page Header--}}
                    <div class="panel">
                        <div class="panel-heading text-center">
                            <h3 class="col-xs-12">แบบแสดงรายการ ปริมาณงานและราคา</h3>
                            <h3 class="col-xs-12">
                                เทศบาลตำบล@{{ project_details.district.name }}
                                <span class="visible-xs">
                                    <br>
                                </span>
                                อำเภอ@{{ project_details.amphoe.name }}
                                <span class="visible-xs">
                                    <br>
                                </span>
                                จังหวัด@{{ project_details.province.name }}
                            </h3>

                        </div>
                        <div class="panel-body">
                        </div>
                    </div>
                    {{--Porlor 4 Details--}}
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                {{--Root Job Name--}}
                                <i class="fa fa-edit"></i>@{{ root_job.name }}
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            {{--Order Details--}}
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p>โครงการ @{{ project_details.project_name }}</p>
                                        </div>
                                    </div>
                                    {{--Address--}}
                                    <div class="row">
                                        <div v-if="project_details.province" class="col-md-12">
                                            <p>สถานที่ก่อสร้าง : @{{ project_details.location }}
                                                @{{project_details.district.name}}
                                                @{{ project_details.amphoe.name }}
                                                @{{ project_details.province.name }}
                                            </p>
                                        </div>
                                    </div>
                                    {{--Form Number and Form Number Release--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>แบบเลขที่ : @{{ project_details.form_number }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>ออกเมื่อวันที่ : @{{ project_details.form_number_release |
                                                moment('DD/MM/YYYY')}}</p>
                                        </div>
                                    </div>
                                    {{--Owner and Agency--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>หน่วยงานเจ้าของโครงการ :@{{ project_details.owner_name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>หน่วยงานประมาณการ : @{{ project_details.agency_name }}</p>
                                        </div>
                                    </div>
                                    {{--Referee and Upadted at--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>คำนวนราคากลางโดย : @{{ project_details.referee_name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>เมื่อวันที่ : @{{ project_details.updated_at| moment('DD/MM/YYYY')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Add New Page--}}
                    <div class="row margin-bottom-10">
                        <div class="col-xs-12">
                            <a @click="jobDetails_addPorlor4Page" class="pull-right btn btn-primary">
                                เพิ่มแผ่นงาน ปร.4 <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    {{-- Polor 4 Page--}}
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                แบบ ปร.4 แผ่นที่
                                <i class="fa fa-edit"></i>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    {{-- Add New Button--}}
                                    <div class="col-xs-12">
                                        <a @click="showAddChildJobModal(child_job.page,child_job.total_page)" class="btn btn-success">
                                            เพิ่มกลุ่มงาน <i class="fa fa-plus"></i>
                                        </a>
                                        <a @click="showAddChildJobItemModal('',child_job.page)" class="btn btn-info">
                                            เพิ่มรายการวัสดุอุปกรณ์ <i class="fa fa-plus"></i>
                                        </a>
                                        {{--Delete Page if empty--}}
                                        <a @click="jobDetails_deletePage(index)" v-if="child_job.jobs.length === 0"
                                           class="pull-right btn btn-danger">
                                            <i class="far fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{-- Types Table--}}
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    {{-- -- Table Header--}}
                                    <thead>
                                    <tr class="table-header-green">
                                        <th class="text-center" rowspan="2">ลบ</th>
                                        <th class="text-center" rowspan="2">แก้ไข</th>
                                        <th width="5%" class="text-center" rowspan="2">ลำดับที่</th>
                                        <th width="30%" class="text-center" rowspan="2">รายการ</th>
                                        <th class="text-center" rowspan="2">จำนวน</th>
                                        <th class="text-center" rowspan="2">หน่วย</th>
                                        <th class="text-center" colspan="2">ค่าวัสดุ</th>
                                        <th class="text-center" colspan="2">ค่าแรงงาน</th>
                                        <th width="10%" class="text-center" rowspan="2">รวมค่าวัสดุและค่าแรงงาน</th>
                                        <th width="10%" class="text-center" rowspan="2">หมายเหตุ</th>
                                    </tr>
                                    <tr class="table-header-green">
                                        <th class="text-center">ราคา/หน่วย</th>
                                        <th class="text-center">จำนวนเงิน</th>
                                        <th class="text-center">ราคา/หน่วย</th>
                                        <th class="text-center">จำนวนเงิน</th>
                                    </tr>
                                    </thead>
                                    {{-- -- Table Content แยกตามกลุ่มงานใน 1 หน้า--}}
                                    <tbody>
                                    <template v-for="job in child_jobs_v2.flat">
                                        <tr class="text-right">
                                            <td class="text-center">
                                                <a @click="jobDetails_deleteChildJob(job)"
                                                   class="btn btn-danger btn-xs">
                                                    <i class="far fa-times"></i>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a @click="showEditChildJobModal(job)" class="btn btn-info btn-xs">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </td>
                                            <td class="text-center">@{{job.order_number}}</td>
                                            <td class="text-left">
                                                @{{ job.name }}
                                                <span v-if="job.is_item == 0">
                                                    <a @click="showAddChildJobItemModal(job,child_job.page)" class="pull-right btn btn-info btn-xs">
                                                    เพิ่มรายการวัสดุ <i class="fa fa-plus"></i>
                                                    </a>
                                                </span>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- END Types Table-->
        </div>
    </div>

</modal>