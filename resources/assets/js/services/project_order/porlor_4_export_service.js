import WebUrl from '../webUrl';
let webUrl=new WebUrl();
class Porlor4Service{
    constructor(){
        this.url=webUrl.getUrl();
        this._delete_method={
            _method:'DELETE'
        };
    }

    //Excel
    // -- Export Single Job
    exportExcelByRootID(porlor4_id,root_job_id){
        let url = this.url+'/project/export/porlor4/excel/'+porlor4_id+'/job/'+root_job_id;
        window.open(url); //Open New Tab
    }
}export default Porlor4Service;