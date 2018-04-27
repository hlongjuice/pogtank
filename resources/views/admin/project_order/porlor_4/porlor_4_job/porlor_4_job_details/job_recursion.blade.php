<template id="tree-menu">
    <div class="tree-menu">
        <div class="label-wrapper" @click="toggleChildren">
            <div>
                <i v-if="nodes" class="fa" :class="iconClasses"></i>
                {{ label }}
            </div>
        </div>
        <tree-menu
                v-if="showChildren"
                v-for="node in nodes"
                :nodes="node.nodes"
                :label="node.label"
                :depth="depth + 1"
        >
        </tree-menu>
    </div>
</template>
<script>
    Vue.component('job-tree',{
        
    })
</script>