!function(t){function i(r){if(e[r])return e[r].exports;var a=e[r]={i:r,l:!1,exports:{}};return t[r].call(a.exports,a,a.exports,i),a.l=!0,a.exports}var e={};i.m=t,i.c=e,i.d=function(t,e,r){i.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:r})},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,i){return Object.prototype.hasOwnProperty.call(t,i)},i.p="",i(i.s=48)}({48:function(t,i,e){t.exports=e(49)},49:function(t,i,e){"use strict";var r={custom:{materialName:{required:""}}};new Vue({el:"#app",data:{materialName:"",test:"abc",item:"",materialTypes:[],provinces:[],form:{city:[{province:"",amphoe:"",district:"",amphoes:[],districts:[],localCost:0,localPrice:0,wage:0}],materialName:"",materialUnit:"",materialType:"",materialTypeID:"",globalCost:0,globalPrice:0,invoiceCost:0,invoicePrice:0},displayStatus:[]},created:function(){this.$validator.localize("en",r),this.displayStatus.push(!1)},methods:{validateForm:function(t,i){this.$validator.validateAll(t).then(function(t){if(t)return void alert("All Valid");alert("Invalid"),i.preventDefault()})},addPriceInput:function(){var t={province:"",amphoe:"",district:"",amphoes:[],districts:[]};this.form.city.push(t)},getAmphoes:function(t){this.form.city[t].amphoe="",this.form.city[t].district="",this.form.city[t].amphoes=this.form.city[t].province.amphoes},getDistricts:function(t){this.form.city[t].district="",axios.get("/admin/materials/items/districts/"+this.form.city[t].amphoe.id).then(function(i){vm.$data.form.city[t].districts=i.data})},deleteLocalPrice:function(t){}},watch:{"form.materialType":function(){this.form.materialTypeID=this.form.materialType.id}}})}});