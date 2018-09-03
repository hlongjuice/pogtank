import {ContentImageService} from "../services/content/image_upload_service";

let contentImageService = new ContentImageService();
export const tinyMceConfig = {
    height: 400,
    language: 'th_TH',
    //region Plugin
    plugins: [
        "advlist autolink lists link image imagetools charmap  preview anchor",
        "code fullscreen",
        "media table contextmenu paste",
        "textcolor"
    ],
    //endregion
    //region Menu
    menu: {
        // insert: {title: 'Insert', items: 'image link'},
        table: {title: 'Table', items: 'inserttable tableprops deletetable cell row column'}
    },
    //endregion
    //region ToolBar
    toolbar: ["undo redo | fontsizeselect | styleselect| forecolor backcolor | bold underline italic "
    + "| alignleft aligncenter alignright alignjustify |"
    + "bullist numlist outdent indent| code",
        " link | fullscreen"],
        // " link image | fullscreen"],
    //endregion
    //region Async Method After Init TinyMce
    init_instance_callback: function (editor) {
       editor.on('dblclick',(e)=>{
           if(e.target.nodeName === 'IMG'){
               editor.editorCommands.execCommand('mceImage');
           }
       })
    },
    //endregion
    //region Image Config
    //Default Value: "rotateleft rotateright | flipv fliph | editimage imageoptions"
    imagetools_toolbar: "imageoptions", // Tools that show on inline Image
    file_picker_types: 'image',
    images_reuse_filename: true, // Use Original File Name
    images_upload_handler:function(blobInfo, success, failure){
        let formData = new FormData();
        console.log('In side Image Upload Handler:',this);
        // formData.append('file', blobInfo.blob(), blobInfo.filename());
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        contentImageService.uploadImageInContent(formData)
            .then(result=>{
                success(result.location)
            }).catch(err=>{console.log(err)})
    },
    image_title: true
    //endregion
};