import WebUrl from '../webUrl';
let webUrl = new WebUrl();
class ProjectRefereeService{
    constructor(){
        this.url=webUrl.getUrl();
        this._delete_method={
            _method:'DELETE'
        };
        this._put_method={
            _method:'PUT'
        }

    }
    //Add New Referee
    addReferees(project_order_id,inputData){
        let url=this.url+'/admin/project_order/referee/add_referees/'+project_order_id;
        return new Promise((resolve,reject)=>{
            axios.post(url,inputData)
                .then(result=>{
                    resolve(result.data)
                }).catch(err=>{reject(err)})
        })
    }
    //Delete Project Referee
    deleteReferee(project_referee_id){

    }
    //Get Referees
    getReferees(project_order_id){
        let url = this.url+'/admin/project_order/referee/get_referees/'+project_order_id;
        return new Promise((resolve,reject)=>{
            axios.get(url)
                .then(result=>{
                    console.log('Result',result);
                    resolve(result.data)
                }).catch(err=>{
                reject(err)
            })
        })
    }

}export default ProjectRefereeService;