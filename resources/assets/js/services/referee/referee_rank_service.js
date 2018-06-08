import WebUrl from '../webUrl';
let webUrl = new WebUrl();
class RefereeRankService {
    constructor() {
        this.url = webUrl.getUrl();
        this._delete_method = {
            _method: 'DELETE'
        };
    }
    //Add New Referee
    addRefereeRanks(dataInput) {
        let url = this.url + '/admin/referee_rank/add_referee_rank';
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
    getRefereeRanks(){
        let url = this.url + '/admin/referee_rank/get_referee_ranks';
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
    updateRank(referee_id,dataInput){
        dataInput._method='PUT';
        let url = this.url + '/admin/referee_rank/update_referee_rank/'+referee_id;
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

export default RefereeRankService;