/* Autosize v1.10 */
(function(a){var i="hidden",h="fontFamily fontSize fontWeight fontStyle letterSpacing textTransform wordSpacing textIndent".split(" "),c=a('<textarea tabindex="-1" style="position:absolute; top:-9999px; left:-9999px; right:auto; bottom:auto; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden">')[0];c.setAttribute("oninput","return");a.isFunction(c.oninput)||"onpropertychange"in c?
(a(c).css("lineHeight","99px"),"99px"===a(c).css("lineHeight")&&h.push("lineHeight"),a.fn.autosize=function(c){return this.each(function(){function f(){var a,c;j||(j=!0,e.value=d.value,e.style.overflowY=d.style.overflowY,e.style.width=b.css("width"),e.scrollTop=0,e.scrollTop=9E4,a=e.scrollTop,c=i,a>g?(a=g,c="scroll"):a<l&&(a=l),d.style.overflowY=c,d.style.height=a+m+"px",setTimeout(function(){j=false},1))}var d=this,b=a(d),e,l=b.height(),g=parseInt(b.css("maxHeight"),10),j,k=h.length,n,m=0;if("border-box"===
b.css("box-sizing")||"border-box"===b.css("-moz-box-sizing")||"border-box"===b.css("-webkit-box-sizing"))m=b.outerHeight()-b.height();if(!b.data("mirror")&&!b.data("ismirror")){e=a('<textarea tabindex="-1" style="position:absolute; top:-9999px; left:-9999px; right:auto; bottom:auto; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden">').data("ismirror",!0).addClass(c||"autosizejs")[0];
n="none"===b.css("resize")?"none":"horizontal";b.data("mirror",a(e)).css({overflow:i,overflowY:i,wordWrap:"break-word",resize:n});for(g=g&&0<g?g:9E4;k--;)e.style[h[k]]=b.css(h[k]);a("body").append(e);"onpropertychange"in d?"oninput"in d?d.oninput=d.onkeyup=f:d.onpropertychange=f:d.oninput=f;a(window).resize(f);b.bind("autosize",f);f()}})}):a.fn.autosize=function(){return this}})(jQuery);

