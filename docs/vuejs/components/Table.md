# Table
## Events
|name|return param|description|
|---|---|---|
|checkedItemsList|`checkedItems`|Selected Items|
|deleteItems|`checkedItems`|Delete Selected Items|
## Props

|name|Type|default|description|
|:---:|---|:---:|---|
|columns|Type : Array|`[]`|หัวตาราง,exam ['A','B','C']|
|columnWidth|Type : String|`[]`|Custom Column Width,example [10,20,30]  |
|columnClass|Type : String|`table-row-th-center`|ขนาด Column |
|colSpan|Type : String|`-`|Add ColSpan For Column |
|customHeaderColumn|Type : Boolean |`false`|If True Use Custom Column instead of default Column|
|checkedItemsInit|Type : Array |`[]`|Use to set Array of checkedItems|
|categories|Type : Array |`[]`|Array สำหรับหมวดหมู่ที่ใช้คัดกรอง|
|items|Type : Array,Object|`[]`|สำหรับระบุรายการ|
|itemRowClass|Type : String|`-`|Add Custom Class For Item Row|
|hasCheckBox|Type : Boolean|`false`|Add checkbox to Table|
|hasDeleteSingleItemBtn|Type : Boolean|`true`|Add Delete Single Item Button|
|hasSearchBox|Type : Boolean|`false`|Search Box|
|hasSearchByCategory|Type : Boolean|`false`|Mutiselect Search By Category|


|rowSpan|Type : Boolean|`false`|Add rowspan to Column|
|showPage|Type : Boolean|`false`|Show Table Page|

## Slots
|name|props|description|
|---|:---:|---|
|customHeaderColumn|`-`|Use For Set Your Own Header Column `Require Props:CustomHeaderColumn = true` |
|customTopBtn|`-`|Use For Set Your Own Btn at above of Table|
|itemColumn|`item`,`index`| use `<td>` Tag to display your items list  |