<script>
    var vm = new Vue({
        el:'#app',
        data:{
            parentTypes:JSON.parse('{!!$parentTypes!!}'),
            form:{
                name:null,
                type:{
                    name:'หมวดหมู่หลัก'
                },
                details:''
            }
        },
        computed:{
            parentTypeID:function(){
                return this.form.type.id;
            }
        }
    });
    console.log(vm.parentTypes);
</script>