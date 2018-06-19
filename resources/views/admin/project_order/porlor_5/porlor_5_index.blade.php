<modal
        name="porlor-5-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenPorlor5Modal($event)"
        @opened="openedPorlor5Modal"
        @before-close="beforeClosePorlor5Modal"
        width="99%"
        :adaptive="true"
        height="auto"
        :scrollable="true"
>
    <div class="row">
        <loading :show="porlor5.is_loading"></loading>
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="navbar-fixed-top panel-heading">
                    <button class="btn btn-danger" @click="closePorlor5Modal">Close</button>
                </div>
                <div v-if="porlor5.project" class="panel-body">
                    <template v-for="(porlor5_result) in porlor5.project.porlor5">
                        {{--Page Header--}}
                        <div class="panel">
                            <div class="panel-heading text-center">
                                <h4 class="col-xs-12 text-right">
                                    แบบ ปร.5 (@{{ porlor5_result.th_page }})
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
                                                <p>เมื่อวันที่ : @{{ porlor5.project.referee_calculated_date|
                                                    moment('DD/MM/YYYY')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--Porlor 5 Table แบ่งต่อ 1 polor 4 Part--}}
                        {{--<template v-for="(porlor4_part,index) in porlor5.project.porlor4">--}}
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
                                        <template v-for="(porlor4,part_index) in porlor5_result.parts">
                                            {{--ถ้าไม่ใช่หน้าแรก(ก.) และ เป็นรายการแรก ให้แสดงยอดยกมา--}}
                                            {{--ยอดยกมา--}}
                                            <template v-if="porlor5_result.page>1 && part_index==0">
                                                {{--กรณีเป็นหน้า 2 (ข.)--}}
                                                <template v-if="porlor5_result.page == 2">
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right">
                                                            ยอดยกมา ส่วนที่ 1
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </template>
                                                {{--ตั้งแต่หน้า 3 (ค.)--}}
                                                <template v-if="porlor5_result.page > 2">
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right">
                                                            ยอดยกมา ส่วนที่ 1 - @{{ porlor4.position }}
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">@{{porlor4.previous_sum_construction_cost
                                                            |
                                                            currency('')}}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </template>
                                                {{--Part Name--}}
                                            </template>
                                            {{--หัวข้อ Part--}}
                                            <template>
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <h5>
                                                               ส่วนที่ @{{ porlor4.position }} @{{
                                                            porlor4.part.name }}
                                                            <span class="pull-right text-right">
                                                            <span v-if="porlor5_result.page>1 && part_index == 0 ||
                                                            porlor5_result.parts.length >1 && part_index+1==porlor5_result.parts.length ">
                                                                ย้ายหน้า
                                                            </span>
                                                            <span v-if="porlor5_result.page>1 && part_index == 0">
                                                                <a @click="porlor5_moveToPreviousPage(porlor4)"
                                                                   class="btn btn-info btn-sm">
                                                                     <i class="fas fa-arrow-alt-up"></i>
                                                                </a>
                                                            </span>
                                                            <span v-if="porlor5_result.parts.length >1 && part_index+1==porlor5_result.parts.length">
                                                                <a @click="porlor5_moveToNextPage(porlor4)"
                                                                   class="btn btn-info btn-sm">
                                                                   <i class="fas fa-arrow-alt-down"></i>
                                                                </a>
                                                            </span>
                                                        </span>
                                                        </h5>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                            {{--Part Jobs--}}
                                            <template v-for="(root_job,index) in porlor4.root_jobs">
                                                <tr>
                                                    <td class="text-center">@{{ index+1 }}</td>
                                                    <td>@{{ root_job.name }}</td>
                                                    <td class="text-right">@{{ root_job.job_cost | currency('') }}</td>
                                                    {{--Factor F รอสูคตรคำรวน--}}
                                                    <td class="text-center">@{{ root_job.factor_f }}</td>
                                                    {{--ค่างานก่อสร้าง = ต่างานต้นทุน x factor F--}}
                                                    <td class="text-right">@{{ root_job.construction_cost | currency('')}}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                            {{--Sum of Contruction Cost--}}
                                            <template>
                                                <tr>
                                                    <td class="text-right" colspan="4">รวม@{{ porlor4.part.name }}</td>
                                                    {{--ค่างานก่อสร้าง = ต่างานต้นทุน x factor F--}}
                                                    <td class="td-result-green text-right">@{{
                                                        porlor4.sum_construction_cost | currency('') }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </template>
                                            {{--Sum of Page--}}
                                            {{--ถ้าเป็น Part สุดท้ายของหน้า--}}
                                            <template v-if="part_index+1 == porlor5_result.parts.length">
                                                <tr>
                                                    <td class="text-right" colspan="4">รวมส่วนที่ 1 - @{{
                                                        porlor4.position }}
                                                    </td>
                                                    {{--ค่างานก่อสร้าง = ต่างานต้นทุน x factor F--}}
                                                    <td class="td-result-green text-right">@{{
                                                        porlor4.total_sum_construction_cost | currency('') }}
                                                    </td>
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
                    <template v-if="porlor5.project.porlor5.length == 0">
                        <h2>ยังไม่พบข้อมูล</h2>
                        <h3>รอการระบุข้อมูล ปร.4 อย่างน้อย 1 รายการ</h3>
                    </template>
                </div>
            </div>

        </div>
    </div>
</modal>