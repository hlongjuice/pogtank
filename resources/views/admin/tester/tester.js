import testVue from "./tester.vue";
new Vue({
    el:'#test2',
    data:{
        test:'hhhhh'
    },
    components:{
        'test':{
            data:function(){
                return {
                    myText:'HelloWorld'
                };
            },
            template:'<div>Yo!! @{{myText}}</div>'
        }
    }
})