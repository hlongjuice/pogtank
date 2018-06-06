<modal
        name="porlor-6-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenPorlor6Modal($event)"
        @opened="openedPorlor6Modal"
        @before-close="beforeClosePorlor6Modal"
        width="99%"
        height="auto"
        :scrollable="true"
>
    <div class="row">
        <loading :show="porlor6.is_loading"></loading>
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closePorlor6Modal">Close</button>
                </div>
                <div v-if="porlor6.project" class="panel-body">
                    {{--Page Header--}}
                    <div class="panel">
                        <div class="panel-heading text-center">.
                            {{--Porlor 6 Page--}}
                            <h4 class="col-xs-12 text-right">
                                แบบ ปร.6 แผ่นที่ 1/1
                            </h4>
                            <h3 class="col-xs-12">แบบสรุปราคางานก่อสร้าง</h3>
                            <h3 class="col-xs-12">
                                เทศบาลตำบล@{{ porlor6.project.district.name }}
                                <span class="visible-xs">
                                    <br>
                                </span>
                                อำเภอ@{{ porlor6.project.amphoe.name }}
                                <span class="visible-xs">
                                    <br>
                                </span>
                                จังหวัด@{{ porlor6.project.province.name }}
                            </h3>

                        </div>
                        <div class="panel-body">
                        </div>
                    </div>
                    {{--Porlor 6 Details--}}
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
                                            <p>โครงการ @{{ porlor6.project.project_name }}</p>
                                        </div>
                                    </div>
                                    {{--Address--}}
                                    <div class="row">
                                        <div v-if="porlor6.project.province" class="col-md-12">
                                            <p>สถานที่ก่อสร้าง : @{{ porlor6.project.location }}
                                                @{{porlor6.project.district.name}}
                                                @{{ porlor6.project.amphoe.name }}
                                                @{{ porlor6.project.province.name }}
                                            </p>
                                        </div>
                                    </div>
                                    {{--Form Number and Form Number Release--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>แบบเลขที่ : @{{ porlor6.project.form_number }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>ออกเมื่อวันที่ : @{{ porlor6.project.form_number_release |
                                                moment('DD/MM/YYYY')}}</p>
                                        </div>
                                    </div>
                                    {{--Owner and Agency--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>หน่วยงานเจ้าของโครงการ :@{{ porlor6.project.owner_name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>หน่วยงานประมาณการ : @{{ porlor6.project.agency_name }}</p>
                                        </div>
                                    </div>
                                    {{--Referee and Upadted at--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>คำนวนราคากลางโดย : @{{ porlor6.project.referee_name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>เมื่อวันที่ : @{{ porlor6.project.updated_at|
                                                moment('DD/MM/YYYY')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Porlor 6 Table  --}}
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
                                        <th width="7%" class="text-center">ลำดับที่</th>
                                        <th width="50%" class="text-center" >รายการ</th>
                                        <th class="text-center" >ค่าก่อสรา้ง</th>
                                        <th  width="15%" class="text-center">หมายเหตุ</th>
                                    </tr>
                                    </thead>
                                    {{-- -- Table Content --}}
                                    <tbody>
                                        <tr>
                                            <td class="text-center" >1</td>
                                            <td>@{{ porlor6.project.project_name }}</td>
                                            <td class="text-right">@{{ porlor6.project.porlor6.construction_cost | currency('') }}</td>
                                            <td></td>
                                        </tr>
                                        <tr v-for="blank_row in porlor6.blank_rows">
                                            <td ><span style="visibility: hidden">5</span></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        {{--Result--}}
                                        <tr>
                                            <td class="text-center" rowspan="3">สรุป</td>
                                            <td class="text-center">รวมค่าก่อสร้าง</td>
                                            <td class="text-right">@{{ porlor6.project.porlor6.construction_cost | currency('') }}</td>
                                            <td></td>
                                        </tr>
                                        {{--Result Round Down--}}
                                        <tr>
                                            <td class="td-result-green text-center">ราคากลาง</td>
                                            <td class="td-result-green text-right">@{{ porlor6.project.porlor6.round_down_construction_cost | currency('') }}</td>
                                            <td></td>
                                        </tr>  {{--Result Round Down Text--}}
                                        <tr>
                                            <td class="text-center">ราคากลาง(ตัวอักษร)</td>
                                            <td colspan="2" class="text-center">@{{ porlor6.project.porlor6.round_down_construction_cost_text }}</td>
                                        </tr>
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