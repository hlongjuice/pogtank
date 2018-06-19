import WebUrl from '../../webUrl';
let webUrl=new WebUrl();
class Porlor5ExportService {
    constructor() {
        this.url = webUrl.getUrl();
        this._put_method ={
            _method:'PUT'
        }
    }
    exportExcel(project_order_id){
        let url = this.url+'/project/export/porlor5/'+project_order_id;
        window.open(url);
    }
} export default Porlor5ExportService