!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?e(require("chart.js"),require("moment")):"function"==typeof define&&define.amd?define(["chart.js","moment"],e):e(t.Chart,t.moment)}(this,function(t,e){"use strict";t=t&&t.hasOwnProperty("default")?t.default:t,e=e&&e.hasOwnProperty("default")?e.default:e;const i=t.helpers;i.isArray;function a(t,a){if(i.isNullOrUndef(t))return null;var r=a.options.time,o=function(t,i){var a=i.parser,r=i.parser||i.format;return"function"==typeof a?a(t):"string"==typeof t&&"string"==typeof r?e(t,r):(t instanceof e||(t=e(t)),t.isValid()?t:"function"==typeof r?r(t):t)}(a.getRightValue(t),r);return o.isValid()?(r.round&&o.startOf(r.round),o.valueOf()):null}var r=Number.MIN_SAFE_INTEGER||-9007199254740991,o=Number.MAX_SAFE_INTEGER||9007199254740991,n=t.scaleService.getScaleConstructor("time").extend({determineDataLimits:function(){var t,i,n,l,d,s,c,h=this,u=h.chart,f=h.options.time,g=o,m=r,p=[],b={},x=[];for(t=0,n=(u.data.datasets||[]).length;t<n;++t)if(u.isDatasetVisible(t))for(d=u.data.datasets[t].data,x[t]=[],i=0,l=d.length;i<l;++i)(s=a(d[i][0],h))>(c=a(d[i][1],h))&&([s,c]=[c,s]),g>s&&s&&(g=s),m<c&&c&&(m=c),x[t][i]=[s,c,d[i][2]],b.hasOwnProperty(s)&&(b[s]=!0,p.push(s)),b.hasOwnProperty(c)&&(b[c]=!0,p.push(c));else x[t]=[];p.size&&p.sort(function(t,e){return t-e}),g=a(f.min,h)||g,m=a(f.max,h)||m,g=g===o?+e().startOf("day"):g,m=m===r?+e().endOf("day")+1:m,h.min=Math.min(g,m),h.max=Math.max(g+1,m),h._horizontal=h.isHorizontal(),h._table=[],h._timestamps={data:p,datasets:x,labels:[]}}});t.scaleService.registerScaleType("timeline",n,{position:"bottom",tooltips:{mode:"nearest"},adapters:{},time:{parser:!1,format:!1,unit:!1,round:!1,displayFormat:!1,isoWeekday:!1,minUnit:"millisecond",distribution:"linear",bounds:"data",displayFormats:{millisecond:"h:mm:ss.SSS a",second:"h:mm:ss a",minute:"h:mm a",hour:"hA",day:"MMM D",week:"ll",month:"MMM YYYY",quarter:"[Q]Q - YYYY",year:"YYYY"}},ticks:{autoSkip:!1}}),t.controllers.timeline=t.controllers.bar.extend({getBarBounds:function(t){var e,i,a=t._view;return e=a.x,i=a.x+a.width,{left:e,top:a.y,right:i,bottom:a.y+a.height}},update:function(e){var a=this,r=a.getMeta(),o=a.chart.options;if(o.textPadding||o.minBarWidth||o.showText||o.colorFunction){var n=a.chart.options.elements;n.textPadding=o.textPadding||n.textPadding,n.minBarWidth=o.minBarWidth||n.minBarWidth,n.colorFunction=o.colorFunction||n.colorFunction,n.minBarWidth=o.minBarWidth||n.minBarWidth,!0!==t._tl_depwarn&&(console.log("Timeline Chart: Configuration deprecated. Please check document on Github."),t._tl_depwarn=!0)}i.each(r.data,function(t,i){a.updateElement(t,i,e)},a)},updateElement:function(t,e,a){var r=this,o=r.getMeta(),n=r.getScaleForId(o.xAxisID),l=r.getScaleForId(o.yAxisID),d=r.getDataset(),s=d.data[e],c=t.custom||{},h=r.index,u=r.chart.options.elements||{},f=u.rectangle,g=u.textPadding,m=u.minBarWidth;t._xScale=n,t._yScale=l,t._datasetIndex=r.index,t._index=e;var p=s[2],b=r.getRuler(e),x=n.getPixelForValue(s[0]),y=n.getPixelForValue(s[1]),v=l.getPixelForValue(s,h,h),w=y-x,S=r.calculateBarHeight(b),C=u.colorFunction(p,s,d,e),P=u.showText,k=u.font;k||(k="12px bold Arial");var B=v-S/2;t._model={x:a?x-w:x,y:B,width:Math.max(w,m),height:S,base:x+w,backgroundColor:C.rgbaString(),borderSkipped:c.borderSkipped?c.borderSkipped:f.borderSkipped,borderColor:c.borderColor?c.borderColor:i.getValueAtIndexOrDefault(d.borderColor,e,f.borderColor),borderWidth:c.borderWidth?c.borderWidth:i.getValueAtIndexOrDefault(d.borderWidth,e,f.borderWidth),label:r.chart.data.labels[e],datasetLabel:d.label,text:p,textColor:C.luminosity()>.5?"#000000":"#ffffff"},t.draw=function(){var t=this._chart.ctx,e=this._view,i=t.globalAlpha,a=t.globalCompositeOperation;if(t.fillStyle=e.backgroundColor,t.lineWidth=e.borderWidth,t.globalCompositeOperation="destination-over",t.fillRect(e.x,e.y,e.width,e.height),t.globalAlpha=.5,t.globalCompositeOperation="source-over",t.fillRect(e.x,e.y,e.width,e.height),t.globalAlpha=i,t.globalCompositeOperation=a,P){t.beginPath();var r=t.measureText(e.text);r.width>0&&r.width+g+2<e.width&&(t.font=k,t.fillStyle=e.textColor,t.lineWidth=0,t.strokeStyle=e.textColor,t.textBaseline="middle",t.fillText(e.text,e.x+g,e.y+e.height/2)),t.fill()}},t.inXRange=function(t){var e=r.getBarBounds(this);return t>=e.left&&t<=e.right},t.tooltipPosition=function(){var t=this.getCenterPoint();return{x:t.x,y:t.y}},t.getCenterPoint=function(){var t=this._view;return{x:t.x+t.width/2,y:t.y+t.height/2}},t.inRange=function(t,e){var i=!1;if(this._view){var a=r.getBarBounds(this);i=t>=a.left&&t<=a.right&&e>=a.top&&e<=a.bottom}return i},t.pivot()},getBarCount:function(){var t=this,e=0;return i.each(t.chart.data.datasets,function(i,a){t.chart.getDatasetMeta(a).bar&&t.chart.isDatasetVisible(a)&&++e},t),e},draw:function(t){var e,i,a=t||1,r=this.getMeta().data;for(e=0,i=r.length;e<i;e++)r[e].transition(a).draw()},calculateBarHeight:function(t){var e=this.getScaleForId(this.getMeta().yAxisID);return e.options.barThickness?e.options.barThickness:e.options.stacked?t.categoryHeight:t.barHeight},removeHoverStyle:function(t){},setHoverStyle:function(t){}}),t.defaults.timeline={elements:{colorFunction:function(){return Color("black")},showText:!0,textPadding:4,minBarWidth:1},layout:{padding:{left:0,right:0,top:0,bottom:0}},legend:{display:!1},scales:{xAxes:[{type:"timeline",position:"bottom",distribution:"linear",categoryPercentage:.8,barPercentage:.9,gridLines:{display:!0,drawBorder:!0,drawTicks:!0},ticks:{maxRotation:0},unit:"day"}],yAxes:[{type:"category",position:"left",barThickness:20,categoryPercentage:.8,barPercentage:.9,offset:!0,gridLines:{display:!0,offsetGridLines:!0,drawBorder:!0,drawTicks:!0}}]},tooltips:{callbacks:{title:function(t,e){return e.labels[t[0].datasetIndex]},label:function(t,i){var a=i.datasets[t.datasetIndex].data[t.index];return[a[2],e(a[0]).format("L LTS"),e(a[1]).format("L LTS")]}}}}});