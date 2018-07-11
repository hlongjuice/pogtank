<template>
    <ul class="page-breadcrumb" v-if="$breadcrumbs.length">
        <template v-for="(crumb, key) in $breadcrumbs">
            <template v-if="key+1 < $breadcrumbs.length">
                <li>
                    <router-link class="breadcrumb-item"  :to="linkProp(crumb)" :key="key">{{ crumb | crumbText }}</router-link>
                    <i class="fa fa-angle-right"></i>
                </li>
            </template>
            <template v-else>
                <li >
                    {{crumb | crumbText}}
                </li>
            </template>
        </template>
    </ul>
</template>

<script>
    export default {
    }
</script>
