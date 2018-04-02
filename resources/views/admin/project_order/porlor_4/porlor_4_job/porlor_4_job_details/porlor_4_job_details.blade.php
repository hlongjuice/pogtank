<modal
        name="porlor-4-job-details-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenJobDetailsModal($event)"
        @opened="openedJobDetailsModal"
        @before-close="beforeCloseJobDetailsModal"
        width="99%"
        height="auto"
        :scrollable="true"
>
    <loading :show='showLoadingJobDetails'></loading>
    <div id="porlor-4-job-index" class="row" v-cloak>
        @include('admin.project_order.porlor_4.porlor_4_job.porlor_4_job_details.porlor_4_add_child_job.porlor_4_add_child_job')
        @include('admin.project_order.porlor_4.porlor_4_job.porlor_4_job_details.porlor_4_add_child_job_item.porlor_4_add_child_job_item')
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="panel panel-default">
                {{-- Close Button--}}
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closePorlor4JobDetailsModal">Close</button>
                </div>
                <div class="panel-body">
                    <div class="panel">
                        <div class="panel-heading text-center">
                            <h3 class="col-xs-12">
                                แบบแสดงรายการ ปริมาณงานและราคา
                            </h3>
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
                            <div class="row">
                                <div class="col-xs-12">
                                    <a href="#" class="pull-right btn btn-primary">
                                        เพิ่มแผ่นงาน ปร.4 <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Loop by Page --}}
                    <template v-for="child_job in child_jobs">
                        {{-- Polor 4 Page--}}
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    แบบ ปร.4 แผ่นที่ @{{ child_job.page }} / @{{ child_job.total_page }}
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
                                            <div class="btn-group">
                                                <a @click="showAddChildJobModal(child_job.page)" class="btn btn-success">
                                                    เพิ่มกลุ่มงาน <i class="fa fa-plus"></i>
                                                </a>
                                                <a @click="showAddChildJobItemModal" class="btn btn-info">
                                                    เพิ่มรายการวัสดุอุปกรณ์ <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Types Table--}}
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered">
                                        {{-- -- Table Header--}}
                                        <thead>
                                        <tr class="table-header-green">
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
                                        {{-- -- Table Content--}}
                                        <tbody>
                                        <template v-for="job in child_job.jobs">
                                            <tr class="text-right">
                                                <td class="text-center">@{{ job.job_order_number }}</td>
                                                <td class="text-left">
                                                    @{{ job.name }}
                                                    {{--<span class="pull-right">--}}
                                                        {{--<a v-if="job.descendants.length == 0"--}}
                                                           {{--@click="showAddChildJobItemModal(job)" class="btn btn-info">--}}
                                                            {{--เพิ่มรายการสิ่งของ--}}
                                                            {{--<i class="fa fa-plus"></i>--}}
                                                        {{--</a>--}}
                                                    {{--</span>--}}
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
                                            {{--If เป็นกลุ่มของรายการ--}}
                                            <template></template>
                                            {{--รายการสรุปผลรวมของกลุ่มย่อย--}}
                                            <template v-if="job.quantity_factor > 0">
                                                {{-- .1 คิดต่อ 1 หน่วย--}}
                                                <tr class="text-right">
                                                    <td class="text-center">@{{ job.job_order_number }}.1</td>
                                                    <td class="text-left"> @{{ job.name_per_unit }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                {{--รายการวัสดุ/งาน ต่อ 1 หน่วย .1--}}
                                                <template v-if="job.items.length > 0">
                                                    <tr class="text-right" v-for="(item,index) of job.items">
                                                        <td class="text-center">@{{ job.job_order_number}}.1.@{{ index+1 }}</td>
                                                        <td class="text-left"> @{{ item.details.approved_global_details.name }}</td>
                                                        <td >@{{ item.quantity }}</td>
                                                        <td class="text-center">@{{ item.unit }}</td>
                                                        <td>@{{ item.local_price }}</td>
                                                        <td>@{{ item.total_price }}</td>
                                                        <td>@{{ item.local_wage }}</td>
                                                        <td>@{{ item.total_wage }}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </template>
                                                {{-- รวมราคา ต่อ 1 หน่วย--}}
                                                <tr class="text-right">
                                                    <td class="text-center"></td>
                                                    <td class="text-left">รวมราคา @{{ job.name_per_unit }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>@{{ job.sum_total_price }}</td>
                                                    <td></td>
                                                    <td>@{{ job.sum_total_wage }}</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                {{-- สรุปราคา ต่อ 1 หน่วย--}}
                                                {{--คือผลรวมที่ปัดเศษลงแล้ว--}}
                                                <tr class="text-right">
                                                    <td class="text-center"></td>
                                                    <td class="text-center"> สรุปราคา @{{ job.name_per_unit }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>@{{ job.round_down_sum_total_price }}</td>
                                                    <td></td>
                                                    <td>@{{ job.round_down_sum_total_wage }}</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                {{-- สรุปราคา ต่อ จำนวนหน่วยที่ระบุ ลงท้ายด้วย .2 --}}
                                                <tr class="text-right">
                                                    <td class="text-left">@{{ job.job_order_number }}.2</td>
                                                    <td class="text-center"> @{{ job.name }}</td>
                                                    <td>@{{ job.quantity_factor }}</td>
                                                    <td class="text-center">@{{ job.unit }}</td>
                                                    <td>@{{ job.round_down_sum_total_price }}</td>
                                                    {{--ผลรวมค่าวัสดุหลังปัดเศษ x จำนวน--}}
                                                    <td>@{{ job.total_leaf_job_local_price }}</td>
                                                    <td>@{{ job.round_down_sum_total_wage }}</td>
                                                    {{--ผลรวมค่าแรงหลังปัดเศษ x จำนวน--}}
                                                    <td>@{{ job.total_leaf_job_local_wage }}</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- END Types Table-->
        </div>
    </div>

</modal>