<template>
    <ul class="page-breadcrumb" v-if="$breadcrumbs.length">
        <template v-for="(crumb, key) in $breadcrumbs">
            <template v-if="key+1 < $breadcrumbs.length">
                <li>
                    <router-link active-class="active" :to="{ path: crumb.path }">
                        {{ getBreadcrumb(crumb.meta.breadcrumb) }}
                    </router-link>
                    <i class="fa fa-angle-right"></i>
                </li>
            </template>
            <template v-else>
                <li >
                    {{ getBreadcrumb(crumb.meta.breadcrumb) }}
                </li>
            </template>
        </template>
    </ul>
</template>

<script>
    export default {
    }
</script>
