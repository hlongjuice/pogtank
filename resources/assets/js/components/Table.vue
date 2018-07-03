<template>
    <div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <!-- -- -- --Table Header -->
                <thead>
                <tr>
                    <th v-if="hasCheckBox" class="text-center" width="5%">
                        <input type="checkbox">
                    </th>
                    <template v-for="header in headers">
                        <th>{{header.name}}</th>
                    </template>
                </tr>
                </thead>
                <!-- -- -- --Table Body -->
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import Pagination from 'laravel-vue-pagination';
    export default {
        props:{
            hasCheckBox:{
              type:Boolean,
              default:false
            },
            showPage:{
              default:false
            },
            headers:{
                type:Array,
                default:()=>[
                    {name:'Hlong'},
                    {name:'Maiz'}
                ]
            },
            data:[]
        },
        components:{
            'pagination':Pagination
        }
    }
</script>