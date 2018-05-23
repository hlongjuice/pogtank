
// import axios from 'axios';


// var config = {
//     headers: {'X-CSRF-TOKEN':token}
// };
let token =  $('meta[name="csrf-token"]').attr('content');
console.log('Token',token);
new Vue({
    el:'#test-api-index',
    data:{
        token:token,
        itemsThaiData:[],
        urlThaiData:'http://www.ggdemo.com/public/test_api/get_item',
        urlThaiDelete:'http://www.ggdemo.com/public/test_api/delete/10',
        urlThaiDataPut :'http://www.ggdemo.com/public/test_api/update_item/50',
        urlHomePut :'http://ggdemo.thddns.net:2720/pogtank/public/test_api/update_item/50',
        urlHome:'http://ggdemo.thddns.net:2720/pogtank/public/test_api/get_item',
        urlSample:'http://www.ggeverything.com',
        urlPostSample:'http://www.ggeverything.com/post_api.php',
        urlLocalPut:'http://localhost/pogtank/public/test_api/update_item/50',
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
            //
            // //Thai data
            // axios.get(this.urlThaiData)
            //     .then(result=>{
            //         this.itemsThaiData=result.data
            //     }).catch(err=>{
            //     console.log('Error Api From Thaidatahosting Server')
            //     });

            let input = {
                name:'Yo!!'
            };

            axios.get(this.urlSample)
                .then((result)=>{
                console.log('GGEverything Put');
                    console.log(result);
                }).catch(err=>{
                console.log(err)

            });
            // $.post(this.urlPostSample,input,function(data){
            //     console.log('Normal Get');
            //     console.log(data)
            // })

        }
    }
});