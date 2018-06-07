import WebUrl from '../webUrl';
let webUrl = new WebUrl();
class RefereeService {
    constructor() {
        this.url = webUrl.getUrl();
        this._delete_method = {
            _method: 'DELETE'
        };
    }
    //Add New Referee
    addReferee(dataInput) {
        let url = this.url + '/admin/referee/add_referee';
        return new Promise((resolve, reject) => {
            axios.post(url, dataInput)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }
    //Get All Referee
    getReferees(){
        let url = this.url + '/admin/referee/get_referees';
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }
    //Update Referee
    updateReferee(referee_id,dataInput){
        dataInput._method='PUT';
        let url = this.url + '/admin/referee/update_referee/'+referee_id;
        return new Promise((resolve, reject) => {
            axios.post(url, dataInput)
                .then(result => {
                    resolve(result.data)
                }).catch(err => {
                reject(err)
            })
        })
    }
}

export default RefereeService;