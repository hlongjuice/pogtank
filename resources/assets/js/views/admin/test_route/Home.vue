<template>
    <div>
        <router-link  to="/test_route/1">A</router-link>
        <router-link  to="/test_route/2">B</router-link>
      {{data}}
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                data: this.$route.params.userId
            }
        },
        beforeRouteUpdate(to, from, next) {
            console.log('Route Update')
            next();
        }
    }
</script>

<style scoped>

</style>