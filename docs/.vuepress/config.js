let componentPath = '/vuejs/components/';
module.exports = {
    themeConfig: {
        sidebar: [
            ['', 'Home'],
            {
                title: 'Components',
                children: [
                   'Table','Breadcrumbs'//Page Name
                ].map(item=>{return componentPath+item})
            }
        ]
    }
}