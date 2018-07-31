import ContentImageService from '../services/content/image_upload';
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
        insert: {title: 'Insert', items: 'image link'},
        table: {title: 'Table', items: 'inserttable tableprops deletetable cell row column'}
    },
    //endregion
    //region ToolBar
    toolbar: ["undo redo | styleselect| forecolor backcolor | bold italic "
    + "| alignleft aligncenter alignright alignjustify |"
    + "bullist numlist outdent indent| code",
        " link image | fullscreen"],
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
    images_upload_handler: function (blobInfo, success, failure) {
        let formData = new FormData();
        // formData.append('file', blobInfo.blob(), blobInfo.filename());
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        contentImageService.uploadImage(formData)
            .then(result=>{
                success(result.location)
            }).catch(err=>{console.log(err)})
    },
    image_title: true
    //endregion
};