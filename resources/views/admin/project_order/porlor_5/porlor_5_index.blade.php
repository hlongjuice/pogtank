<modal
        name="porlor-5-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenPorlor5Modal($event)"
        @opened="openedPorlor5Modal"
        @before-close="beforeClosePorlor5Modal"
        width="99%"
        height="auto"
        :scrollable="true"
>
    <div class="row">
        <loading :show="porlor5.is_loading"></loading>
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closePorlor5Modal">Close</button>
                </div>
                <div  v-if="porlor5.project" class="panel-body">
                    {{--Page Header--}}
                    <div class="panel">
                        <div class="panel-heading text-center">
                            <h4 class="col-xs-12 text-right">
                                แบบ ปร.5 (ก)
                            </h4>
                            <h3 class="col-xs-12">แบบสรุปค่าก่อสร้าง</h3>
                            <h3 class="col-xs-12">
                                เทศบาลตำบล@{{ porlor5.project.district.name }}
                                <span class="visible-xs">
                                    <br>
                                </span>
                                อำเภอ@{{ porlor5.project.amphoe.name }}
                                <span class="visible-xs">
                                    <br>
                                </span>
                                จังหวัด@{{ porlor5.project.province.name }}
                            </h3>

                        </div>
                        <div class="panel-body">
                        </div>
                    </div>
                    {{--Porlor 5 Details--}}
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                {{----}}
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
                                            <p>โครงการ @{{ porlor5.project.project_name }}</p>
                                        </div>
                                    </div>
                                    {{--Address--}}
                                    <div class="row">
                                        <div v-if="porlor5.project.province" class="col-md-12">
                                            <p>สถานที่ก่อสร้าง : @{{ porlor5.project.location }}
                                                @{{porlor5.project.district.name}}
                                                @{{ porlor5.project.amphoe.name }}
                                                @{{ porlor5.project.province.name }}
                                            </p>
                                        </div>
                                    </div>
                                    {{--Form Number and Form Number Release--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>แบบเลขที่ : @{{ porlor5.project.form_number }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>ออกเมื่อวันที่ : @{{ porlor5.project.form_number_release |
                                                moment('DD/MM/YYYY')}}</p>
                                        </div>
                                    </div>
                                    {{--Owner and Agency--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>หน่วยงานเจ้าของโครงการ :@{{ porlor5.project.owner_name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>หน่วยงานประมาณการ : @{{ porlor5.project.agency_name }}</p>
                                        </div>
                                    </div>
                                    {{--Referee and Upadted at--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>คำนวนราคากลางโดย : @{{ porlor5.project.referee_name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>เมื่อวันที่ : @{{  porlor5.project.updated_at| moment('DD/MM/YYYY')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Porlor 5 Table แบ่งต่อ 1 polor 4 Part--}}
                    <template v-for="(porlor4_part,index) in porlor5.project.porlor4">
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
                                            <th width="5%" class="text-center" rowspan="2">ลำดับที่</th>
                                            <th width="40%" class="text-center" rowspan="2">รายการ</th>
                                            <th class="text-center" rowspan="2">ค่างานต้นทุน</th>
                                            <th class="text-center" rowspan="2">Factor F</th>
                                            <th class="text-center" rowspan="2">ค่างานก่อสร้าง</th>
                                            <th class="text-center" rowspan="2">หมายเหตุ</th>
                                        </tr>
                                        </thead>
                                        {{-- -- Table Content --}}
                                        <tbody>
                                            {{--ถ้าไม่ใช่ ส่วนแรก--}}
                                            {{--ยอดยกมา--}}
                                            <template v-if="index > 0">
                                                <tr>
                                                    <td></td>
                                                    <td class="text-right">
                                                        <template v-if="index == 1">
                                                            ยอดยกมา ส่วนที่ 1
                                                        </template>
                                                        <template v-else>
                                                            ยอดยกมา ส่วนที่ 1 - @{{ index }}
                                                        </template>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-right">@{{porlor4_part.previous_sum_construction_cost | currency('')}}</td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                            {{--Part Name--}}
                                            <template>
                                                <tr>
                                                    <td></td>
                                                    <td class="text-center">ส่วนที่ @{{ index+1 }} @{{ porlor4_part.part.name }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                            {{--Part Jobs--}}
                                            <template v-for="(root_job,index) in porlor4_part.root_jobs">
                                                <tr>
                                                    <td class="text-center">@{{ index+1 }}</td>
                                                    <td>@{{ root_job.name }}</td>
                                                    <td class="text-right">@{{ root_job.job_cost | currency('') }}</td>
                                                    {{--Factor F รอสูคตรคำรวน--}}
                                                    <td class="text-center">@{{ root_job.factor_f }}</td>
                                                    {{--ค่างานก่อสร้าง = ต่างานต้นทุน x factor F--}}
                                                    <td class="text-right">@{{ root_job.construction_cost | currency('') }}</td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                            {{--Sum of Contruction Cost--}}
                                            <template>
                                                <tr>
                                                    <td class="text-right" colspan="4">รวม@{{ porlor4_part.part.name }}</td>
                                                    {{--ค่างานก่อสร้าง = ต่างานต้นทุน x factor F--}}
                                                    <td class="td-result-green text-right">@{{ porlor4_part.sum_construction_cost | currency('') }}</td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                            {{--Sum of Part--}}
                                            <template v-if="index >0">
                                                <tr>
                                                    <td class="text-right" colspan="4">รวมส่วนที่ 1 - @{{ index+1 }}</td>
                                                    {{--ค่างานก่อสร้าง = ต่างานต้นทุน x factor F--}}
                                                    <td class="td-result-green text-right">@{{ porlor4_part.total_sum_construction_cost | currency('') }}</td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
</modal>