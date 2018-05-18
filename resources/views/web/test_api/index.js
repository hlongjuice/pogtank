
new Vue({
    el:'#test-api-index',
    data:{
        itemsThaiData:[],
        urlThaiData:'http://www.ggdemo.com/test_api/get_item',
        urlHome:'http://ggdemo.thddns.net:2720/pogtank/public/test_api/get_item',
        itemsHome:[]

    },
    mounted(){
        this.getItems()
    },
    methods:{
        getItems(){
            // axios.get('http://www.ggdemo.com/test_api/get_item')
            //Home Server
            axios.get(this.urlHome)
                .then(result=>{
                    this.itemsHome=result.data
                }).catch(err=>{
                    console.log('Error Api From Home Server')
                });

            //Thai data
            axios.get(this.urlThaiData)
                .then(result=>{
                    this.itemsThaiData=result.data
                }).catch(err=>{
                console.log('Error Api From Thaidatahosting Server')
                })

        }
    }
});