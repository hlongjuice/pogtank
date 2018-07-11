# Table
## Events

|name|description|
|---|---|
|checkedItems|Get Checked items|
## Props

|name|Type|default|description|
|:---:|---|:---:|---|
|columns|Type : Array|[]|หัวตาราง,exam ['A','B','C']|
|columnWidth|Type : String|[]|Custom Column Width,example [10,20,30]  |
|columnClass|Type : String|table-row-th-center|ขนาด Column |
|colSpan|Type : String|''|Add ColSpan For Column |
|customHeaderColumn|Type : Boolean |false|If True Use Custom Column instead of default Column|
|items|Type : Array,Object|[]|สำหรับระบุรายการ|
|itemRowClass|Type : String|''|Add Custom Class For Item Row|
|hasCheckBox|Type : Boolean|'false'|Add checkbox to Table|
|rowSpan|Type : Boolean|'false'|Add rowspan to Column|
|showPage|Type : Boolean|'false'|Show Table Page|

## Slots
|name|props|description|
|---|:---:|---|
|customHeaderColumn|-|Use For Set Your Own Header Column `Require Props:CustomHeaderColumn = true` |
|itemColumn|`item`,`index`| use `<td>` Tag to display your items list  |