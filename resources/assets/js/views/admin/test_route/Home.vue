<template>
    <div>
        <router-link :key="AA" :to="{name:'content_category_edit',params:{myID:1}}">AA</router-link>
        <!--<router-link :key="BB" :to="{name:'content_category_edit',params:{myID:2}}">BB</router-link>-->
        <router-link :to="'/content_category/edit/'+2">BB</router-link>
        <router-link :to="'/content_category/edit/'+1">CC</router-link>
        <!--<a @click="goTest(1)">A</a>-->
        <!--<a @click="goTest(2)">B</a>-->
      {{data}}
        {{numb}}
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                data: this.$route.params.userId,
                numb:''
            }
        },
        beforeRouteEnter(to,from,next){
            console.log('Before Route Enter');
            next();
        },
        beforeRouteLeave(to,from,next){
            console.log('Before Route leave');
            next();
        },
        beforeRouteUpdate(to, from, next) {
            console.log('Route Update');
            next();
        },
        methods:{
            goTest(dataInput){
                this.numb=dataInput;
                this.$router.push({name:'content_category_edit',params:{myID:this.numb}})
                // this.$router.push('/test_route/'+number);
            }
        }
    }
</script>

<style scoped>

</style>