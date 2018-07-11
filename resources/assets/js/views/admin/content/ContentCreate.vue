<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        Create New Item
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6">
                            <router-link class="btn btn-default" :to="{name:'contents'}">ย้อนกลับ</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ContentCreate"
    }
</script>