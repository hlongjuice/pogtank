import WebUrl from './webUrl';
let webUrl = new WebUrl();
export const Auth={
    methods:{
        login(){
            window.location=webUrl.getRoute('/login');
        }
    }
};