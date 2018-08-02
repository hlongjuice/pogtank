import WebUrl from '../webUrl';
let webUrl = new WebUrl();
export class UserService{
    constructor() {
        this.url = webUrl.getUrl();
    }

    //User
    getUser() {
        let url = this.url + '/admin/user';
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }


}