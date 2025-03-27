/*!
 * perfect-scrollbar v1.5.6
 * Copyright 2024 Hyunje Jun, MDBootstrap and Contributors
 * Licensed under MIT
 */function w(t){return getComputedStyle(t)}function y(t,e){for(var r in e){var o=e[r];typeof o=="number"&&(o=o+"px"),t.style[r]=o}return t}function M(t){var e=document.createElement("div");return e.className=t,e}var D=typeof Element<"u"&&(Element.prototype.matches||Element.prototype.webkitMatchesSelector||Element.prototype.mozMatchesSelector||Element.prototype.msMatchesSelector);function W(t,e){if(!D)throw new Error("No element matching method supported");return D.call(t,e)}function E(t){t.remove?t.remove():t.parentNode&&t.parentNode.removeChild(t)}function x(t,e){return Array.prototype.filter.call(t.children,function(r){return W(r,e)})}var v={main:"ps",rtl:"ps__rtl",element:{thumb:function(t){return"ps__thumb-"+t},rail:function(t){return"ps__rail-"+t},consuming:"ps__child--consume"},state:{focus:"ps--focus",clicking:"ps--clicking",active:function(t){return"ps--active-"+t},scrolling:function(t){return"ps--scrolling-"+t}}},O={x:null,y:null};function I(t,e){var r=t.element.classList,o=v.state.scrolling(e);r.contains(o)?clearTimeout(O[e]):r.add(o)}function K(t,e){O[e]=setTimeout(function(){return t.isAlive&&t.element.classList.remove(v.state.scrolling(e))},t.settings.scrollingThreshold)}function _(t,e){I(t,e),K(t,e)}var R=function(e){this.element=e,this.handlers={}},N={isEmpty:{configurable:!0}};R.prototype.bind=function(e,r){typeof this.handlers[e]>"u"&&(this.handlers[e]=[]),this.handlers[e].push(r),this.element.addEventListener(e,r,!1)};R.prototype.unbind=function(e,r){var o=this;this.handlers[e]=this.handlers[e].filter(function(a){return r&&a!==r?!0:(o.element.removeEventListener(e,a,!1),!1)})};R.prototype.unbindAll=function(){for(var e in this.handlers)this.unbind(e)};N.isEmpty.get=function(){var t=this;return Object.keys(this.handlers).every(function(e){return t.handlers[e].length===0})};Object.defineProperties(R.prototype,N);var H=function(){this.eventElements=[]};H.prototype.eventElement=function(e){var r=this.eventElements.filter(function(o){return o.element===e})[0];return r||(r=new R(e),this.eventElements.push(r)),r};H.prototype.bind=function(e,r,o){this.eventElement(e).bind(r,o)};H.prototype.unbind=function(e,r,o){var a=this.eventElement(e);a.unbind(r,o),a.isEmpty&&this.eventElements.splice(this.eventElements.indexOf(a),1)};H.prototype.unbindAll=function(){this.eventElements.forEach(function(e){return e.unbindAll()}),this.eventElements=[]};H.prototype.once=function(e,r,o){var a=this.eventElement(e),h=function(s){a.unbind(r,h),o(s)};a.bind(r,h)};function A(t){if(typeof window.CustomEvent=="function")return new CustomEvent(t);var e=document.createEvent("CustomEvent");return e.initCustomEvent(t,!1,!1,void 0),e}function C(t,e,r,o,a){o===void 0&&(o=!0),a===void 0&&(a=!1);var h;if(e==="top")h=["contentHeight","containerHeight","scrollTop","y","up","down"];else if(e==="left")h=["contentWidth","containerWidth","scrollLeft","x","left","right"];else throw new Error("A proper axis should be provided");U(t,r,h,o,a)}function U(t,e,r,o,a){var h=r[0],s=r[1],i=r[2],l=r[3],c=r[4],p=r[5];o===void 0&&(o=!0),a===void 0&&(a=!1);var n=t.element;t.reach[l]=null,n[i]<1&&(t.reach[l]="start"),n[i]>t[h]-t[s]-1&&(t.reach[l]="end"),e&&(n.dispatchEvent(A("ps-scroll-"+l)),e<0?n.dispatchEvent(A("ps-scroll-"+c)):e>0&&n.dispatchEvent(A("ps-scroll-"+p)),o&&_(t,l)),t.reach[l]&&(e||a)&&n.dispatchEvent(A("ps-"+l+"-reach-"+t.reach[l]))}function d(t){return parseInt(t,10)||0}function j(t){return W(t,"input,[contenteditable]")||W(t,"select,[contenteditable]")||W(t,"textarea,[contenteditable]")||W(t,"button,[contenteditable]")}function $(t){var e=w(t);return d(e.width)+d(e.paddingLeft)+d(e.paddingRight)+d(e.borderLeftWidth)+d(e.borderRightWidth)}var T={isWebKit:typeof document<"u"&&"WebkitAppearance"in document.documentElement.style,supportsTouch:typeof window<"u"&&("ontouchstart"in window||"maxTouchPoints"in window.navigator&&window.navigator.maxTouchPoints>0||window.DocumentTouch&&document instanceof window.DocumentTouch),supportsIePointer:typeof navigator<"u"&&navigator.msMaxTouchPoints,isChrome:typeof navigator<"u"&&/Chrome/i.test(navigator&&navigator.userAgent)};function X(t){var e=t.element,r=Math.floor(e.scrollTop),o=e.getBoundingClientRect();t.containerWidth=Math.floor(o.width),t.containerHeight=Math.floor(o.height),t.contentWidth=e.scrollWidth,t.contentHeight=e.scrollHeight,e.contains(t.scrollbarXRail)||(x(e,v.element.rail("x")).forEach(function(a){return E(a)}),e.appendChild(t.scrollbarXRail)),e.contains(t.scrollbarYRail)||(x(e,v.element.rail("y")).forEach(function(a){return E(a)}),e.appendChild(t.scrollbarYRail)),!t.settings.suppressScrollX&&t.containerWidth+t.settings.scrollXMarginOffset<t.contentWidth?(t.scrollbarXActive=!0,t.railXWidth=t.containerWidth-t.railXMarginWidth,t.railXRatio=t.containerWidth/t.railXWidth,t.scrollbarXWidth=k(t,d(t.railXWidth*t.containerWidth/t.contentWidth)),t.scrollbarXLeft=d((t.negativeScrollAdjustment+e.scrollLeft)*(t.railXWidth-t.scrollbarXWidth)/(t.contentWidth-t.containerWidth))):t.scrollbarXActive=!1,!t.settings.suppressScrollY&&t.containerHeight+t.settings.scrollYMarginOffset<t.contentHeight?(t.scrollbarYActive=!0,t.railYHeight=t.containerHeight-t.railYMarginHeight,t.railYRatio=t.containerHeight/t.railYHeight,t.scrollbarYHeight=k(t,d(t.railYHeight*t.containerHeight/t.contentHeight)),t.scrollbarYTop=d(r*(t.railYHeight-t.scrollbarYHeight)/(t.contentHeight-t.containerHeight))):t.scrollbarYActive=!1,t.scrollbarXLeft>=t.railXWidth-t.scrollbarXWidth&&(t.scrollbarXLeft=t.railXWidth-t.scrollbarXWidth),t.scrollbarYTop>=t.railYHeight-t.scrollbarYHeight&&(t.scrollbarYTop=t.railYHeight-t.scrollbarYHeight),q(e,t),t.scrollbarXActive?e.classList.add(v.state.active("x")):(e.classList.remove(v.state.active("x")),t.scrollbarXWidth=0,t.scrollbarXLeft=0,e.scrollLeft=t.isRtl===!0?t.contentWidth:0),t.scrollbarYActive?e.classList.add(v.state.active("y")):(e.classList.remove(v.state.active("y")),t.scrollbarYHeight=0,t.scrollbarYTop=0,e.scrollTop=0)}function k(t,e){return t.settings.minScrollbarLength&&(e=Math.max(e,t.settings.minScrollbarLength)),t.settings.maxScrollbarLength&&(e=Math.min(e,t.settings.maxScrollbarLength)),e}function q(t,e){var r={width:e.railXWidth},o=Math.floor(t.scrollTop);e.isRtl?r.left=e.negativeScrollAdjustment+t.scrollLeft+e.containerWidth-e.contentWidth:r.left=t.scrollLeft,e.isScrollbarXUsingBottom?r.bottom=e.scrollbarXBottom-o:r.top=e.scrollbarXTop+o,y(e.scrollbarXRail,r);var a={top:o,height:e.railYHeight};e.isScrollbarYUsingRight?e.isRtl?a.right=e.contentWidth-(e.negativeScrollAdjustment+t.scrollLeft)-e.scrollbarYRight-e.scrollbarYOuterWidth-9:a.right=e.scrollbarYRight-t.scrollLeft:e.isRtl?a.left=e.negativeScrollAdjustment+t.scrollLeft+e.containerWidth*2-e.contentWidth-e.scrollbarYLeft-e.scrollbarYOuterWidth:a.left=e.scrollbarYLeft+t.scrollLeft,y(e.scrollbarYRail,a),y(e.scrollbarX,{left:e.scrollbarXLeft,width:e.scrollbarXWidth-e.railBorderXWidth}),y(e.scrollbarY,{top:e.scrollbarYTop,height:e.scrollbarYHeight-e.railBorderYWidth})}function z(t){t.event.bind(t.scrollbarY,"mousedown",function(e){return e.stopPropagation()}),t.event.bind(t.scrollbarYRail,"mousedown",function(e){var r=e.pageY-window.pageYOffset-t.scrollbarYRail.getBoundingClientRect().top,o=r>t.scrollbarYTop?1:-1;t.element.scrollTop+=o*t.containerHeight,X(t),e.stopPropagation()}),t.event.bind(t.scrollbarX,"mousedown",function(e){return e.stopPropagation()}),t.event.bind(t.scrollbarXRail,"mousedown",function(e){var r=e.pageX-window.pageXOffset-t.scrollbarXRail.getBoundingClientRect().left,o=r>t.scrollbarXLeft?1:-1;t.element.scrollLeft+=o*t.containerWidth,X(t),e.stopPropagation()})}var P=null;function J(t){B(t,["containerHeight","contentHeight","pageY","railYHeight","scrollbarY","scrollbarYHeight","scrollTop","y","scrollbarYRail"]),B(t,["containerWidth","contentWidth","pageX","railXWidth","scrollbarX","scrollbarXWidth","scrollLeft","x","scrollbarXRail"])}function B(t,e){var r=e[0],o=e[1],a=e[2],h=e[3],s=e[4],i=e[5],l=e[6],c=e[7],p=e[8],n=t.element,f=null,g=null,u=null;function m(b){b.touches&&b.touches[0]&&(b[a]=b.touches[0]["page"+c.toUpperCase()]),P===s&&(n[l]=f+u*(b[a]-g),I(t,c),X(t),b.stopPropagation(),b.preventDefault())}function Y(){K(t,c),t[p].classList.remove(v.state.clicking),document.removeEventListener("mousemove",m),document.removeEventListener("mouseup",Y),document.removeEventListener("touchmove",m),document.removeEventListener("touchend",Y),P=null}function L(b){P===null&&(P=s,f=n[l],b.touches&&(b[a]=b.touches[0]["page"+c.toUpperCase()]),g=b[a],u=(t[o]-t[r])/(t[h]-t[i]),b.touches?(document.addEventListener("touchmove",m,{passive:!1}),document.addEventListener("touchend",Y)):(document.addEventListener("mousemove",m),document.addEventListener("mouseup",Y)),t[p].classList.add(v.state.clicking)),b.stopPropagation(),b.cancelable&&b.preventDefault()}t[s].addEventListener("mousedown",L),t[s].addEventListener("touchstart",L)}function Q(t){var e=t.element,r=function(){return W(e,":hover")},o=function(){return W(t.scrollbarX,":focus")||W(t.scrollbarY,":focus")};function a(h,s){var i=Math.floor(e.scrollTop);if(h===0){if(!t.scrollbarYActive)return!1;if(i===0&&s>0||i>=t.contentHeight-t.containerHeight&&s<0)return!t.settings.wheelPropagation}var l=e.scrollLeft;if(s===0){if(!t.scrollbarXActive)return!1;if(l===0&&h<0||l>=t.contentWidth-t.containerWidth&&h>0)return!t.settings.wheelPropagation}return!0}t.event.bind(t.ownerDocument,"keydown",function(h){if(!(h.isDefaultPrevented&&h.isDefaultPrevented()||h.defaultPrevented)&&!(!r()&&!o())){var s=document.activeElement?document.activeElement:t.ownerDocument.activeElement;if(s){if(s.tagName==="IFRAME")s=s.contentDocument.activeElement;else for(;s.shadowRoot;)s=s.shadowRoot.activeElement;if(j(s))return}var i=0,l=0;switch(h.which){case 37:h.metaKey?i=-t.contentWidth:h.altKey?i=-t.containerWidth:i=-30;break;case 38:h.metaKey?l=t.contentHeight:h.altKey?l=t.containerHeight:l=30;break;case 39:h.metaKey?i=t.contentWidth:h.altKey?i=t.containerWidth:i=30;break;case 40:h.metaKey?l=-t.contentHeight:h.altKey?l=-t.containerHeight:l=-30;break;case 32:h.shiftKey?l=t.containerHeight:l=-t.containerHeight;break;case 33:l=t.containerHeight;break;case 34:l=-t.containerHeight;break;case 36:l=t.contentHeight;break;case 35:l=-t.contentHeight;break;default:return}t.settings.suppressScrollX&&i!==0||t.settings.suppressScrollY&&l!==0||(e.scrollTop-=l,e.scrollLeft+=i,X(t),a(i,l)&&h.preventDefault())}})}function V(t){var e=t.element;function r(s,i){var l=Math.floor(e.scrollTop),c=e.scrollTop===0,p=l+e.offsetHeight===e.scrollHeight,n=e.scrollLeft===0,f=e.scrollLeft+e.offsetWidth===e.scrollWidth,g;return Math.abs(i)>Math.abs(s)?g=c||p:g=n||f,g?!t.settings.wheelPropagation:!0}function o(s){var i=s.deltaX,l=-1*s.deltaY;return(typeof i>"u"||typeof l>"u")&&(i=-1*s.wheelDeltaX/6,l=s.wheelDeltaY/6),s.deltaMode&&s.deltaMode===1&&(i*=10,l*=10),i!==i&&l!==l&&(i=0,l=s.wheelDelta),s.shiftKey?[-l,-i]:[i,l]}function a(s,i,l){if(!T.isWebKit&&e.querySelector("select:focus"))return!0;if(!e.contains(s))return!1;for(var c=s;c&&c!==e;){if(c.classList.contains(v.element.consuming))return!0;var p=w(c);if(l&&p.overflowY.match(/(scroll|auto)/)){var n=c.scrollHeight-c.clientHeight;if(n>0&&(c.scrollTop>0&&l<0||c.scrollTop<n&&l>0))return!0}if(i&&p.overflowX.match(/(scroll|auto)/)){var f=c.scrollWidth-c.clientWidth;if(f>0&&(c.scrollLeft>0&&i<0||c.scrollLeft<f&&i>0))return!0}c=c.parentNode}return!1}function h(s){var i=o(s),l=i[0],c=i[1];if(!a(s.target,l,c)){var p=!1;t.settings.useBothWheelAxes?t.scrollbarYActive&&!t.scrollbarXActive?(c?e.scrollTop-=c*t.settings.wheelSpeed:e.scrollTop+=l*t.settings.wheelSpeed,p=!0):t.scrollbarXActive&&!t.scrollbarYActive&&(l?e.scrollLeft+=l*t.settings.wheelSpeed:e.scrollLeft-=c*t.settings.wheelSpeed,p=!0):(e.scrollTop-=c*t.settings.wheelSpeed,e.scrollLeft+=l*t.settings.wheelSpeed),X(t),p=p||r(l,c),p&&!s.ctrlKey&&(s.stopPropagation(),s.preventDefault())}}typeof window.onwheel<"u"?t.event.bind(e,"wheel",h):typeof window.onmousewheel<"u"&&t.event.bind(e,"mousewheel",h)}function Z(t){if(!T.supportsTouch&&!T.supportsIePointer)return;var e=t.element,r={startOffset:{},startTime:0,speed:{},easingLoop:null};function o(n,f){var g=Math.floor(e.scrollTop),u=e.scrollLeft,m=Math.abs(n),Y=Math.abs(f);if(Y>m){if(f<0&&g===t.contentHeight-t.containerHeight||f>0&&g===0)return window.scrollY===0&&f>0&&T.isChrome}else if(m>Y&&(n<0&&u===t.contentWidth-t.containerWidth||n>0&&u===0))return!0;return!0}function a(n,f){e.scrollTop-=f,e.scrollLeft-=n,X(t)}function h(n){return n.targetTouches?n.targetTouches[0]:n}function s(n){return n.target===t.scrollbarX||n.target===t.scrollbarY||n.pointerType&&n.pointerType==="pen"&&n.buttons===0?!1:!!(n.targetTouches&&n.targetTouches.length===1||n.pointerType&&n.pointerType!=="mouse"&&n.pointerType!==n.MSPOINTER_TYPE_MOUSE)}function i(n){if(s(n)){var f=h(n);r.startOffset.pageX=f.pageX,r.startOffset.pageY=f.pageY,r.startTime=new Date().getTime(),r.easingLoop!==null&&clearInterval(r.easingLoop)}}function l(n,f,g){if(!e.contains(n))return!1;for(var u=n;u&&u!==e;){if(u.classList.contains(v.element.consuming))return!0;var m=w(u);if(g&&m.overflowY.match(/(scroll|auto)/)){var Y=u.scrollHeight-u.clientHeight;if(Y>0&&(u.scrollTop>0&&g<0||u.scrollTop<Y&&g>0))return!0}if(f&&m.overflowX.match(/(scroll|auto)/)){var L=u.scrollWidth-u.clientWidth;if(L>0&&(u.scrollLeft>0&&f<0||u.scrollLeft<L&&f>0))return!0}u=u.parentNode}return!1}function c(n){if(s(n)){var f=h(n),g={pageX:f.pageX,pageY:f.pageY},u=g.pageX-r.startOffset.pageX,m=g.pageY-r.startOffset.pageY;if(l(n.target,u,m))return;a(u,m),r.startOffset=g;var Y=new Date().getTime(),L=Y-r.startTime;L>0&&(r.speed.x=u/L,r.speed.y=m/L,r.startTime=Y),o(u,m)&&n.cancelable&&n.preventDefault()}}function p(){t.settings.swipeEasing&&(clearInterval(r.easingLoop),r.easingLoop=setInterval(function(){if(t.isInitialized){clearInterval(r.easingLoop);return}if(!r.speed.x&&!r.speed.y){clearInterval(r.easingLoop);return}if(Math.abs(r.speed.x)<.01&&Math.abs(r.speed.y)<.01){clearInterval(r.easingLoop);return}a(r.speed.x*30,r.speed.y*30),r.speed.x*=.8,r.speed.y*=.8},10))}T.supportsTouch?(t.event.bind(e,"touchstart",i),t.event.bind(e,"touchmove",c),t.event.bind(e,"touchend",p)):T.supportsIePointer&&(window.PointerEvent?(t.event.bind(e,"pointerdown",i),t.event.bind(e,"pointermove",c),t.event.bind(e,"pointerup",p)):window.MSPointerEvent&&(t.event.bind(e,"MSPointerDown",i),t.event.bind(e,"MSPointerMove",c),t.event.bind(e,"MSPointerUp",p)))}var F=function(){return{handlers:["click-rail","drag-thumb","keyboard","wheel","touch"],maxScrollbarLength:null,minScrollbarLength:null,scrollingThreshold:1e3,scrollXMarginOffset:0,scrollYMarginOffset:0,suppressScrollX:!1,suppressScrollY:!1,swipeEasing:!0,useBothWheelAxes:!1,wheelPropagation:!0,wheelSpeed:1}},G={"click-rail":z,"drag-thumb":J,keyboard:Q,wheel:V,touch:Z},S=function(e,r){var o=this;if(r===void 0&&(r={}),typeof e=="string"&&(e=document.querySelector(e)),!e||!e.nodeName)throw new Error("no element is specified to initialize PerfectScrollbar");this.element=e,e.classList.add(v.main),this.settings=F();for(var a in r)this.settings[a]=r[a];this.containerWidth=null,this.containerHeight=null,this.contentWidth=null,this.contentHeight=null;var h=function(){return e.classList.add(v.state.focus)},s=function(){return e.classList.remove(v.state.focus)};this.isRtl=w(e).direction==="rtl",this.isRtl===!0&&e.classList.add(v.rtl),this.isNegativeScroll=function(){var c=e.scrollLeft,p=null;return e.scrollLeft=-1,p=e.scrollLeft<0,e.scrollLeft=c,p}(),this.negativeScrollAdjustment=this.isNegativeScroll?e.scrollWidth-e.clientWidth:0,this.event=new H,this.ownerDocument=e.ownerDocument||document,this.scrollbarXRail=M(v.element.rail("x")),e.appendChild(this.scrollbarXRail),this.scrollbarX=M(v.element.thumb("x")),this.scrollbarXRail.appendChild(this.scrollbarX),this.scrollbarX.setAttribute("tabindex",0),this.event.bind(this.scrollbarX,"focus",h),this.event.bind(this.scrollbarX,"blur",s),this.scrollbarXActive=null,this.scrollbarXWidth=null,this.scrollbarXLeft=null;var i=w(this.scrollbarXRail);this.scrollbarXBottom=parseInt(i.bottom,10),isNaN(this.scrollbarXBottom)?(this.isScrollbarXUsingBottom=!1,this.scrollbarXTop=d(i.top)):this.isScrollbarXUsingBottom=!0,this.railBorderXWidth=d(i.borderLeftWidth)+d(i.borderRightWidth),y(this.scrollbarXRail,{display:"block"}),this.railXMarginWidth=d(i.marginLeft)+d(i.marginRight),y(this.scrollbarXRail,{display:""}),this.railXWidth=null,this.railXRatio=null,this.scrollbarYRail=M(v.element.rail("y")),e.appendChild(this.scrollbarYRail),this.scrollbarY=M(v.element.thumb("y")),this.scrollbarYRail.appendChild(this.scrollbarY),this.scrollbarY.setAttribute("tabindex",0),this.event.bind(this.scrollbarY,"focus",h),this.event.bind(this.scrollbarY,"blur",s),this.scrollbarYActive=null,this.scrollbarYHeight=null,this.scrollbarYTop=null;var l=w(this.scrollbarYRail);this.scrollbarYRight=parseInt(l.right,10),isNaN(this.scrollbarYRight)?(this.isScrollbarYUsingRight=!1,this.scrollbarYLeft=d(l.left)):this.isScrollbarYUsingRight=!0,this.scrollbarYOuterWidth=this.isRtl?$(this.scrollbarY):null,this.railBorderYWidth=d(l.borderTopWidth)+d(l.borderBottomWidth),y(this.scrollbarYRail,{display:"block"}),this.railYMarginHeight=d(l.marginTop)+d(l.marginBottom),y(this.scrollbarYRail,{display:""}),this.railYHeight=null,this.railYRatio=null,this.reach={x:e.scrollLeft<=0?"start":e.scrollLeft>=this.contentWidth-this.containerWidth?"end":null,y:e.scrollTop<=0?"start":e.scrollTop>=this.contentHeight-this.containerHeight?"end":null},this.isAlive=!0,this.settings.handlers.forEach(function(c){return G[c](o)}),this.lastScrollTop=Math.floor(e.scrollTop),this.lastScrollLeft=e.scrollLeft,this.event.bind(this.element,"scroll",function(c){return o.onScroll(c)}),X(this)};S.prototype.update=function(){this.isAlive&&(this.negativeScrollAdjustment=this.isNegativeScroll?this.element.scrollWidth-this.element.clientWidth:0,y(this.scrollbarXRail,{display:"block"}),y(this.scrollbarYRail,{display:"block"}),this.railXMarginWidth=d(w(this.scrollbarXRail).marginLeft)+d(w(this.scrollbarXRail).marginRight),this.railYMarginHeight=d(w(this.scrollbarYRail).marginTop)+d(w(this.scrollbarYRail).marginBottom),y(this.scrollbarXRail,{display:"none"}),y(this.scrollbarYRail,{display:"none"}),X(this),C(this,"top",0,!1,!0),C(this,"left",0,!1,!0),y(this.scrollbarXRail,{display:""}),y(this.scrollbarYRail,{display:""}))};S.prototype.onScroll=function(e){this.isAlive&&(X(this),C(this,"top",this.element.scrollTop-this.lastScrollTop),C(this,"left",this.element.scrollLeft-this.lastScrollLeft),this.lastScrollTop=Math.floor(this.element.scrollTop),this.lastScrollLeft=this.element.scrollLeft)};S.prototype.destroy=function(){this.isAlive&&(this.event.unbindAll(),E(this.scrollbarX),E(this.scrollbarY),E(this.scrollbarXRail),E(this.scrollbarYRail),this.removePsClasses(),this.element=null,this.scrollbarX=null,this.scrollbarY=null,this.scrollbarXRail=null,this.scrollbarYRail=null,this.isAlive=!1)};S.prototype.removePsClasses=function(){this.element.className=this.element.className.split(" ").filter(function(e){return!e.match(/^ps([-_].+|)$/)}).join(" ")};window.PerfectScrollbar=S;require("./bootstrap");require("./custom");