/* Infinite Scroll v2.0b2.120519 */
(function(h,d,e){d.infinitescroll=function(a,c,b){this.element=d(b);this._create(a,c)||(this.failed=!0)};d.infinitescroll.defaults={loading:{finished:e,finishedMsg:"<em>Congratulations, you've reached the end of the internet.</em>",img:"http://www.infinite-scroll.com/loading.gif",msg:null,msgText:"<em>Loading the next set of posts...</em>",selector:null,speed:"fast",start:e},state:{isDuringAjax:!1,isInvalidPage:!1,isDestroyed:!1,isDone:!1,isPaused:!1,currPage:1},callback:e,debug:!1,behavior:e,binder:d(h),
nextSelector:"div.navigation a:first",navSelector:"div.navigation",contentSelector:null,extraScrollPx:150,itemSelector:"div.post",animate:!1,pathParse:e,dataType:"html",appendCallback:!0,bufferPx:40,errorCallback:function(){},infid:0,pixelsFromNavToBottom:e,path:e};d.infinitescroll.prototype={_binding:function(a){var c=this,b=c.options;b.v="2.0b2.111027";if(b.behavior&&this["_binding_"+b.behavior]!==e)this["_binding_"+b.behavior].call(this);else{if("bind"!==a&&"unbind"!==a)return this._debug("Binding value  "+
a+" not valid"),!1;if("unbind"==a)this.options.binder.unbind("smartscroll.infscr."+c.options.infid);else this.options.binder[a]("smartscroll.infscr."+c.options.infid,function(){c.scroll()});this._debug("Binding",a)}},_create:function(a,c){var b=d.extend(!0,{},d.infinitescroll.defaults,a);if(!this._validate(a))return!1;this.options=b;var g=d(b.nextSelector).attr("href");if(!g)return this._debug("Navigation selector not found"),!1;b.path=this._determinepath(g);b.contentSelector=b.contentSelector||this.element;
b.loading.selector=b.loading.selector||b.contentSelector;b.loading.msg=d('<div id="infscr-loading"><img alt="Loading..." src="'+b.loading.img+'" /><div>'+b.loading.msgText+"</div></div>");(new Image).src=b.loading.img;b.pixelsFromNavToBottom=d(document).height()-d(b.navSelector).offset().top;b.loading.start=b.loading.start||function(){d(b.navSelector).hide();b.loading.msg.appendTo(b.loading.selector).show(b.loading.speed,function(){beginAjax(b)})};b.loading.finished=b.loading.finished||function(){b.loading.msg.fadeOut("normal")};
b.callback=function(a,g){b.behavior&&a["_callback_"+b.behavior]!==e&&a["_callback_"+b.behavior].call(d(b.contentSelector)[0],g);c&&c.call(d(b.contentSelector)[0],g,b)};this._setup();return!0},_debug:function(){if(this.options&&this.options.debug)return h.console&&console.log.call(console,arguments)},_determinepath:function(a){var c=this.options;if(c.behavior&&this["_determinepath_"+c.behavior]!==e)this["_determinepath_"+c.behavior].call(this,a);else{if(c.pathParse)return this._debug("pathParse manual"),
c.pathParse(a,this.options.state.currPage+1);if(a.match(/^(.*?)\b2\b(.*?$)/))a=a.match(/^(.*?)\b2\b(.*?$)/).slice(1);else if(a.match(/^(.*?)2(.*?$)/)){if(a.match(/^(.*?page=)2(\/.*|$)/))return a=a.match(/^(.*?page=)2(\/.*|$)/).slice(1);a=a.match(/^(.*?)2(.*?$)/).slice(1)}else{if(a.match(/^(.*?page=)1(\/.*|$)/))return a=a.match(/^(.*?page=)1(\/.*|$)/).slice(1);this._debug("Sorry, we couldn't parse your Next (Previous Posts) URL. Verify your the css selector points to the correct A tag. If you still get this error: yell, scream, and kindly ask for help at infinite-scroll.com.");
c.state.isInvalidPage=!0}this._debug("determinePath",a);return a}},_error:function(a){var c=this.options;c.behavior&&this["_error_"+c.behavior]!==e?this["_error_"+c.behavior].call(this,a):("destroy"!==a&&"end"!==a&&(a="unknown"),this._debug("Error",a),"end"==a&&this._showdonemsg(),c.state.isDone=!0,c.state.currPage=1,c.state.isPaused=!1,this._binding("unbind"))},_loadcallback:function(a,c){var b=this.options,g=this.options.callback,f=b.state.isDone?"done":!b.appendCallback?"no-append":"append";if(b.behavior&&
this["_loadcallback_"+b.behavior]!==e)this["_loadcallback_"+b.behavior].call(this,a,c);else{switch(f){case "done":return this._showdonemsg(),!1;case "no-append":"html"==b.dataType&&(c=d("<div>"+c+"</div>").find(b.itemSelector));break;case "append":var i=a.children();if(0==i.length)return this._error("end");for(f=document.createDocumentFragment();a[0].firstChild;)f.appendChild(a[0].firstChild);this._debug("contentSelector",d(b.contentSelector)[0]);d(b.contentSelector)[0].appendChild(f);c=i.get()}b.loading.finished.call(d(b.contentSelector)[0],
b);b.animate&&(f=d(h).scrollTop()+d("#infscr-loading").height()+b.extraScrollPx+"px",d("html,body").animate({scrollTop:f},800,function(){b.state.isDuringAjax=!1}));b.animate||(b.state.isDuringAjax=!1);g(this,c)}},_nearbottom:function(){var a=this.options,c=0+d(document).height()-a.binder.scrollTop()-d(h).height();if(a.behavior&&this["_nearbottom_"+a.behavior]!==e)return this["_nearbottom_"+a.behavior].call(this);this._debug("math:",c,a.pixelsFromNavToBottom);return c-a.bufferPx<a.pixelsFromNavToBottom},
_pausing:function(a){var c=this.options;if(c.behavior&&this["_pausing_"+c.behavior]!==e)this["_pausing_"+c.behavior].call(this,a);else{"pause"!==a&&("resume"!==a&&null!==a)&&this._debug("Invalid argument. Toggling pause value instead");switch(a&&("pause"==a||"resume"==a)?a:"toggle"){case "pause":c.state.isPaused=!0;break;case "resume":c.state.isPaused=!1;break;case "toggle":c.state.isPaused=!c.state.isPaused}this._debug("Paused",c.state.isPaused);return!1}},_setup:function(){var a=this.options;if(a.behavior&&
this["_setup_"+a.behavior]!==e)this["_setup_"+a.behavior].call(this);else return this._binding("bind"),!1},_showdonemsg:function(){var a=this.options;a.behavior&&this["_showdonemsg_"+a.behavior]!==e?this["_showdonemsg_"+a.behavior].call(this):(a.loading.msg.find("img").hide().parent().find("div").html(a.loading.finishedMsg).animate({opacity:1},2E3,function(){d(this).parent().fadeOut("normal")}),a.errorCallback.call(d(a.contentSelector)[0],"done"))},_validate:function(a){for(var c in a)if(c.indexOf&&
-1<c.indexOf("Selector")&&0===d(a[c]).length)return this._debug("Your "+c+" found no elements."),!1;return!0},bind:function(){this._binding("bind")},destroy:function(){this.options.state.isDestroyed=!0;return this._error("destroy")},pause:function(){this._pausing("pause")},resume:function(){this._pausing("resume")},retrieve:function(a){var c=this,b=c.options,g=b.path,f,i,j,h,a=a||null;beginAjax=function(a){a.state.currPage++;c._debug("heading into ajax",g);f=d(a.contentSelector).is("table")?d("<tbody/>"):
d("<div/>");i=g.join(a.state.currPage);j="html"==a.dataType||"json"==a.dataType?a.dataType:"html+callback";a.appendCallback&&"html"==a.dataType&&(j+="+callback");switch(j){case "html+callback":c._debug("Using HTML via .load() method");f.load(i+" "+a.itemSelector,null,function(a){c._loadcallback(f,a)});break;case "html":c._debug("Using "+j.toUpperCase()+" via $.ajax() method");d.ajax({url:i,dataType:a.dataType,complete:function(a,b){(h="undefined"!==typeof a.isResolved?a.isResolved():"success"===b||
"notmodified"===b)?c._loadcallback(f,a.responseText):c._error("end")}});break;case "json":c._debug("Using "+j.toUpperCase()+" via $.ajax() method"),d.ajax({dataType:"json",type:"GET",url:i,success:function(b,d,g){h="undefined"!==typeof g.isResolved?g.isResolved():"success"===d||"notmodified"===d;a.appendCallback?a.template!=e?(b=a.template(b),f.append(b),h?c._loadcallback(f,b):c._error("end")):(c._debug("template must be defined."),c._error("end")):h?c._loadcallback(f,b):c._error("end")},error:function(){c._debug("JSON ajax request failed.");
c._error("end")}})}};if(b.behavior&&this["retrieve_"+b.behavior]!==e)this["retrieve_"+b.behavior].call(this,a);else{if(b.state.isDestroyed)return this._debug("Instance is destroyed"),!1;b.state.isDuringAjax=!0;b.loading.start.call(d(b.contentSelector)[0],b)}},scroll:function(){var a=this.options,c=a.state;a.behavior&&this["scroll_"+a.behavior]!==e?this["scroll_"+a.behavior].call(this):!c.isDuringAjax&&!c.isInvalidPage&&!c.isDone&&!c.isDestroyed&&!c.isPaused&&this._nearbottom()&&this.retrieve()},toggle:function(){this._pausing()},
unbind:function(){this._binding("unbind")},update:function(a){d.isPlainObject(a)&&(this.options=d.extend(!0,this.options,a))}};d.fn.infinitescroll=function(a,c){switch(typeof a){case "string":var b=Array.prototype.slice.call(arguments,1);this.each(function(){var c=d.data(this,"infinitescroll");if(!c||!d.isFunction(c[a])||"_"===a.charAt(0))return!1;c[a].apply(c,b)});break;case "object":this.each(function(){var b=d.data(this,"infinitescroll");b?b.update(a):(b=new d.infinitescroll(a,c,this),b.failed||
d.data(this,"infinitescroll",b))})}return this};var k=d.event,l;k.special.smartscroll={setup:function(){d(this).bind("scroll",k.special.smartscroll.handler)},teardown:function(){d(this).unbind("scroll",k.special.smartscroll.handler)},handler:function(a,c){var b=this,e=arguments;a.type="smartscroll";l&&clearTimeout(l);l=setTimeout(function(){d.event.handle.apply(b,e)},"execAsap"===c?0:100)}};d.fn.smartscroll=function(a){return a?this.bind("smartscroll",a):this.trigger("smartscroll",["execAsap"])}})(window,
jQuery);

