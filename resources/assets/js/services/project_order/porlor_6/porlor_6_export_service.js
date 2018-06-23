import WebUrl from '../../webUrl';
let webUrl=new WebUrl();
class Porlor6ExportService {
    constructor() {
        this.url = webUrl.getUrl();
        this._put_method ={
            _method:'PUT'
        }
    }
    //Get Porlor6
    exportExcel(project_order_id){
        let url = this.url+'/project/export/porlor6/excel/'+project_order_id;
        window.open(url);
    }
} export default Porlor6ExportService;