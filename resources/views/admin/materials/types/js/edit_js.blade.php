<script>
    var oldType=JSON.parse('{!!$oldType!!}');
    console.log(oldType);
    var vm=new Vue({
       el:'#app',
        data:{
            parentTypes:JSON.parse('{!!$parentTypes!!}'),
            form:{
                name:oldType.name,
                type:{
                    id:oldType.parent_id,
                    name:oldType.ancestors[0].name
                },
                details:oldType.details
            }
        },
        computed:{
            parentTypeID:function(){
                return this.form.type.id;
            }
        }
    });
</script>