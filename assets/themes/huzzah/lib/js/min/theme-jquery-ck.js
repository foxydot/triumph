function strripos(s,t,i){s=(s+"").toLowerCase(),t=(t+"").toLowerCase();var a=-1;return i?(a=(s+"").slice(i).lastIndexOf(t),-1!==a&&(a+=i)):a=(s+"").lastIndexOf(t),a>=0?a:!1}jQuery(document).ready(function(s){s("*:first-child").addClass("first-child"),s("*:last-child").addClass("last-child"),s("*:nth-child(even)").addClass("even"),s("*:nth-child(odd)").addClass("odd");var t=s("#footer-widgets div.widget").length;s("#footer-widgets").addClass("cols-"+t),s(".ftr-menu ul.menu>li").after(function(){return!s(this).hasClass("last-child")&&s(this).hasClass("menu-item")&&"none"!=s(this).css("display")?'<li class="separator">|</li>':void 0}),s(".nav-secondary .wrap li.menu-item > a").prepend('<span class="fa-stack">   <i class="fa fa-circle fa-stack-2x"></i>   <i class="fa fa-chevron-up fa-stack-1x fa-inverse"></i> </span>');var i=Array("triumph.adv","triumph.msdlab3.com","triumphsigns.com","www.triumphsigns.com","triumphsigns.org","www.triumphsigns.org","triumphsigns.net","www.triumphsigns.net","triumphsigns.biz","www.triumphsigns.biz","triumphsigns.info","www.triumphsigns.info");s("a").attr("target",function(){var t=s(this).attr("href"),a=s(this).attr("target");if("#"==t||strripos(t,"http",0)===!1)return"_self";for(var r=0;i[r];){if(strripos(t,i[r],0))return a;r++}return"_blank"})});