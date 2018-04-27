<template>
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
                </div>
            </div>
            <!--Types Table-->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                   <!--Table Header-->
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
                   <!--Table Content แยกตามกลุ่มงานใน 1 หน้า-->
                    <tbody>
                    <job-tree-nested v-if="child_jobs_v2"
                                     :jobs="child_jobs_v2.data"
                    ></job-tree-nested>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>

</script>