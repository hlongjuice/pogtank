# Breadcrumbs
## Configuration
 - install vue-breadcrumb with  `npm install vue-breadcrumb` 
 > import from node_modules
 ``` js
Import VueBreadcrumbs from 'vue-breadcrubms' 
 Vue.use(VueBreadcrumbs,{
     template :'<nav class="breadcrumb" v-if="$breadcrumbs.length"> ' +
               '<router-link class="breadcrumb-item" v-for="(crumb, key) in $breadcrumbs" :to="linkProp(crumb)" :key="key">{{ crumb | crumbText }}</router-link> ' +
               '</nav>'
  });
 ```



