<template>
    <div>
        <h3 style="color:#ccc; display: inline-block">กำลังโหลดข้อมูล</h3>
        <hollow-dots-spinner
                :animation-duration="2000"
                :dot-size="10"
                :dots-num="4"
                :color="'#222'"
                style="display: inline-block"
        >
        </hollow-dots-spinner>
    </div>

</template>

<script>
    import {HollowDotsSpinner} from 'epic-spinners';

    export default {
        name: "Spinner",
        components: {HollowDotsSpinner}
    }
</script>

<style scoped>

</style>