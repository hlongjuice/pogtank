
// import axios from 'axios';


// var config = {
//     headers: {'X-CSRF-TOKEN':token}
// };
new Vue({
    el:'#test-api-index',
    data:{
        itemsThaiData:[],
        urlThaiData:'http://www.ggdemo.com/public/test_api/get_item',
        urlThaiDataPut :'http://www.ggdemo.com/public/test_api/update_item/50',
        urlHomePut :'http://ggdemo.thddns.net:2720/pogtank/public/test_api/update_item/50',
        urlHome:'http://ggdemo.thddns.net:2720/pogtank/public/test_api/get_item',
        urlSample:'http://www.ggeverything.com',
        urlPostSample:'http://www.ggeverything.com/post_api.php',
        itemsHome:[]

    },
    mounted(){

        // axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
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
                });
            //Thai data
            // $.put(this.urlThaiDataPut,function(result){
            //     console.log(result.data);
            //     alert('success')
            // });
            // $.ajax({
            //     type: 'POST', // Use POST with X-HTTP-Method-Override or a straight PUT if appropriate.
            //     url: this.urlHomePut, // A valid URL
            //     headers: {"X-HTTP-Method-Override": "PUT"}, // X-HTTP-Method-Override set to PUT
            //     success:function(data){
            //         console.log(data)
            //     }
            // });
            axios.post(this.urlPostSample)
                .then(result=>{
                    console.log(result.data)
                }).catch(err=>{alert(err)});
            $.post(this.urlPostSample,function(result){
                console.log('Result',result)
            });
            axios.post(this.urlThaiDataPut,{_method:'PUT'})
                .then(()=>{

                }).catch(err=>{
                    console.log(err)
            })



        }
    }
});