!function(){angular.module("shortcodeApp",[]).controller("shortcodeController",["$scope",function(o){var e;o.form={selectCheckbox:!1,selectedLocations:"",loading:!0,locations:[],viewType:"",title:"",shortcode:"",viewTypes:[{name:"Front Page",value:"front"},{name:"Location Page",value:"location"},{name:"All Locations Page",value:"all"},{name:"Climbing Page",value:"climbing"}]},o.init=function(t){var n=angular.fromJson(t);e=n.shortcodeName,o.form.locations=n.hours,o.form.loading=!1},o.createShortcode=function(){var t=[];if(angular.forEach(o.form.selectedLocations,function(o){t.push(o)}),o.form.shortcode="","all"==o.form.viewType)o.form.shortcode="["+e+' locations="all"]';else if("location"==o.form.viewType){var n=o.form.title?o.form.title:"Weekly Hours";o.form.shortcode="["+e+' locations="'+t+'" view="location" title="'+n+'"]'}else t.length>0&&""!==o.form.viewType&&(o.form.shortcode="["+e+' locations="'+t+'" view="'+o.form.viewType+'"]')}}]).directive("selectOnClick",function(){return{restrict:"A",link:function(o,e){e.on("click",function(){this.select()})}}})}();
//# sourceMappingURL=../app/maps/shortcode-f218d3ea.js.map