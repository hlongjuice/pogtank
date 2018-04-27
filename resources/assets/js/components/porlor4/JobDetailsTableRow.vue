<template id="job-tree-nested" v-if="job">
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
        <td class="text-center">@{{  }}</td>
        <td class="text-left">
            @{{ job.name }}
            <span v-if="job.descendants.length < 1">
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
    <job-tree-nested
            v-for="(job,index) in jobs"
            :jobs="job.children"
            :job="job"
    >
    </job-tree-nested>
</template>
