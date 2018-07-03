<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                      Contents
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รายการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <app-table
                    :headers="headers"
                    :hasCheckBox="true"
            ></app-table>
        </div>
    </div>
</template>
<script>
    import MyTable from '../../../components/Table.vue';
    export default {
        data(){
            return {
                headers:[]
            }
        },
        created(){
            this.headers=[
                {name:'AAAA'},
                {name:'BBBB'},
                {name:'CCCC'}
            ]
        }
    }
</script>