/* Lightbox v2.51 */
(function(){var a,j;a=jQuery;j=function(){this.fileLoadingImage="images/loading.gif";this.fileCloseImage="images/close.png";this.resizeDuration=700;this.fadeDuration=500;this.labelImage="Image";this.labelOf="of"};var d=function(a){this.options=a;this.album=[];this.currentImageIndex=void 0;this.init()};d.prototype.init=function(){this.enable();return this.build()};d.prototype.enable=function(){var b=this;return a("body").on("click","a[rel^=lightbox], area[rel^=lightbox]",function(c){b.start(a(c.currentTarget));
return!1})};d.prototype.build=function(){var b,c=this;a("<div>",{id:"lightboxOverlay"}).after(a("<div/>",{id:"lightbox"}).append(a("<div/>",{"class":"lb-outerContainer"}).append(a("<div/>",{"class":"lb-container"}).append(a("<img/>",{"class":"lb-image"}),a("<div/>",{"class":"lb-nav"}).append(a("<a/>",{"class":"lb-prev"}),a("<a/>",{"class":"lb-next"})),a("<div/>",{"class":"lb-loader"}).append(a("<a/>",{"class":"lb-cancel"}).append(a("<img/>",{src:this.options.fileLoadingImage}))))),a("<div/>",{"class":"lb-dataContainer"}).append(a("<div/>",
{"class":"lb-data"}).append(a("<div/>",{"class":"lb-details"}).append(a("<span/>",{"class":"lb-caption"}),a("<span/>",{"class":"lb-number"})),a("<div/>",{"class":"lb-closeContainer"}).append(a("<a/>",{"class":"lb-close"}).append(a("<img/>",{src:this.options.fileCloseImage}))))))).appendTo(a("body"));a("#lightboxOverlay").hide().on("click",function(){c.end();return!1});b=a("#lightbox");b.hide().on("click",function(b){"lightbox"===a(b.target).attr("id")&&c.end();return!1});b.find(".lb-outerContainer").on("click",
function(b){"lightbox"===a(b.target).attr("id")&&c.end();return!1});b.find(".lb-prev").on("click",function(){c.changeImage(c.currentImageIndex-1);return!1});b.find(".lb-next").on("click",function(){c.changeImage(c.currentImageIndex+1);return!1});b.find(".lb-loader, .lb-close").on("click",function(){c.end();return!1})};d.prototype.start=function(b){var c,k,e,d,h;a(window).on("resize",this.sizeOverlay);a("select, object, embed").css({visibility:"hidden"});a("#lightboxOverlay").width(a(document).width()).height(a(document).height()).fadeIn(this.options.fadeDuration);
this.album=[];e=0;if("lightbox"===b.attr("rel"))this.album.push({link:b.attr("href"),title:b.attr("title")});else{h=a(b.prop("tagName")+'[rel="'+b.attr("rel")+'"]');k=0;for(d=h.length;k<d;k++)c=h[k],this.album.push({link:a(c).attr("href"),title:a(c).attr("title")}),a(c).attr("href")===b.attr("href")&&(e=k)}c=a(window);b=c.scrollTop()+c.height()/10;c=c.scrollLeft();a("#lightbox").css({top:b+"px",left:c+"px"}).fadeIn(this.options.fadeDuration);this.changeImage(e)};d.prototype.changeImage=function(b){var c,
d,e,f=this;this.disableKeyboardNav();d=a("#lightbox");c=d.find(".lb-image");this.sizeOverlay();a("#lightboxOverlay").fadeIn(this.options.fadeDuration);a(".loader").fadeIn("slow");d.find(".lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption").hide();d.find(".lb-outerContainer").addClass("animating");e=new Image;e.onload=function(){c.attr("src",f.album[b].link);c.width=e.width;c.height=e.height;return f.sizeContainer(e.width,e.height)};e.src=this.album[b].link;this.currentImageIndex=
b};d.prototype.sizeOverlay=function(){return a("#lightboxOverlay").width(a(document).width()).height(a(document).height())};d.prototype.sizeContainer=function(b,c){var d,e,f,h,j,n,g,i,l,m,o=this;e=a("#lightbox");f=e.find(".lb-outerContainer");m=f.outerWidth();l=f.outerHeight();d=e.find(".lb-container");n=parseInt(d.css("padding-top"),10);j=parseInt(d.css("padding-right"),10);h=parseInt(d.css("padding-bottom"),10);d=parseInt(d.css("padding-left"),10);i=b+d+j;g=c+n+h;i!==m&&g!==l?f.animate({width:i,
height:g},this.options.resizeDuration,"swing"):i!==m?f.animate({width:i},this.options.resizeDuration,"swing"):g!==l&&f.animate({height:g},this.options.resizeDuration,"swing");setTimeout(function(){e.find(".lb-dataContainer").width(i);e.find(".lb-prevLink").height(g);e.find(".lb-nextLink").height(g);o.showImage()},this.options.resizeDuration)};d.prototype.showImage=function(){var b;b=a("#lightbox");b.find(".lb-loader").hide();b.find(".lb-image").fadeIn("slow");this.updateNav();this.updateDetails();
this.preloadNeighboringImages();this.enableKeyboardNav()};d.prototype.updateNav=function(){var b;b=a("#lightbox");b.find(".lb-nav").show();0<this.currentImageIndex&&b.find(".lb-prev").show();this.currentImageIndex<this.album.length-1&&b.find(".lb-next").show()};d.prototype.updateDetails=function(){var b,c=this;b=a("#lightbox");"undefined"!==typeof this.album[this.currentImageIndex].title&&""!==this.album[this.currentImageIndex].title&&b.find(".lb-caption").html(this.album[this.currentImageIndex].title).fadeIn("fast");
1<this.album.length?b.find(".lb-number").html(this.options.labelImage+" "+(this.currentImageIndex+1)+" "+this.options.labelOf+"  "+this.album.length).fadeIn("fast"):b.find(".lb-number").hide();b.find(".lb-outerContainer").removeClass("animating");b.find(".lb-dataContainer").fadeIn(this.resizeDuration,function(){return c.sizeOverlay()})};d.prototype.preloadNeighboringImages=function(){var a;this.album.length>this.currentImageIndex+1&&(a=new Image,a.src=this.album[this.currentImageIndex+1].link);0<
this.currentImageIndex&&(a=new Image,a.src=this.album[this.currentImageIndex-1].link)};d.prototype.enableKeyboardNav=function(){a(document).on("keyup.keyboard",a.proxy(this.keyboardAction,this))};d.prototype.disableKeyboardNav=function(){a(document).off(".keyboard")};d.prototype.keyboardAction=function(a){var c;c=a.keyCode;a=String.fromCharCode(c).toLowerCase();27===c||a.match(/x|o|c/)?this.end():"p"===a||37===c?0!==this.currentImageIndex&&this.changeImage(this.currentImageIndex-1):("n"===a||39===
c)&&this.currentImageIndex!==this.album.length-1&&this.changeImage(this.currentImageIndex+1)};d.prototype.end=function(){this.disableKeyboardNav();a(window).off("resize",this.sizeOverlay);a("#lightbox").fadeOut(this.options.fadeDuration);a("#lightboxOverlay").fadeOut(this.options.fadeDuration);return a("select, object, embed").css({visibility:"visible"})};a(function(){var a;a=new j;return new d(a)})}).call(this);