class WebUrl{
    constructor(
        // private url:string
    ){
        // this.url='http://localhost:3000/pogtank/public';
        // this.url='http://localhost/pogtank/public';
        this.url = 'http://www.ggdemo.com';
    }
    getUrl(){
        return this.url;
    }
    getRoute(url){
        return this.url+url;
    }
}
export default WebUrl;