
// jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
jQuery.easing.jswing=jQuery.easing.swing;
jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,a,c,b,d){return jQuery.easing[jQuery.easing.def](e,a,c,b,d)},easeInQuad:function(e,a,c,b,d){return b*(a/=d)*a+c},easeOutQuad:function(e,a,c,b,d){return-b*(a/=d)*(a-2)+c},easeInOutQuad:function(e,a,c,b,d){return 1>(a/=d/2)?b/2*a*a+c:-b/2*(--a*(a-2)-1)+c},easeInCubic:function(e,a,c,b,d){return b*(a/=d)*a*a+c},easeOutCubic:function(e,a,c,b,d){return b*((a=a/d-1)*a*a+1)+c},easeInOutCubic:function(e,a,c,b,d){return 1>(a/=d/2)?b/2*a*a*a+c:
    b/2*((a-=2)*a*a+2)+c},easeInQuart:function(e,a,c,b,d){return b*(a/=d)*a*a*a+c},easeOutQuart:function(e,a,c,b,d){return-b*((a=a/d-1)*a*a*a-1)+c},easeInOutQuart:function(e,a,c,b,d){return 1>(a/=d/2)?b/2*a*a*a*a+c:-b/2*((a-=2)*a*a*a-2)+c},easeInQuint:function(e,a,c,b,d){return b*(a/=d)*a*a*a*a+c},easeOutQuint:function(e,a,c,b,d){return b*((a=a/d-1)*a*a*a*a+1)+c},easeInOutQuint:function(e,a,c,b,d){return 1>(a/=d/2)?b/2*a*a*a*a*a+c:b/2*((a-=2)*a*a*a*a+2)+c},easeInSine:function(e,a,c,b,d){return-b*Math.cos(a/
    d*(Math.PI/2))+b+c},easeOutSine:function(e,a,c,b,d){return b*Math.sin(a/d*(Math.PI/2))+c},easeInOutSine:function(e,a,c,b,d){return-b/2*(Math.cos(Math.PI*a/d)-1)+c},easeInExpo:function(e,a,c,b,d){return 0==a?c:b*Math.pow(2,10*(a/d-1))+c},easeOutExpo:function(e,a,c,b,d){return a==d?c+b:b*(-Math.pow(2,-10*a/d)+1)+c},easeInOutExpo:function(e,a,c,b,d){return 0==a?c:a==d?c+b:1>(a/=d/2)?b/2*Math.pow(2,10*(a-1))+c:b/2*(-Math.pow(2,-10*--a)+2)+c},easeInCirc:function(e,a,c,b,d){return-b*(Math.sqrt(1-(a/=d)*
    a)-1)+c},easeOutCirc:function(e,a,c,b,d){return b*Math.sqrt(1-(a=a/d-1)*a)+c},easeInOutCirc:function(e,a,c,b,d){return 1>(a/=d/2)?-b/2*(Math.sqrt(1-a*a)-1)+c:b/2*(Math.sqrt(1-(a-=2)*a)+1)+c},easeInElastic:function(e,a,c,b,d){e=1.70158;var f=0,g=b;if(0==a)return c;if(1==(a/=d))return c+b;f||(f=0.3*d);g<Math.abs(b)?(g=b,e=f/4):e=f/(2*Math.PI)*Math.asin(b/g);return-(g*Math.pow(2,10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f))+c},easeOutElastic:function(e,a,c,b,d){e=1.70158;var f=0,g=b;if(0==a)return c;if(1==
    (a/=d))return c+b;f||(f=0.3*d);g<Math.abs(b)?(g=b,e=f/4):e=f/(2*Math.PI)*Math.asin(b/g);return g*Math.pow(2,-10*a)*Math.sin((a*d-e)*2*Math.PI/f)+b+c},easeInOutElastic:function(e,a,c,b,d){e=1.70158;var f=0,g=b;if(0==a)return c;if(2==(a/=d/2))return c+b;f||(f=d*0.3*1.5);g<Math.abs(b)?(g=b,e=f/4):e=f/(2*Math.PI)*Math.asin(b/g);return 1>a?-0.5*g*Math.pow(2,10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f)+c:0.5*g*Math.pow(2,-10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f)+b+c},easeInBack:function(e,a,c,b,d,f){void 0==
    f&&(f=1.70158);return b*(a/=d)*a*((f+1)*a-f)+c},easeOutBack:function(e,a,c,b,d,f){void 0==f&&(f=1.70158);return b*((a=a/d-1)*a*((f+1)*a+f)+1)+c},easeInOutBack:function(e,a,c,b,d,f){void 0==f&&(f=1.70158);return 1>(a/=d/2)?b/2*a*a*(((f*=1.525)+1)*a-f)+c:b/2*((a-=2)*a*(((f*=1.525)+1)*a+f)+2)+c},easeInBounce:function(e,a,c,b,d){return b-jQuery.easing.easeOutBounce(e,d-a,0,b,d)+c},easeOutBounce:function(e,a,c,b,d){return(a/=d)<1/2.75?b*7.5625*a*a+c:a<2/2.75?b*(7.5625*(a-=1.5/2.75)*a+0.75)+c:a<2.5/2.75?
    b*(7.5625*(a-=2.25/2.75)*a+0.9375)+c:b*(7.5625*(a-=2.625/2.75)*a+0.984375)+c},easeInOutBounce:function(e,a,c,b,d){return a<d/2?0.5*jQuery.easing.easeInBounce(e,2*a,0,b,d)+c:0.5*jQuery.easing.easeOutBounce(e,2*a-d,0,b,d)+0.5*b+c}});

/*
 * iosSlider - http://iosscripts.com/iosslider/
 */
(function(b){var oa=0,X=0,fa=0,T=0,Ca="ontouchstart"in window||0<navigator.msMaxTouchPoints,Da="onorientationchange"in window,ga=!1,aa=!1,Y=!1,pa=!1,ia=!1,ba="pointer",ua="pointer",ja=[],J=[],va=[],$=[],z=[],ca=[],B=[],m=[],s=[],wa=[],da=[],e={showScrollbar:function(a,e){a.scrollbarHide&&b("."+e).css({opacity:a.scrollbarOpacity,filter:"alpha(opacity:"+100*a.scrollbarOpacity+")"})},hideScrollbar:function(b,g,c,f,h,d,m,s,B,z){if(b.scrollbar&&b.scrollbarHide)for(var t=c;t<c+25;t++)g[g.length]=e.hideScrollbarIntervalTimer(10* t,f[c],(c+24-t)/24,h,d,m,s,B,z,b)},hideScrollbarInterval:function(a,g,c,f,h,d,m,B,z){T=-1*a/s[B]*(h-d-m-f);e.setSliderOffset("."+c,T);b("."+c).css({opacity:z.scrollbarOpacity*g,filter:"alpha(opacity:"+z.scrollbarOpacity*g*100+")"})},slowScrollHorizontalInterval:function(a,g,c,f,h,d,N,O,L,K,t,w,x,y,v,q,G,p,n){if(n.infiniteSlider){if(c<=-1*s[q]){var r=b(a).width();if(c<=-1*wa[q]){var u=-1*t[0];b(g).each(function(c){e.setSliderOffset(b(g)[c],u+G);c<w.length&&(w[c]=-1*u);u+=v[c]});c+=-1*w[0];m[q]=-1* w[0]+G;s[q]=m[q]+r-d;B[q]=0}else{var k=0,E=e.getSliderOffset(b(g[0]),"x");b(g).each(function(b){e.getSliderOffset(this,"x")<E&&(E=e.getSliderOffset(this,"x"),k=b)});x=m[q]+r;e.setSliderOffset(b(g)[k],x);m[q]=-1*w[1]+G;s[q]=m[q]+r-d;w.splice(0,1);w.splice(w.length,0,-1*x+G);B[q]++}}if(c>=-1*m[q]||0<=c){r=b(a).width();if(0<c)for(u=-1*t[0],b(g).each(function(c){e.setSliderOffset(b(g)[c],u+G);c<w.length&&(w[c]=-1*u);u+=v[c]}),c-=-1*w[0],m[q]=-1*w[0]+G,s[q]=m[q]+r-d,B[q]=y;0<-1*w[0]-r+G;){var A=0,I=e.getSliderOffset(b(g[0]), "x");b(g).each(function(b){e.getSliderOffset(this,"x")>I&&(I=e.getSliderOffset(this,"x"),A=b)});x=m[q]-v[A];e.setSliderOffset(b(g)[A],x);w.splice(0,0,-1*x+G);w.splice(w.length-1,1);m[q]=-1*w[0]+G;s[q]=m[q]+r-d;B[q]--;z[q]++}0>c&&(A=0,I=e.getSliderOffset(b(g[0]),"x"),b(g).each(function(b){e.getSliderOffset(this,"x")>I&&(I=e.getSliderOffset(this,"x"),A=b)}),x=m[q]-v[A],e.setSliderOffset(b(g)[A],x),w.splice(0,0,-1*x+G),w.splice(w.length-1,1),m[q]=-1*w[0]+G,s[q]=m[q]+r-d,B[q]--)}}t=!1;d=e.calcActiveOffset(n, c,w,d,B[q],y,K,q);x=(d+B[q]+y)%y;n.infiniteSlider?x!=ca[q]&&(t=!0):d!=z[q]&&(t=!0);if(t&&(y=new e.args("change",n,a,b(a).children(":eq("+x+")"),x,p),b(a).parent().data("args",y),""!=n.onSlideChange))n.onSlideChange(y);z[q]=d;ca[q]=x;c=Math.floor(c);e.setSliderOffset(a,c);n.scrollbar&&(T=Math.floor((-1*c-m[q]+G)/(s[q]-m[q]+G)*(N-O-h)),a=h-L,c>=-1*m[q]+G?(a=h-L- -1*T,e.setSliderOffset(b("."+f),0)):(c<=-1*s[q]+1&&(a=N-O-L-T),e.setSliderOffset(b("."+f),T)),b("."+f).css({width:a+"px"}))},slowScrollHorizontal:function(a, g,c,f,h,d,N,O,L,K,t,w,x,y,v,q,G,p,n,r,u){var k=e.getSliderOffset(a,"x");d=[];var E=0,A=25/1024*O;frictionCoefficient=u.frictionCoefficient;elasticFrictionCoefficient=u.elasticFrictionCoefficient;snapFrictionCoefficient=u.snapFrictionCoefficient;h>u.snapVelocityThreshold&&u.snapToChildren&&!n?E=1:h<-1*u.snapVelocityThreshold&&u.snapToChildren&&!n&&(E=-1);h<-1*A?h=-1*A:h>A&&(h=A);b(a)[0]!==b(p)[0]&&(E*=-1,h*=-2);p=B[v];if(u.infiniteSlider)var I=m[v],l=s[v];n=[];for(var A=[],F=0;F<x.length;F++)n[F]= x[F],F<g.length&&(A[F]=e.getSliderOffset(b(g[F]),"x"));for(;1<h||-1>h;){h*=frictionCoefficient;k+=h;(k>-1*m[v]||k<-1*s[v])&&!u.infiniteSlider&&(h*=elasticFrictionCoefficient,k+=h);if(u.infiniteSlider){if(k<=-1*l){for(var l=b(a).width(),J=0,P=A[0],F=0;F<A.length;F++)A[F]<P&&(P=A[F],J=F);F=I+l;A[J]=F;I=-1*n[1]+r;l=I+l-O;n.splice(0,1);n.splice(n.length,0,-1*F+r);p++}if(k>=-1*I){l=b(a).width();J=0;P=A[0];for(F=0;F<A.length;F++)A[F]>P&&(P=A[F],J=F);F=I-y[J];A[J]=F;n.splice(0,0,-1*F+r);n.splice(n.length- 1,1);I=-1*n[0]+r;l=I+l-O;p--}}d[d.length]=k}A=!1;h=e.calcActiveOffset(u,k,n,O,p,G,z[v],v);I=(h+p+G)%G;u.snapToChildren&&(u.infiniteSlider?I!=ca[v]&&(A=!0):h!=z[v]&&(A=!0),0>E&&!A?(h++,h>=x.length&&!u.infiniteSlider&&(h=x.length-1)):0<E&&!A&&(h--,0>h&&!u.infiniteSlider&&(h=0)));if(u.snapToChildren||(k>-1*m[v]||k<-1*s[v])&&!u.infiniteSlider){(k>-1*m[v]||k<-1*s[v])&&!u.infiniteSlider?d.splice(0,d.length):(d.splice(0.1*d.length,d.length),k=0<d.length?d[d.length-1]:k);for(;k<n[h]-0.5||k>n[h]+0.5;)k=(k- n[h])*snapFrictionCoefficient+n[h],d[d.length]=k;d[d.length]=n[h]}E=1;0!=d.length%2&&(E=0);for(k=0;k<c.length;k++)clearTimeout(c[k]);p=(h+p+G)%G;I=0;for(k=E;k<d.length;k+=2)if(k==E||1<Math.abs(d[k]-I)||k>=d.length-2)I=d[k],c[c.length]=e.slowScrollHorizontalIntervalTimer(10*k,a,g,d[k],f,N,O,L,K,t,h,w,x,q,G,y,v,r,p,u);I=(h+B[v]+G)%G;""!=u.onSlideComplete&&1<d.length&&(c[c.length]=e.onSlideCompleteTimer(10*(k+1),u,a,b(a).children(":eq("+I+")"),p,v));$[v]=c;e.hideScrollbar(u,c,k,d,f,N,O,K,t,v)},onSlideComplete:function(a, g,c,f,h){c=new e.args("complete",a,b(g),c,f,f);b(g).parent().data("args",c);if(""!=a.onSlideComplete)a.onSlideComplete(c)},getSliderOffset:function(a,e){var c=0;e="x"==e?4:5;if(!ga||aa||Y)c=parseInt(b(a).css("left"),10);else{for(var c=["-webkit-transform","-moz-transform","transform"],f,h=0;h<c.length;h++)if(void 0!=b(a).css(c[h])&&0<b(a).css(c[h]).length){f=b(a).css(c[h]).split(",");break}c=void 0==f[e]?0:parseInt(f[e],10)}return c},setSliderOffset:function(a,e){e=parseInt(e,10);!ga||aa||Y?b(a).css({left:e+ "px"}):b(a).css({msTransform:"matrix(1,0,0,1,"+e+",0)",webkitTransform:"matrix(1,0,0,1,"+e+",0)",MozTransform:"matrix(1,0,0,1,"+e+",0)",transform:"matrix(1,0,0,1,"+e+",0)"})},setBrowserInfo:function(){null!=navigator.userAgent.match("WebKit")?(ba="-webkit-grab",ua="-webkit-grabbing"):null!=navigator.userAgent.match("Gecko")?(ia=!0,ba="move",ua="-moz-grabbing"):null!=navigator.userAgent.match("MSIE 7")?pa=aa=!0:null!=navigator.userAgent.match("MSIE 8")?pa=Y=!0:null!=navigator.userAgent.match("MSIE 9")&& (pa=!0)},has3DTransform:function(){var a=!1,e=b("<div />").css({msTransform:"matrix(1,1,1,1,1,1)",webkitTransform:"matrix(1,1,1,1,1,1)",MozTransform:"matrix(1,1,1,1,1,1)",transform:"matrix(1,1,1,1,1,1)"});""==e.attr("style")?a=!1:ia&&21<=parseInt(navigator.userAgent.split("/")[3],10)?a=!1:void 0!=e.attr("style")&&(a=!0);return a},getSlideNumber:function(b,e,c){return(b-B[e]+c)%c},calcActiveOffset:function(b,e,c,f,h,d,m,s){h=!1;b=[];var z;e>c[0]&&(z=0);e<c[c.length-1]&&(z=d-1);for(d=0;d<c.length;d++)c[d]<= e&&c[d]>e-f&&(h||c[d]==e||(b[b.length]=c[d-1]),b[b.length]=c[d],h=!0);0==b.length&&(b[0]=c[c.length-1]);for(d=h=0;d<b.length;d++)m=Math.abs(e-b[d]),m<f&&(h=b[d],f=m);for(d=0;d<c.length;d++)h==c[d]&&(z=d);return z},changeSlide:function(a,g,c,f,h,d,m,s,L,K,t,w,x,y,v,q,G,p){e.autoSlidePause(y);for(var n=0;n<f.length;n++)clearTimeout(f[n]);var r=Math.ceil(p.autoSlideTransTimer/10)+1,u=e.getSliderOffset(g,"x"),k=w[a],E=k-u;if(p.infiniteSlider)for(a=(a-B[y]+2*q)%q,n=!1,0==a&&2==q&&(a=q,w[a]=w[a-1]-b(c).eq(0).outerWidth(!0), n=!0),k=w[a],E=k-u,k=[w[a]-b(g).width(),w[a]+b(g).width()],n&&w.splice(w.length-1,1),n=0;n<k.length;n++)Math.abs(k[n]-u)<Math.abs(E)&&(E=k[n]-u);var k=[],A;e.showScrollbar(p,h);for(n=0;n<=r;n++)A=n,A/=r,A--,A=u+E*(Math.pow(A,5)+1),k[k.length]=A;r=(a+B[y]+q)%q;for(n=u=0;n<k.length;n++){if(0==n||1<Math.abs(k[n]-u)||n>=k.length-2)u=k[n],f[n]=e.slowScrollHorizontalIntervalTimer(10*(n+1),g,c,k[n],h,d,m,s,L,K,a,t,w,v,q,x,y,G,r,p);0==n&&""!=p.onSlideStart&&(E=(z[y]+B[y]+q)%q,p.onSlideStart(new e.args("start", p,g,b(g).children(":eq("+E+")"),E,a)))}u=!1;p.infiniteSlider?r!=ca[y]&&(u=!0):a!=z[y]&&(u=!0);u&&""!=p.onSlideComplete&&(f[f.length]=e.onSlideCompleteTimer(10*(n+1),p,g,b(g).children(":eq("+r+")"),r,y));$[y]=f;e.hideScrollbar(p,f,n,k,h,d,m,L,K,y);e.autoSlide(g,c,f,h,d,m,s,L,K,t,w,x,y,v,q,G,p)},autoSlide:function(b,g,c,f,h,d,m,s,L,K,t,w,x,y,v,q,G){if(!J[x].autoSlide)return!1;e.autoSlidePause(x);ja[x]=setTimeout(function(){!G.infiniteSlider&&z[x]>t.length-1&&(z[x]-=v);e.changeSlide((z[x]+B[x]+t.length+ 1)%t.length,b,g,c,f,h,d,m,s,L,K,t,w,x,y,v,q,G);e.autoSlide(b,g,c,f,h,d,m,s,L,K,t,w,x,y,v,q,G)},G.autoSlideTimer+G.autoSlideTransTimer)},autoSlidePause:function(b){clearTimeout(ja[b])},isUnselectable:function(a,e){return""!=e.unselectableSelector&&1==b(a).closest(e.unselectableSelector).length?!0:!1},slowScrollHorizontalIntervalTimer:function(b,g,c,f,h,d,m,s,z,B,t,w,x,y,v,q,G,p,n,r){return setTimeout(function(){e.slowScrollHorizontalInterval(g,c,f,h,d,m,s,z,B,t,w,x,y,v,q,G,p,n,r)},b)},onSlideCompleteTimer:function(b, g,c,f,h,d){return setTimeout(function(){e.onSlideComplete(g,c,f,h,d)},b)},hideScrollbarIntervalTimer:function(b,g,c,f,h,d,m,s,z,B){return setTimeout(function(){e.hideScrollbarInterval(g,c,f,h,d,m,s,z,B)},b)},args:function(a,g,c,f,h,d){this.prevSlideNumber=void 0==b(c).parent().data("args")?void 0:b(c).parent().data("args").prevSlideNumber;this.prevSlideObject=void 0==b(c).parent().data("args")?void 0:b(c).parent().data("args").prevSlideObject;this.targetSlideNumber=d+1;this.targetSlideObject=b(c).children(":eq("+ d+")");this.slideChanged=!1;"load"==a?this.targetSlideObject=this.targetSlideNumber=void 0:"start"==a?this.targetSlideObject=this.targetSlideNumber=void 0:"change"==a?(this.slideChanged=!0,this.prevSlideNumber=void 0==b(c).parent().data("args")?g.startAtSlide:b(c).parent().data("args").currentSlideNumber,this.prevSlideObject=b(c).children(":eq("+this.prevSlideNumber+")")):"complete"==a&&(this.slideChanged=b(c).parent().data("args").slideChanged);this.settings=g;this.data=b(c).parent().data("iosslider"); this.sliderObject=c;this.sliderContainerObject=b(c).parent();this.currentSlideObject=f;this.currentSlideNumber=h+1;this.currentSliderOffset=-1*e.getSliderOffset(c,"x")},preventDrag:function(b){b.preventDefault()},preventClick:function(b){b.stopImmediatePropagation();return!1},enableClick:function(){return!0}};e.setBrowserInfo();var V={init:function(a,g){ga=e.has3DTransform();var c=b.extend(!0,{elasticPullResistance:0.6,frictionCoefficient:0.92,elasticFrictionCoefficient:0.6,snapFrictionCoefficient:0.92, snapToChildren:!1,snapSlideCenter:!1,startAtSlide:1,scrollbar:!1,scrollbarDrag:!1,scrollbarHide:!0,scrollbarLocation:"top",scrollbarContainer:"",scrollbarOpacity:0.4,scrollbarHeight:"4px",scrollbarBorder:"0",scrollbarMargin:"5px",scrollbarBackground:"#000",scrollbarBorderRadius:"100px",scrollbarShadow:"0 0 0 #000",scrollbarElasticPullResistance:0.9,desktopClickDrag:!1,keyboardControls:!1,tabToAdvance:!1,responsiveSlideContainer:!0,responsiveSlides:!0,navSlideSelector:"",navPrevSelector:"",navNextSelector:"", autoSlideToggleSelector:"",autoSlide:!1,autoSlideTimer:5E3,autoSlideTransTimer:750,autoSlideHoverPause:!0,infiniteSlider:!1,snapVelocityThreshold:5,slideStartVelocityThreshold:0,horizontalSlideLockThreshold:5,verticalSlideLockThreshold:3,stageCSS:{position:"relative",top:"0",left:"0",overflow:"hidden",zIndex:1},unselectableSelector:"",onSliderLoaded:"",onSliderUpdate:"",onSliderResize:"",onSlideStart:"",onSlideChange:"",onSlideComplete:""},a);void 0==g&&(g=this);return b(g).each(function(a){function g(){e.autoSlidePause(d); xa=b(C).find("a");ja=b(C).find("[onclick]");qa=b(C).find("*");b(n).css("width","");b(n).css("height","");b(C).css("width","");D=b(C).children().not("script").get();ha=[];M=[];c.responsiveSlides&&b(D).css("width","");s[d]=0;l=[];q=b(n).parent().width();r=b(n).outerWidth(!0);c.responsiveSlideContainer&&(r=b(n).outerWidth(!0)>q?q:b(n).width());b(n).css({position:c.stageCSS.position,top:c.stageCSS.top,left:c.stageCSS.left,overflow:c.stageCSS.overflow,zIndex:c.stageCSS.zIndex,webkitPerspective:1E3,webkitBackfaceVisibility:"hidden", msTouchAction:"pan-y",width:r});b(c.unselectableSelector).css({cursor:"default"});for(var a=0;a<D.length;a++){ha[a]=b(D[a]).width();M[a]=b(D[a]).outerWidth(!0);var h=M[a];c.responsiveSlides&&(M[a]>r?(h=r+-1*(M[a]-ha[a]),ha[a]=h,M[a]=r):h=ha[a],b(D[a]).css({width:h}));b(D[a]).css({webkitBackfaceVisibility:"hidden",overflow:"hidden",position:"absolute"});l[a]=-1*s[d];s[d]=s[d]+h+(M[a]-ha[a])}c.snapSlideCenter&&(p=0.5*(r-M[0]),c.responsiveSlides&&M[0]>r&&(p=0));wa[d]=2*s[d];for(a=0;a<D.length;a++)e.setSliderOffset(b(D[a]), -1*l[a]+s[d]+p),l[a]-=s[d];if(!c.infiniteSlider&&!c.snapSlideCenter){for(a=0;a<l.length&&!(l[a]<=-1*(2*s[d]-r));a++)ia=a;l.splice(ia+1,l.length);l[l.length]=-1*(2*s[d]-r)}for(a=0;a<l.length;a++)F[a]=l[a];I&&(J[d].startAtSlide=J[d].startAtSlide>l.length?l.length:J[d].startAtSlide,c.infiniteSlider?(J[d].startAtSlide=(J[d].startAtSlide-1+H)%H,z[d]=J[d].startAtSlide):(J[d].startAtSlide=0>J[d].startAtSlide-1?l.length-1:J[d].startAtSlide,z[d]=J[d].startAtSlide-1),ca[d]=z[d]);m[d]=s[d]+p;b(C).css({position:"relative", cursor:ba,webkitPerspective:"0",webkitBackfaceVisibility:"hidden",width:s[d]+"px"});R=s[d];s[d]=2*s[d]-r+2*p;(W=R+p<r||0==r?!0:!1)&&b(C).css({cursor:"default"});G=b(n).parent().outerHeight(!0);u=b(n).height();c.responsiveSlideContainer&&(u=u>G?G:u);b(n).css({height:u});e.setSliderOffset(C,l[z[d]]);if(c.infiniteSlider&&!W){a=e.getSliderOffset(b(C),"x");for(h=(B[d]+H)%H*-1;0>h;){var f=0,A=e.getSliderOffset(b(D[0]),"x");b(D).each(function(b){e.getSliderOffset(this,"x")<A&&(A=e.getSliderOffset(this,"x"), f=b)});var L=m[d]+R;e.setSliderOffset(b(D)[f],L);m[d]=-1*l[1]+p;s[d]=m[d]+R-r;l.splice(0,1);l.splice(l.length,0,-1*L+p);h++}for(;0<-1*l[0]-R+p&&c.snapSlideCenter&&I;){var O=0,P=e.getSliderOffset(b(D[0]),"x");b(D).each(function(b){e.getSliderOffset(this,"x")>P&&(P=e.getSliderOffset(this,"x"),O=b)});L=m[d]-M[O];e.setSliderOffset(b(D)[O],L);l.splice(0,0,-1*L+p);l.splice(l.length-1,1);m[d]=-1*l[0]+p;s[d]=m[d]+R-r;B[d]--;z[d]++}for(;a<=-1*s[d];)f=0,A=e.getSliderOffset(b(D[0]),"x"),b(D).each(function(b){e.getSliderOffset(this, "x")<A&&(A=e.getSliderOffset(this,"x"),f=b)}),L=m[d]+R,e.setSliderOffset(b(D)[f],L),m[d]=-1*l[1]+p,s[d]=m[d]+R-r,l.splice(0,1),l.splice(l.length,0,-1*L+p),B[d]++,z[d]--}e.setSliderOffset(C,l[z[d]]);c.desktopClickDrag||b(C).css({cursor:"default"});c.scrollbar&&(b("."+K).css({margin:c.scrollbarMargin,overflow:"hidden",display:"none"}),b("."+K+" ."+t).css({border:c.scrollbarBorder}),k=parseInt(b("."+K).css("marginLeft"))+parseInt(b("."+K).css("marginRight")),E=parseInt(b("."+K+" ."+t).css("borderLeftWidth"), 10)+parseInt(b("."+K+" ."+t).css("borderRightWidth"),10),y=""!=c.scrollbarContainer?b(c.scrollbarContainer).width():r,v=r/R*(y-k),c.scrollbarHide||(V=c.scrollbarOpacity),b("."+K).css({position:"absolute",left:0,width:y-k+"px",margin:c.scrollbarMargin}),"top"==c.scrollbarLocation?b("."+K).css("top","0"):b("."+K).css("bottom","0"),b("."+K+" ."+t).css({borderRadius:c.scrollbarBorderRadius,background:c.scrollbarBackground,height:c.scrollbarHeight,width:v-E+"px",minWidth:c.scrollbarHeight,border:c.scrollbarBorder, webkitPerspective:1E3,webkitBackfaceVisibility:"hidden",position:"relative",opacity:V,filter:"alpha(opacity:"+100*V+")",boxShadow:c.scrollbarShadow}),e.setSliderOffset(b("."+K+" ."+t),Math.floor((-1*l[z[d]]-m[d]+p)/(s[d]-m[d]+p)*(y-k-v))),b("."+K).css({display:"block"}),w=b("."+K+" ."+t),x=b("."+K));c.scrollbarDrag&&!W&&b("."+K+" ."+t).css({cursor:ba});c.infiniteSlider&&(S=(s[d]+r)/3);""!=c.navSlideSelector&&b(c.navSlideSelector).each(function(a){b(this).css({cursor:"pointer"});b(this).unbind(Q).bind(Q, function(g){"touchstart"==g.type?b(this).unbind("click.iosSliderEvent"):b(this).unbind("touchstart.iosSliderEvent");Q=g.type+".iosSliderEvent";e.changeSlide(a,C,D,N,t,v,r,y,k,E,F,l,M,d,S,H,p,c)})});""!=c.navPrevSelector&&(b(c.navPrevSelector).css({cursor:"pointer"}),b(c.navPrevSelector).unbind(Q).bind(Q,function(a){"touchstart"==a.type?b(this).unbind("click.iosSliderEvent"):b(this).unbind("touchstart.iosSliderEvent");Q=a.type+".iosSliderEvent";a=(z[d]+B[d]+H)%H;(0<a||c.infiniteSlider)&&e.changeSlide(a- 1,C,D,N,t,v,r,y,k,E,F,l,M,d,S,H,p,c)}));""!=c.navNextSelector&&(b(c.navNextSelector).css({cursor:"pointer"}),b(c.navNextSelector).unbind(Q).bind(Q,function(a){"touchstart"==a.type?b(this).unbind("click.iosSliderEvent"):b(this).unbind("touchstart.iosSliderEvent");Q=a.type+".iosSliderEvent";a=(z[d]+B[d]+H)%H;(a<l.length-1||c.infiniteSlider)&&e.changeSlide(a+1,C,D,N,t,v,r,y,k,E,F,l,M,d,S,H,p,c)}));c.autoSlide&&!W&&""!=c.autoSlideToggleSelector&&(b(c.autoSlideToggleSelector).css({cursor:"pointer"}),b(c.autoSlideToggleSelector).unbind(Q).bind(Q, function(a){"touchstart"==a.type?b(this).unbind("click.iosSliderEvent"):b(this).unbind("touchstart.iosSliderEvent");Q=a.type+".iosSliderEvent";ka?(e.autoSlide(C,D,N,t,v,r,y,k,E,F,l,M,d,S,H,p,c),ka=!1,b(c.autoSlideToggleSelector).removeClass("on")):(e.autoSlidePause(d),ka=!0,b(c.autoSlideToggleSelector).addClass("on"))}));e.autoSlide(C,D,N,t,v,r,y,k,E,F,l,M,d,S,H,p,c);b(n).bind("mouseleave.iosSliderEvent",function(){if(ka)return!0;e.autoSlide(C,D,N,t,v,r,y,k,E,F,l,M,d,S,H,p,c)});b(n).bind("touchend.iosSliderEvent", function(){if(ka)return!0;e.autoSlide(C,D,N,t,v,r,y,k,E,F,l,M,d,S,H,p,c)});c.autoSlideHoverPause&&b(n).bind("mouseenter.iosSliderEvent",function(){e.autoSlidePause(d)});b(n).data("iosslider",{obj:Ba,settings:c,scrollerNode:C,slideNodes:D,numberOfSlides:H,centeredSlideOffset:p,sliderNumber:d,originalOffsets:F,childrenOffsets:l,sliderMax:s[d],scrollbarClass:t,scrollbarWidth:v,scrollbarStageWidth:y,stageWidth:r,scrollMargin:k,scrollBorder:E,infiniteSliderOffset:B[d],infiniteSliderWidth:S,slideNodeOuterWidths:M, shortContent:W});I=!1;return!0}oa++;var d=oa,N=[];J[d]=b.extend({},c);m[d]=0;s[d]=0;var O=[0,0],L=[0,0],K="scrollbarBlock"+oa,t="scrollbar"+oa,w,x,y,v,q,G,p=0,n=b(this),r,u,k,E,A,I=!0;a=-1;var l,F=[],V=0,P=0,ga=0,C=b(this).children(":first-child"),D,ha,M,H=b(C).children().not("script").length,U=!1,ia=0,ya=!1,ra=void 0,S;B[d]=0;var W=!1,ka=!1;va[d]=!1;var Z,sa=!1,la=!1,Q="touchstart.iosSliderEvent click.iosSliderEvent",R,xa,ja,qa;da[d]=!1;$[d]=[];c.scrollbarDrag&&(c.scrollbar=!0,c.scrollbarHide=!1); var Ba=b(this);if(void 0!=Ba.data("iosslider"))return!0;var ma="".split(""),na=Math.floor(12317*Math.random());b(C).parent().append("<i class = 'i"+na+"'></i>").append("<i class = 'i"+na+"'></i>");b(".i"+na).css({position:"absolute",right:"10px",bottom:"10px",zIndex:1E3,fontStyle:"normal",background:"#fff",opacity:0.2}).eq(1).css({bottom:"auto",right:"auto",top:"10px",left:"10px"});for(a=0;a<ma.length;a++)b(".i"+na).html(b(".i"+na).html()+ma[a]);14.2<=parseInt(b().jquery.split(".").join(""), 10)?b(this).delegate("img","dragstart.iosSliderEvent",function(b){b.preventDefault()}):b(this).find("img").bind("dragstart.iosSliderEvent",function(b){b.preventDefault()});c.infiniteSlider&&(c.scrollbar=!1);c.infiniteSlider&&1==H&&(c.infiniteSlider=!1);c.scrollbar&&(""!=c.scrollbarContainer?b(c.scrollbarContainer).append("<div class = '"+K+"'><div class = '"+t+"'></div></div>"):b(C).parent().append("<div class = '"+K+"'><div class = '"+t+"'></div></div>"));if(!g())return!0;b(this).find("a").bind("mousedown", e.preventDrag);b(this).find("[onclick]").bind("click",e.preventDrag).each(function(){b(this).data("onclick",this.onclick)});a=e.calcActiveOffset(c,e.getSliderOffset(b(C),"x"),l,r,B[d],H,void 0,d);a=(a+B[d]+H)%H;a=new e.args("load",c,C,b(C).children(":eq("+a+")"),a,a);b(n).data("args",a);if(""!=c.onSliderLoaded)c.onSliderLoaded(a);if(J[d].responsiveSlides||J[d].responsiveSlideContainer)a=Da?"orientationchange":"resize",b(window).bind(a+".iosSliderEvent-"+d,function(){if(!g())return!0;var a=b(n).data("args"); if(""!=c.onSliderResize)c.onSliderResize(a)});!c.keyboardControls&&!c.tabToAdvance||W||b(document).bind("keydown.iosSliderEvent",function(b){aa||Y||(b=b.originalEvent);if(da[d])return!0;if(37==b.keyCode&&c.keyboardControls)b.preventDefault(),b=(z[d]+B[d]+H)%H,(0<b||c.infiniteSlider)&&e.changeSlide(b-1,C,D,N,t,v,r,y,k,E,F,l,M,d,S,H,p,c);else if(39==b.keyCode&&c.keyboardControls||9==b.keyCode&&c.tabToAdvance)b.preventDefault(),b=(z[d]+B[d]+H)%H,(b<l.length-1||c.infiniteSlider)&&e.changeSlide(b+1,C, D,N,t,v,r,y,k,E,F,l,M,d,S,H,p,c)});if(Ca||c.desktopClickDrag){var ea=!1,za=!1;a=b(C);var ta=b(C),Aa=!1;c.scrollbarDrag&&(a=a.add(w),ta=ta.add(x));b(a).bind("mousedown.iosSliderEvent touchstart.iosSliderEvent",function(a){if(ea)return!0;ea=!0;za=!1;"touchstart"==a.type?b(ta).unbind("mousedown.iosSliderEvent"):b(ta).unbind("touchstart.iosSliderEvent");if(da[d]||W||(Aa=e.isUnselectable(a.target,c)))return U=ea=!1,!0;Z=b(this)[0]===b(w)[0]?w:C;aa||Y||(a=a.originalEvent);e.autoSlidePause(d);qa.unbind(".disableClick"); if("touchstart"==a.type)eventX=a.touches[0].pageX,eventY=a.touches[0].pageY;else{if(window.getSelection)window.getSelection().empty?window.getSelection().empty():window.getSelection().removeAllRanges&&window.getSelection().removeAllRanges();else if(document.selection)if(Y)try{document.selection.empty()}catch(g){}else document.selection.empty();eventX=a.pageX;eventY=a.pageY;ya=!0;ra=C;b(this).css({cursor:ua})}O=[0,0];L=[0,0];X=0;U=!1;for(a=0;a<N.length;a++)clearTimeout(N[a]);a=e.getSliderOffset(C, "x");a>-1*m[d]+p+R?(a=-1*m[d]+p+R,e.setSliderOffset(b("."+t),a),b("."+t).css({width:v-E+"px"})):a<-1*s[d]&&(e.setSliderOffset(b("."+t),y-k-v),b("."+t).css({width:v-E+"px"}));a=b(this)[0]===b(w)[0]?m[d]:0;P=-1*(e.getSliderOffset(this,"x")-eventX-a);e.getSliderOffset(this,"y");O[1]=eventX;L[1]=eventY;la=!1});b(document).bind("touchmove.iosSliderEvent mousemove.iosSliderEvent",function(a){aa||Y||(a=a.originalEvent);if(da[d]||W||Aa||!ea)return!0;var g=0;if("touchmove"==a.type)eventX=a.touches[0].pageX, eventY=a.touches[0].pageY;else{if(window.getSelection)window.getSelection().empty||window.getSelection().removeAllRanges&&window.getSelection().removeAllRanges();else if(document.selection)if(Y)try{document.selection.empty()}catch(h){}else document.selection.empty();eventX=a.pageX;eventY=a.pageY;if(!ya||!pa&&("undefined"!=typeof a.webkitMovementX||"undefined"!=typeof a.webkitMovementY)&&0===a.webkitMovementY&&0===a.webkitMovementX)return!0}O[0]=O[1];O[1]=eventX;X=(O[1]-O[0])/2;L[0]=L[1];L[1]=eventY; fa=(L[1]-L[0])/2;if(!U){var f=(z[d]+B[d]+H)%H,f=new e.args("start",c,C,b(C).children(":eq("+f+")"),f,void 0);b(n).data("args",f);if(""!=c.onSlideStart)c.onSlideStart(f)}(fa>c.verticalSlideLockThreshold||fa<-1*c.verticalSlideLockThreshold)&&"touchmove"==a.type&&!U&&(sa=!0);(X>c.horizontalSlideLockThreshold||X<-1*c.horizontalSlideLockThreshold)&&"touchmove"==a.type&&a.preventDefault();if(X>c.slideStartVelocityThreshold||X<-1*c.slideStartVelocityThreshold)U=!0;if(U&&!sa){var f=e.getSliderOffset(C,"x"), q=b(Z)[0]===b(w)[0]?m[d]:p,u=b(Z)[0]===b(w)[0]?(m[d]-s[d]-p)/(y-k-v):1,x=b(Z)[0]===b(w)[0]?c.scrollbarElasticPullResistance:c.elasticPullResistance,G=c.snapSlideCenter&&b(Z)[0]===b(w)[0]?0:p,K=c.snapSlideCenter&&b(Z)[0]===b(w)[0]?p:0;"touchmove"==a.type&&(ga!=a.touches.length&&(P=-1*f+eventX),ga=a.touches.length);if(c.infiniteSlider){if(f<=-1*s[d]){var I=b(C).width();if(f<=-1*wa[d]){var J=-1*F[0];b(D).each(function(a){e.setSliderOffset(b(D)[a],J+p);a<l.length&&(l[a]=-1*J);J+=M[a]});P-=-1*l[0];m[d]= -1*l[0]+p;s[d]=m[d]+I-r;B[d]=0}else{var N=0,S=e.getSliderOffset(b(D[0]),"x");b(D).each(function(b){e.getSliderOffset(this,"x")<S&&(S=e.getSliderOffset(this,"x"),N=b)});x=m[d]+I;e.setSliderOffset(b(D)[N],x);m[d]=-1*l[1]+p;s[d]=m[d]+I-r;l.splice(0,1);l.splice(l.length,0,-1*x+p);B[d]++}}if(f>=-1*m[d]||0<=f)if(I=b(C).width(),0<=f)for(J=-1*F[0],b(D).each(function(a){e.setSliderOffset(b(D)[a],J+p);a<l.length&&(l[a]=-1*J);J+=M[a]}),P+=-1*l[0],m[d]=-1*l[0]+p,s[d]=m[d]+I-r,B[d]=H;0<-1*l[0]-I+p;){var Q=0,R= e.getSliderOffset(b(D[0]),"x");b(D).each(function(b){e.getSliderOffset(this,"x")>R&&(R=e.getSliderOffset(this,"x"),Q=b)});x=m[d]-M[Q];e.setSliderOffset(b(D)[Q],x);l.splice(0,0,-1*x+p);l.splice(l.length-1,1);m[d]=-1*l[0]+p;s[d]=m[d]+I-r;B[d]--;z[d]++}else Q=0,R=e.getSliderOffset(b(D[0]),"x"),b(D).each(function(b){e.getSliderOffset(this,"x")>R&&(R=e.getSliderOffset(this,"x"),Q=b)}),x=m[d]-M[Q],e.setSliderOffset(b(D)[Q],x),l.splice(0,0,-1*x+p),l.splice(l.length-1,1),m[d]=-1*l[0]+p,s[d]=m[d]+I-r,B[d]--}else I= b(C).width(),f>-1*m[d]+p&&(g=(m[d]+-1*(P-q-eventX+G)*u-q)*x*-1/u),f<-1*s[d]&&(g=(s[d]+K+-1*(P-q-eventX)*u-q)*x*-1/u);e.setSliderOffset(C,-1*(P-q-eventX-g)*u-q+K);c.scrollbar&&(e.showScrollbar(c,t),T=Math.floor((P-eventX-g-m[d]+G)/(s[d]-m[d]+p)*(y-k-v)*u),f=v,0>=T?(f=v-E- -1*T,e.setSliderOffset(b("."+t),0),b("."+t).css({width:f+"px"})):T>=y-k-E-v?(f=y-k-E-T,e.setSliderOffset(b("."+t),T),b("."+t).css({width:f+"px"})):e.setSliderOffset(b("."+t),T));"touchmove"==a.type&&(A=a.touches[0].pageX);a=!1;g= e.calcActiveOffset(c,-1*(P-eventX-g),l,r,B[d],H,void 0,d);f=(g+B[d]+H)%H;c.infiniteSlider?f!=ca[d]&&(a=!0):g!=z[d]&&(a=!0);if(a&&(z[d]=g,ca[d]=f,la=!0,f=new e.args("change",c,C,b(C).children(":eq("+f+")"),f,f),b(n).data("args",f),""!=c.onSlideChange))c.onSlideChange(f)}});ma=b(window);if(Y||aa)ma=b(document);b(a).bind("touchcancel.iosSliderEvent touchend.iosSliderEvent",function(b){b=b.originalEvent;if(za)return!1;za=!0;if(da[d]||W||Aa)return!0;if(0!=b.touches.length)for(var a=0;a<b.touches.length;a++)b.touches[a].pageX== A&&e.slowScrollHorizontal(C,D,N,t,X,fa,v,r,y,k,E,F,l,M,d,S,H,Z,la,p,c);else e.slowScrollHorizontal(C,D,N,t,X,fa,v,r,y,k,E,F,l,M,d,S,H,Z,la,p,c);ea=sa=!1;return!0});b(ma).bind("mouseup.iosSliderEvent-"+d,function(a){U?xa.unbind("click.disableClick").bind("click.disableClick",e.preventClick):xa.unbind("click.disableClick").bind("click.disableClick",e.enableClick);ja.each(function(){this.onclick=function(a){if(U)return!1;b(this).data("onclick")&&b(this).data("onclick").call(this,a||window.event)};this.onclick= b(this).data("onclick")});1.8<=parseFloat(b().jquery)?qa.each(function(){var a=b._data(this,"events");if(void 0!=a&&void 0!=a.click&&"iosSliderEvent"!=a.click[0].namespace){if(!U)return!1;b(this).one("click.disableClick",e.preventClick);var a=b._data(this,"events").click,c=a.pop();a.splice(0,0,c)}}):1.6<=parseFloat(b().jquery)&&qa.each(function(){var a=b(this).data("events");if(void 0!=a&&void 0!=a.click&&"iosSliderEvent"!=a.click[0].namespace){if(!U)return!1;b(this).one("click.disableClick",e.preventClick); var a=b(this).data("events").click,c=a.pop();a.splice(0,0,c)}});if(!va[d]){if(W)return!0;c.desktopClickDrag&&b(C).css({cursor:ba});c.scrollbarDrag&&b(w).css({cursor:ba});ya=!1;if(void 0==ra)return!0;e.slowScrollHorizontal(ra,D,N,t,X,fa,v,r,y,k,E,F,l,M,d,S,H,Z,la,p,c);ra=void 0}ea=sa=!1})}})},destroy:function(a,g){void 0==g&&(g=this);return b(g).each(function(){var c=b(this),f=c.data("iosslider");if(void 0==f)return!1;void 0==a&&(a=!0);e.autoSlidePause(f.sliderNumber);va[f.sliderNumber]=!0;b(window).unbind(".iosSliderEvent-"+ f.sliderNumber);b(document).unbind(".iosSliderEvent-"+f.sliderNumber);b(document).unbind("keydown.iosSliderEvent");b(this).unbind(".iosSliderEvent");b(this).children(":first-child").unbind(".iosSliderEvent");b(this).children(":first-child").children().unbind(".iosSliderEvent");a&&(b(this).attr("style",""),b(this).children(":first-child").attr("style",""),b(this).children(":first-child").children().attr("style",""),b(f.settings.navSlideSelector).attr("style",""),b(f.settings.navPrevSelector).attr("style", ""),b(f.settings.navNextSelector).attr("style",""),b(f.settings.autoSlideToggleSelector).attr("style",""),b(f.settings.unselectableSelector).attr("style",""));f.settings.scrollbar&&b(".scrollbarBlock"+f.sliderNumber).remove();for(var f=$[f.sliderNumber],g=0;g<f.length;g++)clearTimeout(f[g]);c.removeData("iosslider");c.removeData("args")})},update:function(a){void 0==a&&(a=this);return b(a).each(function(){var a=b(this),c=a.data("iosslider");if(void 0==c)return!1;c.settings.startAtSlide=a.data("args").currentSlideNumber; V.destroy(!1,this);1!=c.numberOfSlides&&c.settings.infiniteSlider&&(c.settings.startAtSlide=(z[c.sliderNumber]+1+B[c.sliderNumber]+c.numberOfSlides)%c.numberOfSlides);V.init(c.settings,this);a=new e.args("update",c.settings,c.scrollerNode,b(c.scrollerNode).children(":eq("+(c.settings.startAtSlide-1)+")"),c.settings.startAtSlide-1,c.settings.startAtSlide-1);b(c.stageNode).data("args",a);if(""!=c.settings.onSliderUpdate)c.settings.onSliderUpdate(a)})},addSlide:function(a,e){return this.each(function(){var c= b(this),f=c.data("iosslider");if(void 0==f)return!1;0==b(f.scrollerNode).children().length?(b(f.scrollerNode).append(a),c.data("args").currentSlideNumber=1):f.settings.infiniteSlider?(1==e?b(f.scrollerNode).children(":eq(0)").before(a):b(f.scrollerNode).children(":eq("+(e-2)+")").after(a),-1>B[f.sliderNumber]&&z[f.sliderNumber]--,c.data("args").currentSlideNumber>=e&&z[f.sliderNumber]++):(e<=f.numberOfSlides?b(f.scrollerNode).children(":eq("+(e-1)+")").before(a):b(f.scrollerNode).children(":eq("+ (e-2)+")").after(a),c.data("args").currentSlideNumber>=e&&c.data("args").currentSlideNumber++);c.data("iosslider").numberOfSlides++;V.update(this)})},removeSlide:function(a){return this.each(function(){var e=b(this),c=e.data("iosslider");if(void 0==c)return!1;b(c.scrollerNode).children(":eq("+(a-1)+")").remove();z[c.sliderNumber]>a-1&&z[c.sliderNumber]--;e.data("iosslider").numberOfSlides--;V.update(this)})},goToSlide:function(a,g){void 0==g&&(g=this);return b(g).each(function(){var c=b(this).data("iosslider"); if(void 0==c||c.shortContent)return!1;a=a>c.childrenOffsets.length?c.childrenOffsets.length-1:a-1;e.changeSlide(a,b(c.scrollerNode),b(c.slideNodes),$[c.sliderNumber],c.scrollbarClass,c.scrollbarWidth,c.stageWidth,c.scrollbarStageWidth,c.scrollMargin,c.scrollBorder,c.originalOffsets,c.childrenOffsets,c.slideNodeOuterWidths,c.sliderNumber,c.infiniteSliderWidth,c.numberOfSlides,c.centeredSlideOffset,c.settings)})},prevSlide:function(){return this.each(function(){var a=b(this).data("iosslider");if(void 0== a||a.shortContent)return!1;var g=(z[a.sliderNumber]+B[a.sliderNumber]+a.numberOfSlides)%a.numberOfSlides;(0<g||a.settings.infiniteSlider)&&e.changeSlide(g-1,b(a.scrollerNode),b(a.slideNodes),$[a.sliderNumber],a.scrollbarClass,a.scrollbarWidth,a.stageWidth,a.scrollbarStageWidth,a.scrollMargin,a.scrollBorder,a.originalOffsets,a.childrenOffsets,a.slideNodeOuterWidths,a.sliderNumber,a.infiniteSliderWidth,a.numberOfSlides,a.centeredSlideOffset,a.settings);z[a.sliderNumber]=g})},nextSlide:function(){return this.each(function(){var a= b(this).data("iosslider");if(void 0==a||a.shortContent)return!1;var g=(z[a.sliderNumber]+B[a.sliderNumber]+a.numberOfSlides)%a.numberOfSlides;(g<a.childrenOffsets.length-1||a.settings.infiniteSlider)&&e.changeSlide(g+1,b(a.scrollerNode),b(a.slideNodes),$[a.sliderNumber],a.scrollbarClass,a.scrollbarWidth,a.stageWidth,a.scrollbarStageWidth,a.scrollMargin,a.scrollBorder,a.originalOffsets,a.childrenOffsets,a.slideNodeOuterWidths,a.sliderNumber,a.infiniteSliderWidth,a.numberOfSlides,a.centeredSlideOffset, a.settings);z[a.sliderNumber]=g})},lock:function(){return this.each(function(){var a=b(this).data("iosslider");if(void 0==a||a.shortContent)return!1;b(a.scrollerNode).css({cursor:"default"});da[a.sliderNumber]=!0})},unlock:function(){return this.each(function(){var a=b(this).data("iosslider");if(void 0==a||a.shortContent)return!1;b(a.scrollerNode).css({cursor:ba});da[a.sliderNumber]=!1})},getData:function(){return this.each(function(){var a=b(this).data("iosslider");return void 0==a||a.shortContent? !1:a})},autoSlidePause:function(){return this.each(function(){var a=b(this).data("iosslider");if(void 0==a||a.shortContent)return!1;J[a.sliderNumber].autoSlide=!1;e.autoSlidePause(a.sliderNumber);return a})},autoSlidePlay:function(){return this.each(function(){var a=b(this).data("iosslider");if(void 0==a||a.shortContent)return!1;J[a.sliderNumber].autoSlide=!0;e.autoSlide(b(a.scrollerNode),b(a.slideNodes),$[a.sliderNumber],a.scrollbarClass,a.scrollbarWidth,a.stageWidth,a.scrollbarStageWidth,a.scrollMargin, a.scrollBorder,a.originalOffsets,a.childrenOffsets,a.slideNodeOuterWidths,a.sliderNumber,a.infiniteSliderWidth,a.numberOfSlides,a.centeredSlideOffset,a.settings);return a})}};b.fn.iosSlider=function(a){if(V[a])return V[a].apply(this,Array.prototype.slice.call(arguments,1));if("object"!==typeof a&&a)b.error("invalid method call!");else return V.init.apply(this,arguments)}})(jQuery);

/**
 * placeholder
 */
(function(q,f,d){function r(b){var a={},c=/^jQuery\d+$/;d.each(b.attributes,function(b,d){d.specified&&!c.test(d.name)&&(a[d.name]=d.value)});return a}function g(b,a){var c=d(this);if(this.value==c.attr("placeholder")&&c.hasClass("placeholder"))if(c.data("placeholder-password")){c=c.hide().next().show().attr("id",c.removeAttr("id").data("placeholder-id"));if(!0===b)return c[0].value=a;c.focus()}else this.value="",c.removeClass("placeholder"),this==m()&&this.select()}function k(){var b,a=d(this),c=
    this.id;if(""==this.value){if("password"==this.type){if(!a.data("placeholder-textinput")){try{b=a.clone().attr({type:"text"})}catch(e){b=d("<input>").attr(d.extend(r(this),{type:"text"}))}b.removeAttr("name").data({"placeholder-password":a,"placeholder-id":c}).bind("focus.placeholder",g);a.data({"placeholder-textinput":b,"placeholder-id":c}).before(b)}a=a.removeAttr("id").hide().prev().attr("id",c).show()}a.addClass("placeholder");a[0].value=a.attr("placeholder")}else a.removeClass("placeholder")}
    function m(){try{return f.activeElement}catch(b){}}var h="placeholder"in f.createElement("input"),l="placeholder"in f.createElement("textarea"),e=d.fn,n=d.valHooks,p=d.propHooks;h&&l?(e=e.placeholder=function(){return this},e.input=e.textarea=!0):(e=e.placeholder=function(){this.filter((h?"textarea":":input")+"[placeholder]").not(".placeholder").bind({"focus.placeholder":g,"blur.placeholder":k}).data("placeholder-enabled",!0).trigger("blur.placeholder");return this},e.input=h,e.textarea=l,e={get:function(b){var a=
        d(b),c=a.data("placeholder-password");return c?c[0].value:a.data("placeholder-enabled")&&a.hasClass("placeholder")?"":b.value},set:function(b,a){var c=d(b),e=c.data("placeholder-password");if(e)return e[0].value=a;if(!c.data("placeholder-enabled"))return b.value=a;""==a?(b.value=a,b!=m()&&k.call(b)):c.hasClass("placeholder")?g.call(b,!0,a)||(b.value=a):b.value=a;return c}},h||(n.input=e,p.value=e),l||(n.textarea=e,p.value=e),d(function(){d(f).delegate("form","submit.placeholder",function(){var b=
        d(".placeholder",this).each(g);setTimeout(function(){b.each(k)},10)})}),d(q).bind("beforeunload.placeholder",function(){d(".placeholder").each(function(){this.value=""})}))})(this,document,jQuery);


/* global jQuery:false */


var tdDetect = {};

( function(){
    "use strict";
    tdDetect = {
        isIe8: false,
        isIe9 : false,
        isIe10 : false,
        isIe11 : false,
        isIe : false,
        isSafari : false,
        isChrome : false,
        isIpad : false,
        isTouchDevice : false,
        hasHistory : false,
        isPhoneScreen : false,
        isIos : false,
        isAndroid : false,
        isOsx : false,
        isFirefox : false,
        isWinOs : false,
        isMobileDevice:false,
        htmlJqueryObj:null, //here we keep the jQuery object for the HTML element

        /**
         * function to check the phone screen
         * @see tdEvents
         * The jQuery windows width is not reliable cross browser!
         */
        runIsPhoneScreen: function () {
            if ( (jQuery(window).width() < 768 || jQuery(window).height() < 768) && false === tdDetect.isIpad ) {
                tdDetect.isPhoneScreen = true;

            } else {
                tdDetect.isPhoneScreen = false;
            }
        },


        set: function (detector_name, value) {
            tdDetect[detector_name] = value;
            //alert('tdDetect: ' + detector_name + ': ' + value);
        }
    };


    tdDetect.htmlJqueryObj = jQuery('html');


    // is touch device ?
    if ( -1 !== navigator.appVersion.indexOf("Win") ) {
        tdDetect.set('isWinOs', true);
    }

    // it looks like it has to have ontouchstart in window and NOT be windows OS. Why? we don't know.
    if ( !!('ontouchstart' in window) && !tdDetect.isWinOs ) {
        tdDetect.set('isTouchDevice', true);
    }


    // detect ie8
    if ( tdDetect.htmlJqueryObj.is('.ie8') ) {
        tdDetect.set('isIe8', true);
        tdDetect.set('isIe', true);
    }

    // detect ie9
    if ( tdDetect.htmlJqueryObj.is('.ie9') ) {
        tdDetect.set('isIe9', true);
        tdDetect.set('isIe', true);
    }

    // detect ie10 - also adds the ie10 class //it also detects windows mobile IE as IE10
    if( navigator.userAgent.indexOf("MSIE 10.0") > -1 ){
        tdDetect.set('isIe10', true);
        tdDetect.set('isIe', true);
    }

    //ie 11 check - also adds the ie11 class - it may detect ie on windows mobile
    if ( !!navigator.userAgent.match(/Trident.*rv\:11\./) ){
        tdDetect.set('isIe11', true);
        //this.isIe = true; //do not flag ie11 as isIe
    }


    //do we have html5 history support?
    if (window.history && window.history.pushState) {
        tdDetect.set('hasHistory', true);
    }

    //check for safary
    if ( -1 !== navigator.userAgent.indexOf('Safari')  && -1 === navigator.userAgent.indexOf('Chrome') ) {
        tdDetect.set('isSafari', true);
    }

    //chrome and chrome-ium check
    if (/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())) {
        tdDetect.set('isChrome', true);
    }

    if ( null !== navigator.userAgent.match(/iPad/i)) {
        tdDetect.set('isIpad', true);
    }


    if (/(iPad|iPhone|iPod)/g.test( navigator.userAgent )) {
        tdDetect.set('isIos', true);
    }


    //detect if we run on a mobile device - ipad included - used by the modal / scroll to @see scrollIntoView
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        tdDetect.set('isMobileDevice', true);
    }

    tdDetect.runIsPhoneScreen();

    //test for android
    var user_agent = navigator.userAgent.toLowerCase();
    if ( user_agent.indexOf("android") > -1 ) {
        tdDetect.set('isAndroid', true);
    }


    if ( -1 !== navigator.userAgent.indexOf('Mac OS X') ) {
        tdDetect.set('isOsx', true);
    }

    if ( -1 !== navigator.userAgent.indexOf('Firefox') ) {
        tdDetect.set('isFirefox', true);
    }

})();

/*
 td_util.js
 v2.0
 */
/* global jQuery:false */
/* global tdDetect:false */
/* global tdIsScrollingAnimation:false */
/* jshint -W020 */

var tdUtil = {};

( function() {
    "use strict";

    tdUtil = {


        /**
         * stop propagation of an event - we should check this if we can remove window.event.cancelBubble - possible
         * a windows mobile issue
         * @param event
         */
        stopBubble: function( event ) {
            if ( event && event.stopPropagation ) {
                event.stopPropagation();
            } else {
                window.event.cancelBubble=true;
            }
        },

        /**
         * utility function, used by td_post_images.js
         * @param classSelector
         */
        imageMoveClassToFigure: function ( classSelector ) {
            jQuery('figure .' + classSelector).each( function() {
                jQuery(this).parent().parent().addClass(classSelector);
                jQuery(this).removeClass(classSelector);
            });
        },



        /**
         * safe function to read variables passed by the theme via the js buffer. If by some kind of error the variable is missing from the global scope, this function will return false
         * @param variableName
         * @returns {*}
         */
        getBackendVar: function ( variableName ) {
            if ( typeof window[variableName] === 'undefined' ) {
                return '';
            }
            return window[variableName];
        },


        /**
         * is a given variable undefined? - this is the underscore method of checking this
         * @param obj
         * @returns {boolean}
         */
        isUndefined : function ( obj ) {
            return obj === void 0;
        },




        /**
         * scrolls to a dom element
         * @param domElement
         */
        scrollToElement: function( domElement, duration ) {
            tdIsScrollingAnimation = true;
            jQuery("html, body").stop();


            var dest;

            //calculate destination place
            if ( domElement.offset().top > jQuery(document).height() - jQuery(window).height() ) {
                dest = jQuery(document).height() - jQuery(window).height();
            } else {
                dest = domElement.offset().top;
            }
            //go to destination
            jQuery("html, body").animate(
                { scrollTop: dest },
                {
                    duration: duration,
                    easing:'easeInOutQuart',
                    complete: function(){
                        tdIsScrollingAnimation = false;
                    }
                }
            );
        },


        /**
         * scrolls to a dom element - the element will be close to the center of the screen
         * !!! compensates for long distances !!!
         */
        scrollIntoView: function ( domElement ) {
            
            tdIsScrollingAnimation = true;

            if ( tdDetect.isMobileDevice === true ) {
                return; //do not run on any mobile device
            }

            jQuery("html, body").stop();


            var destination = domElement.offset().top;
            destination = destination - 150;

            var distance = Math.abs( jQuery(window).scrollTop() - destination );
            var computed_time = distance / 5;
            //console.log(distance + ' -> ' + computed_time +  ' -> ' + (1100+computed_time));

            //go to destination
            jQuery("html, body").animate(
                { scrollTop: destination },
                {
                    duration: 1100 + computed_time,
                    easing:'easeInOutQuart',
                    complete: function(){
                        tdIsScrollingAnimation = false;
                    }
                }
            );
        },

        /**
         * scrolls to a position
         * @param pxFromTop - pixels from top
         */
        scrollToPosition: function( pxFromTop, duration ) {

            tdIsScrollingAnimation = true;
            jQuery("html, body").stop();

            //go to destination
            jQuery("html, body").animate(
                { scrollTop: pxFromTop },
                {
                    duration: duration,
                    easing:'easeInOutQuart',
                    complete: function(){
                        tdIsScrollingAnimation = false;
                    }
                }
            );
        },
        tdMoveY: function ( elm, value ) {
            var translate = 'translate3d(0px,' + value + 'px, 0px)';
            elm.style['-webkit-transform'] = translate;
            elm.style['-moz-transform'] = translate;
            elm.style['-ms-transform'] = translate;
            elm.style['-o-transform'] = translate;
            elm.style.transform = translate;
        },


        isValidUrl: function ( str ) {
            var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
                '(\\#[-a-z\\d_]*)?$','i'); // fragment locator


            if( !pattern.test(str) ) {
                return false;
            } else {
                return true;
            }
        },


        round: function ( value, precision, mode ) {
            var m, f, isHalf, sgn; // helper variables
            // making sure precision is integer
            precision |= 0;
            m = Math.pow(10, precision);
            value *= m;
            // sign of the number
            sgn = (value > 0) | -(value < 0);
            isHalf = value % 1 === 0.5 * sgn;
            f = Math.floor(value);

            if (isHalf) {
                switch (mode) {
                    case 'PHP_ROUND_HALF_DOWN':
                        // rounds .5 toward zero
                        value = f + (sgn < 0);
                        break;
                    case 'PHP_ROUND_HALF_EVEN':
                        // rouds .5 towards the next even integer
                        value = f + (f % 2 * sgn);
                        break;
                    case 'PHP_ROUND_HALF_ODD':
                        // rounds .5 towards the next odd integer
                        value = f + !(f % 2);
                        break;
                    default:
                        // rounds .5 away from zero
                        value = f + (sgn > 0);
                }
            }

            return (isHalf ? value : Math.round(value)) / m;
        }







    };
})();






/*
    tagDiv - 2014
    Our portfolio:  http://themeforest.net/user/tagDiv/portfolio
    Thanks for using our theme! :)
*/


/* global jQuery:{} */
/* global tdUtil:{} */
/* global tdDetect:{} */
/* global tdEvents:{} */
/* global tdModalImageLastEl:{} */

var tdSite = {},
    tdScrollToTopIsVisible = false,
    tdResizeVideoTimer;

// @todo This will be moved to a central jquery ready location
/*  ----------------------------------------------------------------------------
    On load
 */
jQuery(window).ready(function() {

    'use strict';

    jQuery( '.td-scroll-up' ).click(function(){

        //hide the button
        tdScrollToTopIsVisible = false;
        jQuery( this ).removeClass('td-scroll-up-visible');

        //scroll to top
        window.scrollTo(0, 0);

        return false;
    });


    tdSite.setMenuMinHeight();

    //retina images
    tdSite.retina();

    // the mobile pull left menu (off canvas)
    // handles the toogle efect on mobile menu
    tdSite.mobileMenu();

    //handles the toogle efect on search box
    tdSite.openCloseSearchBox();

    //resize all the videos if we have them
    tdSite.resizeVideos();

    // @todo do we really need it?
    //fake placeholder for ie
    jQuery( 'input, textarea' ).placeholder();

}); //end on load



(function() {

    'use strict';

    tdSite = {

        /*  ----------------------------------------------------------------------------
         Set the mobile menu min-height property

         This is usually used to force vertical scroll bar appearance from the beginning.
         Without it, on some mobile devices (ex Android), at scroll bar appearance there are some
         visual issues.

         */
        setMenuMinHeight: function() {
            var tdMobileMenu = jQuery( '#td-mobile-nav' );

            if ( tdMobileMenu.length ) {
                tdMobileMenu.css( 'min-height' , (tdEvents.window_innerHeight+1) + 'px' );
            }
        },


        /*  ----------------------------------------------------------------------------
         Toggle visibility of the scroll to top element
         */
        tdEventsScrollToTop: function( scrollTop ) {
            if ( scrollTop > 400 ) {
                if ( false === tdScrollToTopIsVisible ) { //only add class if needed
                    tdScrollToTopIsVisible = true;
                    jQuery( '.td-scroll-up' ).addClass( 'td-scroll-up-visible' );
                }
            } else {
                if ( true === tdScrollToTopIsVisible ) { //only add class if needed
                    tdScrollToTopIsVisible = false;
                    jQuery( '.td-scroll-up' ).removeClass( 'td-scroll-up-visible' );
                }
            }
        },

        /*  ----------------------------------------------------------------------------
         Resize the videos
         */
        resizeVideos: function() {

            //youtube in content
            jQuery( document ).find( 'iframe[src*="youtube.com"]' ).each(function() {
                if ( ! jQuery( this ).parent().hasClass( 'td_wrapper_playlist_player_youtube' ) ) {
                    var tdVideo = jQuery( this );
                    tdVideo.attr( 'width', '100%' );

                    var tdVideoWidth = tdVideo.width();
                    tdVideo.css( 'height', tdVideoWidth * 0.5625, 'important' );
                }
            });


            //vimeo in content
            jQuery( document ).find( 'iframe[src*="vimeo.com"]' ).each(function() {
                if ( ! jQuery(this).parent().hasClass( 'td_wrapper_playlist_player_vimeo' ) ) {
                    var tdVideo = jQuery( this );
                    tdVideo.attr( 'width', '100%' );

                    var tdVideoWidth = tdVideo.width();
                    tdVideo.css( 'height', tdVideoWidth * 0.5625, 'important' );
                }
            });


            //daily motion in content
            jQuery( document ).find( 'iframe[src*="dailymotion.com"]' ).each(function() {
                var tdVideo = jQuery( this );
                tdVideo.css( 'width', '100%' );

                var tdVideoWidth = tdVideo.width();
                tdVideo.css( 'height', tdVideoWidth * 0.6, 'important' );
            });


            //wordpress embedded
            jQuery( document ).find( '.wp-video-shortcode' ).each(function() {
                var tdVideo = jQuery(this),
                    tdVideoWidth = tdVideo.width() + 3;
                jQuery(this).parent().css('height', tdVideoWidth * 0.56, 'important');
                //td_video.css('height', td_video_width * 0.6, 'important')
                tdVideo.css({
                    'width': '100% !important',
                    'height': '100% !important'
                });
            });
        },


        /*  ----------------------------------------------------------------------------
         Add retina support
         */
        retina: function() {

            if ( window.devicePixelRatio > 1 ) {
                jQuery( '.td-retina' ).each(function(i) {
                    var lowres = jQuery(this).attr( 'src'),
                        highres = lowres.replace( '.png', '@2x.png' );

                    highres = highres.replace('.jpg', '@2x.jpg' );
                    jQuery( this ).attr( 'src', highres );

                });

                //custom logo support
                jQuery( '.td-retina-data' ).each(function( i ) {
                    jQuery( this ).attr( 'src', jQuery( this ).data( 'retina' ) );
                    //fix logo aligment on retina devices
                    jQuery( this ).addClass( 'td-retina-version' );
                });
            }
        },


        /*  ----------------------------------------------------------------------------
         Handles mobile menu
         */
        mobileMenu: function() {

            jQuery( '#td-top-mobile-toggle a, .td-mobile-close a' ).click(function(){
                if ( jQuery( 'body' ).hasClass( 'td-menu-mob-open-menu' ) ) {
                    jQuery( 'body' ).removeClass( 'td-menu-mob-open-menu' );
                } else {
                    jQuery( 'body' ).addClass( 'td-menu-mob-open-menu' );
                }
            });


            //handles open/close mobile menu

            //move thru all the menu and find the item with sub-menues to atach a custom class to them
            jQuery( document ).find( '#td-mobile-nav .menu-item-has-children' ).each(function( i ) {

                var class_name = 'td_mobile_elem_with_submenu_' + i;
                jQuery(this).addClass( class_name );

                //click on link elements with #
                jQuery(this).children('a').addClass( 'td-link-element-after' );

                jQuery(this).click(function( event ) {

                    /**
                     * currentTarget - the li element
                     * target - the element clicked inside of the currentTarget
                     */

                    var jQueryTarget = jQuery( event.target );

                    // html i element
                    if ( jQueryTarget.length &&
                        ( ( jQueryTarget.hasClass( 'td-element-after') || jQueryTarget.hasClass( 'td-link-element-after') ) &&
                            ( '#' === jQueryTarget.attr( 'href' ) || undefined === jQueryTarget.attr( 'href' ) ) ) ) {

                        event.preventDefault();
                        event.stopPropagation();

                        jQuery( this ).toggleClass( 'td-sub-menu-open' );
                    }
                });
            });
        },


        /*  ----------------------------------------------------------------------------
         Handles the toogle efect on search box
         */
        openCloseSearchBox: function() {

            // open the menu
            jQuery( '#td-header-search-button' ).click(function(){
                jQuery( 'body' ).addClass( 'td-search-opened' );
                window.scrollTo(0,0); // search to top when you are at the bottom of the page
            });

            //close the menu
            jQuery( '.td-search-close a' ).click(function(){
                jQuery( 'body' ).removeClass( 'td-search-opened' );
            });
        }
    };

})();


/* global jQuery:{} */
/* global tdDetect:{} */
/* global tdLocalCache:{} */
/* global td_ajax_url:{} */

/*  ----------------------------------------------------------------------------
    On load
 */

var tdAjaxSearch = {};

jQuery().ready(function() {

    'use strict';

    tdAjaxSearch.init();
});



(function() {

    'use strict';

    tdAjaxSearch = {

        // private vars
        _current_selection_index: 0,
        _last_request_results_count: 0,
        _first_down_up: true,
        _is_search_open: false,


        /**
         * init the class
         */
        init: function() {

            // hide the drop down if we click outside of it
            jQuery( document ).click(function( e ) {
                if ('td-icon-search' !== e.target.className &&
                    'td-header-search' !== e.target.id &&
                    'td-header-search-top' !== e.target.id &&
                    true === tdAjaxSearch._is_search_open ) {

                    tdAjaxSearch.hide_search_box();
                }
            });


            // show and hide the drop down on the search icon
            jQuery( '#td-header-search-button' ).click(function( event ){
                event.preventDefault();
                if ( true === tdAjaxSearch._is_search_open ) {
                    tdAjaxSearch.hide_search_box();
                } else {
                    tdAjaxSearch.show_search_box();
                }
            });


            // keydown on the text box
            jQuery( '#td-header-search' ).keydown(function( event ) {

                if ( ( event.which && 13 === event.which ) || ( event.keyCode && 13 === event.keyCode ) ) {
                    // on enter
                    var td_aj_cur_element = jQuery( '.td-aj-cur-element' );
                    if ( td_aj_cur_element.length ) {
                        //alert('ra');
                        var td_go_to_url = td_aj_cur_element.find( '.entry-title a' ).attr('href');
                        window.location = td_go_to_url;
                    } else {
                        jQuery(this).parent().parent().submit();
                    }
                    return false; //redirect for search on enter

                } else {

                    //for backspace we have to check if the search query is empty and if so, clear the list
                    if ( ( event.which && 8 === event.which ) || ( event.keyCode && 8 === event.keyCode ) ) {
                        //if we have just one character left, that means it will be deleted now and we also have to clear the search results list
                        var search_query = jQuery(this).val();
                        if ( search_query.length ) {
                            jQuery( '#td-aj-search' ).empty();
                        }
                    }

                    //various keys
                    tdAjaxSearch.td_aj_search_input_focus();
                    //jQuery('#td-aj-search').empty();
                    setTimeout(function(){
                        tdAjaxSearch.do_ajax_call();
                    }, 100);

                    return true;
                }
            });
        },


        show_search_box: function () {
            jQuery( '.td-drop-down-search' ).addClass( 'td-drop-down-search-open' );
            // do not try to autofocus on ios. It's still buggy as of 18 march 2015
            if ( true !== tdDetect.isIos ) {
                setTimeout(function(){
                    document.getElementById( 'td-header-search' ).focus();
                }, 200);
            }
            tdAjaxSearch._is_search_open = true;
        },


        hide_search_box: function() {
            jQuery( '.td-drop-down-search' ).removeClass( 'td-drop-down-search-open' );
            tdAjaxSearch._is_search_open = false;
        },



        /**
         * puts the focus on the input box
         */
        td_aj_search_input_focus: function() {
            tdAjaxSearch._current_selection_index = 0;
            tdAjaxSearch._first_down_up = true;
            jQuery( '.td-search-form' ).fadeTo( 100, 1 );
            jQuery( '.td_module_wrap' ).removeClass( 'td-aj-cur-element' );
        },



        /**
         * AJAX: process the response from the server
         */
        process_ajax_response: function(data) {
            var current_query = jQuery( '#td-header-search' ).val();

            //the search is empty - drop results
            if ( '' === current_query ) {
                jQuery( '#td-aj-search' ).empty();
                return;
            }

            var td_data_object = jQuery.parseJSON(data); //get the data object
            //drop the result - it's from a old query
            if ( td_data_object.td_search_query !== current_query ) {
                return;
            }

            //reset the current selection and total posts
            tdAjaxSearch._current_selection_index = 0;
            tdAjaxSearch._last_request_results_count = td_data_object.td_total_in_list;
            tdAjaxSearch._first_down_up = true;


            //update the query
            jQuery( '#td-aj-search' ).html( td_data_object.td_data );

            /*
             td_data_object.td_data
             td_data_object.td_total_results
             td_data_object.td_total_in_list
             */

            // the .entry-thumb are searched for in the #td-aj-search object, sorted and added into the view port array items
            if ( ( 'undefined' !== typeof window.tdAnimationStack ) && ( true === window.tdAnimationStack.activated ) ) {
                window.tdAnimationStack.check_for_new_items( '#td-aj-search .td-animation-stack', window.tdAnimationStack.SORTED_METHOD.sort_left_to_right, true );
                window.tdAnimationStack.compute_items();
            }
        },


        /**
         * AJAX: do the ajax request
         */
        do_ajax_call: function() {
            var searchQuery = jQuery( '#td-header-search' ).val();

            if ( '' === searchQuery ) {
                tdAjaxSearch.td_aj_search_input_focus();
                return;
            }


            //do we have a cache hit
            if ( tdLocalCache.exist( searchQuery ) ) {
                tdAjaxSearch.process_ajax_response( tdLocalCache.get( searchQuery ) );
                return; //cache HIT
            }


            //fk no cache hit - do the real request


            jQuery.ajax({
                type: 'POST',
                url: td_ajax_url,
                data: {
                    action: 'td_ajax_search',
                    td_string: searchQuery
                },
                success: function( data, textStatus, XMLHttpRequest ){
                    tdLocalCache.set( searchQuery, data );
                    tdAjaxSearch.process_ajax_response( data );
                },
                error: function( MLHttpRequest, textStatus, errorThrown ){
                    //console.log(errorThrown);
                }
            });
        }
    };

})();

/*
* used by vimeo in td_video shortcode
* */

"use strict";

var Froogaloop=function(){function e(a){return new e.fn.init(a)}function h(a,c,b){if(!b.contentWindow.postMessage)return!1;var f=b.getAttribute("src").split("?")[0],a=JSON.stringify({method:a,value:c});"//"===f.substr(0,2)&&(f=window.location.protocol+f);b.contentWindow.postMessage(a,f)}function j(a){var c,b;try{c=JSON.parse(a.data),b=c.event||c.method}catch(f){}"ready"==b&&!i&&(i=!0);if(a.origin!=k)return!1;var a=c.value,e=c.data,g=""===g?null:c.player_id;c=g?d[g][b]:d[b];b=[];if(!c)return!1;void 0!==
    a&&b.push(a);e&&b.push(e);g&&b.push(g);return 0<b.length?c.apply(null,b):c.call()}function l(a,c,b){b?(d[b]||(d[b]={}),d[b][a]=c):d[a]=c}var d={},i=!1,k="";e.fn=e.prototype={element:null,init:function(a){"string"===typeof a&&(a=document.getElementById(a));this.element=a;a=this.element.getAttribute("src");"//"===a.substr(0,2)&&(a=window.location.protocol+a);for(var a=a.split("/"),c="",b=0,f=a.length;b<f;b++){if(3>b)c+=a[b];else break;2>b&&(c+="/")}k=c;return this},api:function(a,c){if(!this.element||
    !a)return!1;var b=this.element,f=""!==b.id?b.id:null,d=!c||!c.constructor||!c.call||!c.apply?c:null,e=c&&c.constructor&&c.call&&c.apply?c:null;e&&l(a,e,f);h(a,d,b);return this},addEvent:function(a,c){if(!this.element)return!1;var b=this.element,d=""!==b.id?b.id:null;l(a,c,d);"ready"!=a?h("addEventListener",a,b):"ready"==a&&i&&c.call(null,d);return this},removeEvent:function(a){if(!this.element)return!1;var c=this.element,b;a:{if((b=""!==c.id?c.id:null)&&d[b]){if(!d[b][a]){b=!1;break a}d[b][a]=null}else{if(!d[a]){b=
    !1;break a}d[a]=null}b=!0}"ready"!=a&&b&&h("removeEventListener",a,c)}};e.fn.init.prototype=e.fn;window.addEventListener?window.addEventListener("message",j,!1):window.attachEvent("onmessage",j);return window.Froogaloop=window.$f=e}();
/*
 td_video_playlist.js
 v1.1
 */


/* global jQuery:{} */
/* global YT:{} */
/* global tdDetect:{} */
/* global $f:{} */

/* jshint -W069 */
/* jshint -W116 */

var tdYoutubePlayers = {};
var tdVimeoPlayers = {};

// @todo this ready hook function must be moved from here
jQuery().ready(function() {

    'use strict';

    tdYoutubePlayers.init();
    tdVimeoPlayers.init();
});



(function() {

    'use strict';


    // the youtube list players (the init() method should be called before using the list)
    tdYoutubePlayers = {

        // the part name of the player id (they will be ex 'player_youtube_1', 'player_youtube_1', 'player_youtube_2', ...)
        tdPlayerContainer: 'player_youtube',

        // the internal list
        players: [],


        // the initialization of the youtube list players
        init: function() {

            var jqWrapperPlaylistPlayerYoutube = jQuery( '.td_wrapper_playlist_player_youtube' );

            for ( var i = 0; i < jqWrapperPlaylistPlayerYoutube.length; i++ ) {

                var jqPlayerWrapper = jQuery( jqWrapperPlaylistPlayerYoutube[ i ] ),
                    youtubePlayer = tdYoutubePlayers.addPlayer( jqPlayerWrapper),
                    playerId = youtubePlayer.tdPlayerContainer;

                jqPlayerWrapper.parent().find( '.td_youtube_control').data( 'player-id', playerId );

                var videoYoutubeElements = jqPlayerWrapper.parent().find( '.td_click_video_youtube');
                for ( var j = 0; j < videoYoutubeElements.length; j++ ) {
                    jQuery( videoYoutubeElements[ j ] ).data( 'player-id', playerId );

                    if ( j + 1 < videoYoutubeElements.length) {
                        jQuery( videoYoutubeElements[ j ] ).data( 'next-video-id', jQuery(videoYoutubeElements[ j + 1 ] ).data( 'video-id' ) );
                    } else {
                        jQuery( videoYoutubeElements[ j ] ).data( 'next-video-id', jQuery(videoYoutubeElements[0]).data( 'video-id' ) );
                    }
                }


                if ( '1' == jqPlayerWrapper.data( 'autoplay' ) ) {
                    youtubePlayer.autoplay = 1;
                }

                var firstVideo = jqPlayerWrapper.data( 'first-video' );

                if ( '' !== firstVideo ) {
                    youtubePlayer.tdPlaylistIdYoutubeVideoRunning = firstVideo;
                    youtubePlayer.playVideo( firstVideo );
                }
            }

            //click on a youtube movie
            jQuery( '.td_click_video_youtube' ).click(function(){

                var videoId = jQuery( this ).data( 'video-id' ),
                    playerId = jQuery( this ).data( 'player-id' );

                if ( undefined !== playerId && '' !== playerId && undefined !== videoId && '' !== videoId ) {
                    tdYoutubePlayers.operatePlayer( playerId, 'play', videoId );
                }
            });



            //click on youtube play control
            jQuery( '.td_youtube_control' ).click(function(){

                var playerId = jQuery( this ).data( 'player-id' );

                if ( undefined !== playerId && '' !== playerId ) {
                    if ( jQuery( this ).hasClass( 'td-sp-video-play' ) ){
                        tdYoutubePlayers.operatePlayer( playerId, 'play' );
                    } else {
                        tdYoutubePlayers.operatePlayer( playerId, 'pause' );
                    }
                }
            });
        },


        addPlayer: function( jqPlayerWrapper ) {

            var containerId = tdYoutubePlayers.tdPlayerContainer + '_' + tdYoutubePlayers.players.length,
                tdPlayer = tdYoutubePlayers.createPlayer( containerId, jqPlayerWrapper );

            tdYoutubePlayers.players.push( tdPlayer );

            return tdPlayer;
        },

        operatePlayer: function( playerId, option, videoId ) {
            for ( var i = 0; i < tdYoutubePlayers.players.length; i++ ) {
                if (tdYoutubePlayers.players[i].tdPlayerContainer == playerId ) {

                    var youtubePlayer = tdYoutubePlayers.players[ i ];

                    // This status is necessary just for mobile
                    youtubePlayer.playStatus();

                    if ( 'play' === option ) {

                        youtubePlayer.autoplay = 1;

                        if ( undefined === videoId ) {
                            youtubePlayer.playerPlay();
                        } else {
                            youtubePlayer.playVideo(videoId);
                        }
                    } else if ( 'pause' == option ) {
                        tdYoutubePlayers.players[i].playerPause();
                    }
                    break;
                }
            }
        },


        // create and return the youtube player object
        createPlayer: function( containerId, jqPlayerWrapper ) {

            var youtubePlayer = {

                tdYtPlayer: '',

                tdPlayerContainer: containerId,

                autoplay: 0,

                tdPlaylistIdYoutubeVideoRunning: '',

                jqTDWrapperVideoPlaylist: jqPlayerWrapper.closest( '.td_wrapper_video_playlist' ),

                jqPlayerWrapper: jqPlayerWrapper,

                jqControlPlayer: '',

                _videoId: '',

                playVideo: function( videoId ) {

                    youtubePlayer._videoId = videoId;

                    if ( 'undefined' === typeof( YT ) || 'undefined' === typeof( YT.Player ) ) {

                        window.onYouTubePlayerAPIReady = function () {

                            for ( var i = 0; i < tdYoutubePlayers.players.length; i++ ) {
                                tdYoutubePlayers.players[ i ].loadPlayer( );
                            }
                        };

                        jQuery.getScript('https://www.youtube.com/player_api').done(function( script, textStatus ) {
                            //alert(textStatus);
                        });
                    } else {
                        youtubePlayer.loadPlayer( videoId );
                    }
                },


                loadPlayer: function (videoId) {

                    var videoIdToPlay = youtubePlayer._videoId;

                    if ( undefined !== videoId ) {
                        videoIdToPlay = videoId;
                    }

                    if ( undefined === videoIdToPlay ) {
                        return;
                    }

                    //container is here in case we need to add multiple players on page
                    youtubePlayer.tdPlaylistIdYoutubeVideoRunning = videoIdToPlay;

                    var current_video_name = window.td_youtube_list_ids['td_' + youtubePlayer.tdPlaylistIdYoutubeVideoRunning]['title'],
                        current_video_time = window.td_youtube_list_ids['td_' + youtubePlayer.tdPlaylistIdYoutubeVideoRunning]['time'];

                    //remove focus from all videos from playlist
                    youtubePlayer.jqTDWrapperVideoPlaylist.find( '.td_click_video_youtube' ).removeClass( 'td_video_currently_playing' );

                    //add focus class on current playing video
                    youtubePlayer.jqTDWrapperVideoPlaylist.find( '.td_' + videoIdToPlay ).addClass( 'td_video_currently_playing' );

                    //ading the current video playing title and time to the control area
                    youtubePlayer.jqTDWrapperVideoPlaylist.find( '.td_current_video_play_title_youtube' ).html( current_video_name );
                    youtubePlayer.jqTDWrapperVideoPlaylist.find( '.td_current_video_play_time_youtube' ).html( current_video_time );

                    youtubePlayer.jqPlayerWrapper.html('<div id=' + youtubePlayer.tdPlayerContainer + '></div>');

                    youtubePlayer.jqControlPlayer = youtubePlayer.jqTDWrapperVideoPlaylist.find( '.td_youtube_control' );

                    youtubePlayer.tdYtPlayer = new YT.Player(youtubePlayer.tdPlayerContainer, {//window.myPlayer = new YT.Player(container, {
                        playerVars: {
                            //modestbranding: 1,
                            //rel: 0,
                            //showinfo: 0,
                            autoplay: youtubePlayer.autoplay
                        },
                        height: '100%',
                        width: '100%',
                        videoId: videoIdToPlay,
                        events: {
                            'onStateChange': youtubePlayer.onPlayerStateChange
                        }
                    });
                },


                onPlayerStateChange: function (event) {
                    if (event.data === YT.PlayerState.PLAYING) {

                        //add pause to playlist control
                        youtubePlayer.pauseStatus();

                    } else if (event.data === YT.PlayerState.ENDED) {

                        youtubePlayer.playStatus();

                        //if a video has ended then make auto play = 1; This is the case when the user set autoplay = 0 but start watching videos
                        youtubePlayer.autoplay = 1;


                        //get the next video
                        var nextVideoId = '',
                            tdVideoCurrentlyPlaying = youtubePlayer.jqTDWrapperVideoPlaylist.find( '.td_video_currently_playing' );

                        if ( tdVideoCurrentlyPlaying.length ) {
                            var nextSibling = jQuery( tdVideoCurrentlyPlaying ).next( '.td_click_video_youtube' );
                            if ( nextSibling.length ) {
                                nextVideoId = jQuery( nextSibling ).data( 'video-id' );
                            }
                            //else {
                            //    var firstSibling = jQuery(tdVideoCurrentlyPlaying).siblings( '.td_click_video_youtube:first' );
                            //    if ( firstSibling.length ) {
                            //        nextVideoId = jQuery( firstSibling ).data( 'video-id' );
                            //    }
                            //}
                        }

                        if ('' !== nextVideoId) {
                            youtubePlayer.playVideo(nextVideoId);
                        }

                    } else if (YT.PlayerState.PAUSED) {
                        //add play to playlist control
                        youtubePlayer.playStatus();
                    }
                },

                //tdPlaylistYoutubeStopVideo: function () {
                //    youtubePlayer.tdYtPlayer.stopVideo();
                //},

                playerPlay: function () {
                    youtubePlayer.tdYtPlayer.playVideo();
                },

                playerPause: function () {
                    youtubePlayer.tdYtPlayer.pauseVideo();
                },

                playStatus: function() {
                    youtubePlayer.jqControlPlayer.removeClass( 'td-sp-video-pause' ).addClass( 'td-sp-video-play' );
                },

                pauseStatus: function() {
                    youtubePlayer.jqControlPlayer.removeClass( 'td-sp-video-play' ).addClass( 'td-sp-video-pause' );
                }
            };

            return youtubePlayer;
        }
    };




    // the vimeo list players (to use it, the init() method should be called)
    tdVimeoPlayers = {

        // the part name of the player id (they will be ex 'player_vimeo_0', 'player_vimeo_1', 'player_vimeo_2', ...)
        tdPlayerContainer: 'player_vimeo',

        // the internal list
        players: [],

        // Set to true at the first autoplayed player created
        // It's used to avoid the autoplay setting of the next players (multiple players can't have autoplay = 1 )
        existingAutoplay: false,


        // init the vimeo list players
        init: function() {
            var jqTDWrapperPlaylistPlayerVimeo = jQuery( '.td_wrapper_playlist_player_vimeo' );

            for ( var i = 0; i < jqTDWrapperPlaylistPlayerVimeo.length; i++ ) {
                var vimeoPlayer = tdVimeoPlayers.addPlayer( jQuery(jqTDWrapperPlaylistPlayerVimeo[i]) );
                if ( 0 !== vimeoPlayer.autoplay ) {
                    tdVimeoPlayers.existingAutoplay = true;
                }
            }


            //click on a vimeo
            jQuery( '.td_click_video_vimeo' ).click(function(){

                var videoId = jQuery( this ).data( 'video-id' ),
                    playerId = jQuery( this ).data( 'player-id' );

                if ( undefined !== playerId && '' !== playerId && undefined !== videoId && '' !== videoId ) {
                    tdVimeoPlayers.operatePlayer( playerId, 'play', videoId );
                }
            });


            //click on vimeo play control
            jQuery( '.td_vimeo_control' ).click(function(){

                var playerId = jQuery( this ).data( 'player-id' );

                if ( undefined !== playerId && '' !== playerId ) {
                    if ( jQuery( this ).hasClass( 'td-sp-video-play' ) ){
                        tdVimeoPlayers.operatePlayer( playerId, 'play' );
                    } else {
                        tdVimeoPlayers.operatePlayer( playerId, 'pause' );
                    }
                }
            });
        },


        // create and add player to the vimeo list players
        addPlayer: function( jqPlayerWrapper ) {
            var playerId = tdVimeoPlayers.tdPlayerContainer + '_' + tdVimeoPlayers.players.length,
                vimeoPlayer = tdVimeoPlayers.createPlayer(  playerId, jqPlayerWrapper );

            jqPlayerWrapper.parent().find( '.td_vimeo_control').data( 'player-id', playerId );

            var vimeoVideoElements = jqPlayerWrapper.parent().find( '.td_click_video_vimeo');
            for ( var j = 0; j < vimeoVideoElements.length; j++ ) {
                jQuery( vimeoVideoElements[ j ] ).data( 'player-id', playerId );

                if ( j + 1 < vimeoVideoElements.length ) {
                    jQuery( vimeoVideoElements[ j ] ).data( 'next-video-id', jQuery( vimeoVideoElements[ j + 1 ] ).data( 'video-id' ) );
                } else {
                    jQuery( vimeoVideoElements[ j ] ).data( 'next-video-id', jQuery( vimeoVideoElements[ 0 ] ).data( 'video-id' ) );
                }
            }

            if ( '1' == jqPlayerWrapper.data( 'autoplay' ) ) {
                vimeoPlayer.autoplay = 1;
            }

            var firstVideo = jqPlayerWrapper.data( 'first-video' );

            if ( undefined !== firstVideo && '' !== firstVideo ) {
                vimeoPlayer.createPlayer( firstVideo );
            }

            tdVimeoPlayers.players.push( vimeoPlayer );

            return vimeoPlayer;
        },


        // play or pause a video or the current (first) video
        operatePlayer: function( playerId, option, videoId ) {
            for ( var i = 0; i < tdVimeoPlayers.players.length; i++ ) {

                if ( tdVimeoPlayers.players[ i ].playerId == playerId ) {

                    var vimeoPlayer = tdVimeoPlayers.players[ i ];

                    if ( 'play' === option ) {

                        vimeoPlayer.autoplay = 1;

                        if ( undefined !== videoId ) {
                            vimeoPlayer.createPlayer( videoId );
                        } else {
                            vimeoPlayer.playerPlay();
                        }

                    } else if ( 'pause' === option ) {
                        vimeoPlayer.playerPause();
                    }

                    break;
                }
            }
        },


        // create and return the vimeo player object
        createPlayer: function( playerId, jqPlayerWrapper ) {

            var vimeoPlayer = {

                playerId: playerId,

                // the jq td playlist wrapper ( the player and the playlist)
                jqTDWrapperVideoPlaylist: jqPlayerWrapper.closest( '.td_wrapper_video_playlist' ),

                // the jq player wrapper
                jqPlayerWrapper: jqPlayerWrapper,

                currentVideoPlaying : '', // not used for the moment

                player: '',//a copy of the vimeo player : needed when playing or pausing the vimeo pleyer from the playlist control

                // main control button of the player
                jqControlPlayer: '',

                autoplay: 0,//autoplay

                createPlayer: function ( videoId ) {
                    if ( '' !== videoId ) {

                        this.currentVideoPlaying = videoId;

                        var autoplay = '',
                            current_video_name = window.td_vimeo_list_ids['td_' + videoId]['title'],
                            current_video_time = window.td_vimeo_list_ids['td_' + videoId]['time'];

                        //remove focus from all videos from playlist
                        vimeoPlayer.jqTDWrapperVideoPlaylist.find( '.td_click_video_vimeo' ).removeClass( 'td_video_currently_playing' );

                        //add focus class on current playing video
                        vimeoPlayer.jqTDWrapperVideoPlaylist.find( '.td_' + videoId ).addClass( 'td_video_currently_playing' );

                        //ading the current video playing title and time to the control area
                        vimeoPlayer.jqTDWrapperVideoPlaylist.find( '.td_current_video_play_title_vimeo' ).html( current_video_name );
                        vimeoPlayer.jqTDWrapperVideoPlaylist.find( '.td_current_video_play_time_vimeo' ).html( current_video_time );

                        vimeoPlayer.jqControlPlayer = vimeoPlayer.jqTDWrapperVideoPlaylist.find( '.td_vimeo_control' );

                        //check autoplay
                        if ( !tdVimeoPlayers.existingAutoplay && 0 !== vimeoPlayer.autoplay ) {
                            autoplay = '&autoplay=1';

                            if ( tdDetect.isMobileDevice ) {
                                vimeoPlayer.playStatus();
                            } else {
                                vimeoPlayer.pauseStatus();
                            }
                        } else {
                            vimeoPlayer.playStatus();
                        }
                        vimeoPlayer.jqPlayerWrapper.html( '<iframe id="' + vimeoPlayer.playerId + '" src="https://player.vimeo.com/video/' + videoId + '?api=1&player_id=' + vimeoPlayer.playerId + '' + autoplay + '"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>' );
                        vimeoPlayer.createVimeoObjectPlayer( jQuery );
                    }
                },

                createVimeoObjectPlayer : function( $ ) {
                    var player = '',
                        iframe = $( '#' + vimeoPlayer.playerId );

                    if ( iframe.length ) {
                        player = $f( iframe[0] );

                        //a copy of the vimeo player : needed when playing or pausing the vimeo pleyer from the playlist control
                        vimeoPlayer.player = player;

                        // When the player is ready, add listeners for pause, finish, and playProgress
                        player.addEvent( 'ready', function() {

                            player.addEvent( 'play', function( data ) {
                                vimeoPlayer.pauseStatus();
                                vimeoPlayer.autoplay = 1;
                            });

                            player.addEvent( 'pause', function( data ) {
                                vimeoPlayer.playStatus();
                            });

                            player.addEvent( 'finish', function( data ) {

                                var nextVideoId = '',
                                    tdVideoCurrentlyPlaying = vimeoPlayer.jqTDWrapperVideoPlaylist.find( '.td_video_currently_playing' );

                                if ( tdVideoCurrentlyPlaying.length ) {
                                    var nextSibling = jQuery( tdVideoCurrentlyPlaying ).next( '.td_click_video_vimeo' );
                                    if ( nextSibling.length ) {
                                        nextVideoId = jQuery( nextSibling ).data( 'video-id' );
                                    }
                                }

                                if ( '' !== nextVideoId ) {
                                    vimeoPlayer.createPlayer( nextVideoId );

                                    if ( tdDetect.isMobileDevice ) {
                                        vimeoPlayer.playStatus();
                                    } else {
                                        vimeoPlayer.pauseStatus();
                                    }
                                } else {
                                    vimeoPlayer.playStatus();
                                }
                            });
                        });
                    }
                },

                // play the current video
                playerPlay: function () {
                    vimeoPlayer.autoplay = 1;
                    vimeoPlayer.player.api( 'play' );
                },

                // pause the current video
                playerPause: function () {
                    vimeoPlayer.player.api( 'pause' );
                },

                // change status to 'play'
                playStatus: function() {
                    vimeoPlayer.jqControlPlayer.removeClass( 'td-sp-video-pause' ).addClass( 'td-sp-video-play' );
                },

                // change status to 'pause'
                pauseStatus: function() {
                    vimeoPlayer.jqControlPlayer.removeClass( 'td-sp-video-play' ).addClass( 'td-sp-video-pause' );
                }
            };

            return vimeoPlayer;
        }
    };

})();
/* tdEvents.js - handles the events that require throttling
 * v 2.0 - wp_010
 *
 * moved in theme from wp_booster
 */

/* global jQuery:{} */
/* global tdCustomEvents:{} */
/* global tdSite:{} */
/* global tdAffix:{} */

// This should be moved to the booster mobile

var tdEvents = {};

(function(){
    'use strict';

    tdEvents = {

        //the events - we have timers that look at the variables and fire the event if the flag is true
        scroll_event_slow_run: false,
        scroll_event_medium_run: false,

        resize_event_slow_run: false, //when true, fire up the resize event
        resize_event_medium_run: false,


        scroll_window_scrollTop: 0, //used to store the scrollTop

        window_pageYOffset: window.pageYOffset, // @todo see if it can replace scroll_window_scrollTop [used by others]
        window_innerHeight: window.innerHeight, // used to store the window height
        window_innerWidth: window.innerWidth, // used to store the window width

        init: function() {

            tdSite.setMenuMinHeight();

            jQuery( window ).scroll(function() {
                tdEvents.scroll_event_slow_run = true;
                tdEvents.scroll_event_medium_run = true;

                //read the scroll top
                tdEvents.scroll_window_scrollTop = jQuery( window ).scrollTop();
                tdEvents.window_pageYOffset = window.pageYOffset;

                tdAffix.scroll();

                // call real tdCustomEvents scroll
                tdCustomEvents._callback_scroll();
            });


            jQuery( window ).resize(function() {
                tdEvents.resize_event_slow_run = true;
                tdEvents.resize_event_medium_run = true;

                tdEvents.window_innerHeight = window.innerHeight;
                tdEvents.window_innerWidth = window.innerWidth;

                // call real tdCustomEvents resize
                tdCustomEvents._callback_resize();
            });



            //medium resolution timer for rest?
            setInterval(function() {

                //scroll event
                if ( tdEvents.scroll_event_medium_run ) {
                    tdEvents.scroll_event_medium_run = false;

                    // call lazy tdCustomEvents scroll
                    tdCustomEvents._lazy_callback_scroll_100();
                }

                if ( tdEvents.resize_event_medium_run ) {
                    tdEvents.resize_event_medium_run = false;

                    // call lazy tdCustomEvents resize
                    tdCustomEvents._lazy_callback_resize_100();
                }
            }, 100);



            //low resolution timer for rest?
            setInterval(function() {
                //scroll event
                if ( tdEvents.scroll_event_slow_run ) {
                    tdEvents.scroll_event_slow_run = false;

                    //back to top
                    tdSite.tdEventsScrollToTop( tdEvents.scroll_window_scrollTop );

                    // call lazy tdCustomEvents scroll
                    tdCustomEvents._lazy_callback_scroll_500();
                }

                //resize event
                if ( tdEvents.resize_event_slow_run ) {
                    tdEvents.resize_event_slow_run = false;

                    // call lazy tdCustomEvents resize
                    tdCustomEvents._lazy_callback_resize_500();
                }

            }, 500);
        }
    };

    tdEvents.init();
})();

/**
 * updates the view counter thru ajax
 */

/* global jQuery:{} */
/* global td_ajax_url:string */

var tdAjaxCount = {};

(function(){

    'use strict';

    tdAjaxCount = {

        //td_get_views_counts_ajax : function( page_type, array_ids ) {
        tdGetViewsCountsAjax : function( postType, arrayIds ) {

            //what function to call based on postType
            var pageTypeAction = 'td_ajax_get_views';//postType = page
            if ( 'post' === postType ) {
                pageTypeAction = 'td_ajax_update_views';
            }

            jQuery.ajax({
                type: 'POST',
                url: td_ajax_url,
                cache: true,
                data: {
                    action: pageTypeAction,
                    td_post_ids: arrayIds
                },
                success: function( data, textStatus, XMLHttpRequest ) {
                    var tdAjaxPostCounts = jQuery.parseJSON( data );//get the return dara

                    //check the return var to be object
                    if ( tdAjaxPostCounts instanceof Object ) {
                        //alert('value is Object!');

                        //iterate throw the object
                        jQuery.each( tdAjaxPostCounts, function( idPost, value ) {
                            //alert(id_post + ": " + value);

                            //this is the count placeholder in witch we write the post count
                            var currentPostCount = '.td-nr-views-' + idPost;

                            jQuery( currentPostCount ).html( value );
                            //console.log(current_post_count + ': ' + value);
                        });
                    }
                },
                error: function( MLHttpRequest, textStatus, errorThrown ) {
                    //console.log(errorThrown);
                }
            });
        }
    };
})();

/* td_custom_events.js - handles the booster td_events that require throttling
 * v 1.0 - wp_011
 */

/* global tdSite:{} */
/* global tdAffix:{} */
/* global tdResizeVideoTimer:int */

/* jshint -W020*/

var tdCustomEvents = {};

(function(){

    'use strict';

    tdCustomEvents = {


        /**
         * - callback real scroll called from td_events
         * @private
         */
        _callback_scroll: function() {

        },


        /**
         * - callback real resize called from td_events
         * @private
         */
        _callback_resize: function() {

        },


        /**
         * - callback lazy scroll called from td_events at 100ms
         * @private
         */
        _lazy_callback_scroll_100: function() {

        },


        /**
         * - callback lazy scroll called from td_events at 500ms
         * @private
         */
        _lazy_callback_scroll_500: function() {

        },



        /**
         * - callback lazy resize called from td_events at 100ms
         * @private
         */
        _lazy_callback_resize_100: function() {
            tdAffix.setWPAdminBarPosition();
        },


        /**
         * - callback lazy resize called from td_events at 500ms
         * @private
         */
        _lazy_callback_resize_500: function() {
            tdSite.setMenuMinHeight();

            clearTimeout( tdResizeVideoTimer );
            tdResizeVideoTimer = setTimeout(function() {
                tdSite.resizeVideos();
            }, 200 );
        }
    };
})();



/**
 * Created by tagdiv on 05.11.2015.
 */

/* global jQuery:{} */
/* global tdEvents:{} */

var tdAffix = {};

(function() {

    'use strict';

    tdAffix = {

        _menu: undefined,

        _menuHeight: undefined,

        _nextElement: undefined,

        _currentPosition: undefined, // 0 - top, 1 - affix hidden, 2 - transition, 3 - affix sticky

        _previousScrolledPosition: 0,

        _previousScrolledDistance: 0,

        _isUp: 0,

        _marginFakeWidth: 30,

        _marginFakeColor: undefined,

        _wpadminbar: undefined,

        _wpadminbarFirstPositionCheck: false,

        _wpadminbarHeight: 0,

        init: function( classSelector ) {

            //tdAffix.debugWindow = jQuery( '<div style="display: none; background-color: white; border: 1px solid red; width: 200px; height: 400px; position: fixed; bottom: 0"></div>' );
            //tdAffix.debugWindow = jQuery( '<div style="background-color: white; border: 1px solid red; width: 200px; height: 300px; position: fixed; bottom: 0; z-index: 999999"></div>' );
            //jQuery( document.body ).append( tdAffix.debugWindow );

            var menu = jQuery( '.' + classSelector );
            if ( menu.length ) {
                tdAffix._menu = menu;
                tdAffix._menuHeight = menu.outerHeight( true );
                tdAffix._nextElement = menu.next();

                tdAffix._previousScrolledPosition = tdEvents.window_pageYOffset;

                // The menu is initialized
                if ( tdAffix._previousScrolledPosition > tdAffix._menuHeight ) {
                    // _isAffixed is initialized
                    tdAffix._currentPosition = 1;
                    tdAffix._menu.css( 'position', 'fixed' );
                    tdAffix._menu.css( 'top', -tdAffix._menuHeight);
                    tdAffix._nextElement.css( 'padding-top', tdAffix._menuHeight);

                } else {
                    // _isAffixed is initialized
                    tdAffix._currentPosition = 0;
                }

                //tdAffix._addGPUSupport();

                tdAffix._marginFakeColor = tdAffix._menu.css( 'background-color' );

                if ( jQuery( document.body).hasClass( 'admin-bar' ) ) {
                    var positionChecker = jQuery( '<div></div>' );
                    jQuery( document.body).prepend( positionChecker );
                    tdAffix._wpadminbarHeight = positionChecker.offset().top;
                    positionChecker.remove();
                }

                tdAffix.setWPAdminBarPosition();
            }

            tdAffix.log( tdAffix._currentPosition + ' : ' + tdAffix._menuHeight );
        },


        //_addGPUSupport: function() {
        //    if ( undefined === tdAffix._menu ) {
        //        return;
        //    }
        //    tdAffix._menu.css( '-webkit-transform', 'translateZ(0)' );
        //    tdAffix._menu.css( '-moz-transform', 'translateZ(0)' );
        //    tdAffix._menu.css( '-ms-transform', 'translateZ(0)' );
        //    tdAffix._menu.css( '-o-transform', 'translateZ(0)' );
        //    tdAffix._menu.css( 'transform', 'translateZ(0)' );
        //},


        //_removeGPUSupport: function() {
        //    if ( undefined === tdAffix._menu ) {
        //        return;
        //    }
        //    tdAffix._menu.css( '-webkit-transform', '' );
        //    tdAffix._menu.css( '-moz-transform', '' );
        //    tdAffix._menu.css( '-ms-transform', '' );
        //    tdAffix._menu.css( '-o-transform', '' );
        //    tdAffix._menu.css( 'transform', '' );
        //},


        _addMarginFake: function() {
            if ( undefined === tdAffix._menu ) {
                return;
            }
            tdAffix._menu.css( 'border-top-width', tdAffix._marginFakeWidth );
            tdAffix._menu.css( 'border-top-style', 'solid' );
            tdAffix._menu.css( 'border-top-color', tdAffix._marginFakeColor );
            tdAffix._menu.css( 'height', tdAffix._menuHeight + tdAffix._marginFakeWidth );
        },


        _removeMarginFake: function() {
            if ( undefined === tdAffix._menu ) {
                return;
            }
            tdAffix._menu.css( 'border-top-width', '' );
            tdAffix._menu.css( 'border-top-style', '' );
            tdAffix._menu.css( 'border-top-color', '' );
            tdAffix._menu.css( 'height', '' );
        },


        _setMenuToOriginalState: function() {
            if ( undefined === tdAffix._menu ) {
                return;
            }
            tdAffix._currentPosition = 0;
            tdAffix._menu.css( 'position', '' );
            tdAffix._menu.css( 'top', '' );
            tdAffix._nextElement.css( 'padding-top', '' );
            tdAffix._previousScrolledPosition = tdEvents.scroll_window_scrollTop;
            tdAffix._removeMarginFake();
            tdAffix._menu.hide().show(0);
        },


        scroll: function() {
            if ( undefined === tdAffix._menu ) {
                return;
            }

            // start - special case (at spooky scrolling) to set menu in its genuine top position
            if ( 0 !== tdAffix._currentPosition && tdEvents.scroll_window_scrollTop <= 0 ) {
                tdAffix.log( 'special case' );
                tdAffix._setMenuToOriginalState();
                return;
            }
            // end - special case

            var topPosition;

            //tdAffix.debugWindow.html( tdAffix._menuHeight + ' >> ' + tdEvents.scroll_window_scrollTop + ' : ' + tdAffix._previousScrolledPosition + ' : ' + (tdEvents.scroll_window_scrollTop - tdAffix._previousScrolledPosition)  + ' : ' + tdAffix._currentPosition );

            tdAffix.log(tdEvents.scroll_window_scrollTop + ' : ' + tdAffix._previousScrolledPosition);

            tdAffix._checkWPAdminBarPosition();


            // By default, we make the wpadminbar to be on 'absolute' position
            if (tdEvents.scroll_window_scrollTop > tdAffix._previousScrolledPosition) {

                // down

                switch (tdAffix._currentPosition) {
                    case 0 :
                        tdAffix.log('down 0');
                        if (tdEvents.scroll_window_scrollTop > tdAffix._menuHeight + tdAffix._wpadminbarHeight) {
                            tdAffix._currentPosition = 1;
                            tdAffix._menu.css('position', 'fixed');
                            tdAffix._menu.css('top', -tdAffix._menuHeight);
                            tdAffix._nextElement.css('padding-top', tdAffix._menuHeight);
                        }
                        break;

                    case 1 :
                        tdAffix.log('down 1');
                        // do nothing
                        break;

                    case 2 :
                        tdAffix.log('down 2');

                        topPosition = parseInt(tdAffix._menu.css('top').replace('px', ''));
                        if (tdEvents.scroll_window_scrollTop > topPosition + tdAffix._menuHeight + tdAffix._marginFakeWidth) {
                            tdAffix._fastUp = true;
                            tdAffix._currentPosition = 1;
                            tdAffix._menu.css('position', 'fixed');
                            tdAffix._menu.css('top', -tdAffix._menuHeight);

                            tdAffix._removeMarginFake();
                        }
                        break;

                    case 3 :

                        // If the previous move was 'up', this 'down' movement could be of the visibility of the mobile browser search line, so we step over this case.
                        // If we get a new down movement, it means that the direction was changed, and we consider it and all movements after it.
                        if (true === tdDetect.isIos && tdAffix._isUp > 0) {
                            //if ( tdAffix._isUp > 0 ) {
                            tdAffix._isUp = 0;
                            tdAffix.log('skip down');
                            break;
                        }

                        tdAffix.log('down 3');
                        tdAffix._currentPosition = 2;
                        tdAffix._menu.css('position', 'absolute');
                        tdAffix._menu.css('top', tdAffix._previousScrolledPosition - tdAffix._marginFakeWidth + 1);

                        tdAffix._addMarginFake();
                        break;
                }

            } else if (tdEvents.scroll_window_scrollTop < tdAffix._previousScrolledPosition) {

                // up

                // It registers that at least an up operation is done
                if (tdAffix._isUp <= 0) {
                    tdAffix._isUp++;
                }

                switch (tdAffix._currentPosition) {
                    case 0 :
                        tdAffix.log('up 0');
                        // do nothing
                        break;

                    case 1 :
                        tdAffix.log('up 1');

                        // Usually the next case would be 2, but if the gap between the previous and the current scrolled position is larger than menu height,
                        // the menu is affixed (case 3)
                        if (tdAffix._previousScrolledPosition - tdEvents.scroll_window_scrollTop >= tdAffix._menuHeight) {
                            tdAffix._currentPosition = 3;
                            tdAffix._menu.css('position', 'fixed');
                            tdAffix._menu.css('top', 0);

                            tdAffix._removeMarginFake();
                        } else {
                            tdAffix._currentPosition = 2;
                            tdAffix._menu.css('position', 'absolute');
                            tdAffix._menu.css('top', tdEvents.scroll_window_scrollTop - tdAffix._menuHeight - tdAffix._marginFakeWidth);

                            tdAffix._addMarginFake();
                        }
                        break;

                    case 2 :
                        tdAffix.log('up 2');

                        topPosition = parseInt(tdAffix._menu.css('top').replace('px', ''));
                        //if ( topPosition >= tdEvents.scroll_window_scrollTop - tdAffix._marginFakeWidth ) {
                        if (topPosition >= tdEvents.scroll_window_scrollTop + tdAffix._previousScrolledDistance - tdAffix._marginFakeWidth) {
                            tdAffix._currentPosition = 3;
                            tdAffix._menu.css('position', 'fixed');
                            tdAffix._menu.css('top', 0);

                            tdAffix._removeMarginFake();
                        }
                        break;

                    case 3 :
                        tdAffix.log('up 3');
                        // do nothing

                        if (tdEvents.scroll_window_scrollTop <= tdAffix._wpadminbarHeight) {
                            tdAffix._currentPosition = 0;
                            tdAffix._setMenuToOriginalState();
                        }

                        break;
                }
            }

            //tdAffix._previousScrolledDistance = tdEvents.scroll_window_scrollTop - tdAffix._previousScrolledPosition;

            tdAffix._previousScrolledPosition = tdEvents.scroll_window_scrollTop;
        },


        /**
         * This check should be done only once, when we are sure that wpadminbar was added in DOM.
         * We'll do it at the first scroll.
         * @private
         */
        _checkWPAdminBarPosition: function() {
            if ( false === tdAffix._wpadminbarFirstPositionCheck ) {
                tdAffix.setWPAdminBarPosition();
                tdAffix._wpadminbarFirstPositionCheck = true;
            }
        },


        /**
         * It should be called usually at viewport changing (on resize).
         * On landscape viewport the wpadminbar is fixed, and we'll position it absolute, like on portrait viewport.
         * The height of the wpadminbar also changes on different viewports (landscape or portrait).
         */
        setWPAdminBarPosition: function() {

            // Try to get the wpadminbar element (it's dynamically inserted by wp)
            if ( undefined === tdAffix._wpadminbar ) {
                var wpadminbar = jQuery( '#wpadminbar' );
                if ( wpadminbar.length ) {
                    tdAffix._wpadminbar = wpadminbar;
                }
            }

            if ( undefined !== tdAffix._wpadminbar ) {
                tdAffix._wpadminbar.css( 'position', 'absolute' );
                tdAffix._wpadminbar.css( 'top', 0 );
                tdAffix._wpadminbarHeight = tdAffix._wpadminbar.outerHeight();
            }
        },

        log: function( msg ) {
            //console.log( msg );
        }
    };

    tdAffix.init( 'td-header-wrap' );

})();
/*
 td_util.js
 v1.1
 */

/* global jQuery:{} */
/* global tdDetect:{} */
/* global td_ajax_url:string */

/* global td_please_wait:string */
/* global td_email_user_pass_incorrect:string */
/* global td_email_user_incorrect:string */
/* global td_email_incorrect:string */



/*  ----------------------------------------------------------------------------
 On load
 */
jQuery().ready(function() {

    'use strict';

    //login
    jQuery( '#login-link' ).on( 'click', function() {
        //hides or shows the divs with inputs
        tdLogin.showHideElements( [['#td-login-div', 1], ['#td-register-div', 0], ['#td-forgot-pass-div', 0]] );

        jQuery( '#td-mobile-nav' ).addClass( 'td-hide-menu-content' );

        if ( jQuery(window).width() > 700 && tdDetect.isIe === false ) {
            jQuery( '#login_email' ).focus();
        }

        //empty error display div
        tdLogin.showHideMsg();
    });


    //register
    jQuery( '#register-link' ).on( 'click', function() {
        //hides or shows the divs with inputs
        tdLogin.showHideElements( [['#td-login-div', 0], ['#td-register-div', 1], ['#td-forgot-pass-div', 0]] );

        jQuery( '#td-mobile-nav' ).addClass( 'td-hide-menu-content' );

        if ( jQuery( window ).width() > 700  && false === tdDetect.isIe ) {
            jQuery( '#register_email' ).focus();
        }

        //empty error display div
        tdLogin.showHideMsg();
    });


    //forgot pass
    jQuery( '#forgot-pass-link' ).on( 'click', function() {
        //hides or shows the divs with inputs
        tdLogin.showHideElements( [['#td-login-div', 0], ['#td-register-div', 0], ['#td-forgot-pass-div', 1]] );

        if (jQuery( window ).width() > 700 && false === tdDetect.isIe ) {
            jQuery( '#forgot_email' ).focus();
        }

        //empty error display div
        tdLogin.showHideMsg();
    });


    //login button
    jQuery( '#login_button' ).on( 'click', function() {
        tdLogin.handlerLogin();
    });

    //enter key on #login_pass
    jQuery( '#login_pass' ).keydown(function(event) {
        if ( ( event.which && 13 === event.which ) || ( event.keyCode && 13 === event.keyCode ) ) {
            tdLogin.handlerLogin();
        }
    });



    //register button
    jQuery( '#register_button' ).on( 'click', function() {
        tdLogin.handlerRegister();
    });

    //enter key on #register_user
    jQuery( '#register_user' ).keydown(function(event) {
        if ( ( event.which && 13 === event.which ) || ( event.keyCode && 13 === event.keyCode ) ) {
            tdLogin.handlerRegister();
        }
    });



    //forgot button
    jQuery( '#forgot_button' ).on( 'click', function() {
        tdLogin.handlerForgotPass();
    });

    //enter key on #forgot_email
    jQuery( '#forgot_email' ).keydown(function(event) {
        if ( ( event.which && 13 === event.which ) || ( event.keyCode && 13 === event.keyCode ) ) {
            tdLogin.handlerForgotPass();
        }
    });


    // marius
    // *****************************************************************************
    // *****************************************************************************
    // back login/register button
    jQuery( '.td-login-close a, .td-register-close a' ).on( 'click', function() {
        //hides or shows the divs with inputs
        tdLogin.showHideElements( [['#td-login-div', 0], ['#td-register-div', 0], ['#td-forgot-pass-div', 0]] );

        jQuery( '#td-mobile-nav' ).removeClass( 'td-hide-menu-content' );
    });

    // back forgot pass button
    jQuery( '.td-forgot-pass-close a' ).on( 'click', function() {
        //hides or shows the divs with inputs
        tdLogin.showHideElements( [['#td-login-div', 1], ['#td-register-div', 0], ['#td-forgot-pass-div', 0]] );
    });



    // global var tds_login_mobile is defined only when the 'tds_login_mobile' option is on (has the 'show' value)
    if ( undefined !== window.tds_login_mobile ) {
        // used for log in to leave a comment on post page to open the login section
        jQuery( '.td-login-modal-js, .comment-reply-login' ).on( 'click', function( event ) {

            event.preventDefault();

            // open the menu background
            jQuery( 'body' ).addClass( 'td-menu-mob-open-menu' );

            // hide the menu content
            jQuery( '.td-mobile-container' ).hide();
            jQuery( '#td-mobile-nav' ).addClass( 'td-hide-menu-content' );

            setTimeout(function(){
                jQuery( '.td-mobile-container' ).show();
            }, 500);

            //hides or shows the divs with inputs
            tdLogin.showHideElements( [['#td-login-div', 1], ['#td-register-div', 0], ['#td-forgot-pass-div', 0]] );
        });
    }


});//end jquery ready




var tdLogin = {};


(function(){

    'use strict';

    tdLogin = {

        //patern to check emails
        email_pattern : /^[a-zA-Z0-9][a-zA-Z0-9_\.-]{0,}[a-zA-Z0-9]@[a-zA-Z0-9][a-zA-Z0-9_\.-]{0,}[a-z0-9][\.][a-z0-9]{2,4}$/,

        /**
         * handle all request made from login tab
         */
        handlerLogin : function() {
            var loginEmailEl = jQuery( '#login_email'),
                loginPassEl = jQuery( '#login_pass' );

            if ( loginEmailEl.length && loginPassEl.length ) {
                var loginEmailVal = loginEmailEl.val().trim(),
                    loginPassVal = loginPassEl.val().trim();

                if ( loginEmailVal && loginPassVal ) {
                    tdLogin.addRemoveClass( ['.td_display_err', 1, 'td_display_msg_ok'] );
                    tdLogin.showHideMsg( td_please_wait );

                    //call ajax for log in
                    tdLogin.doAction( 'td_mod_login', loginEmailVal, '', loginPassVal );
                } else {
                    tdLogin.showHideMsg( td_email_user_pass_incorrect );
                }
            }
        },


        /**
         * handle all request made from register tab
         */
        handlerRegister : function() {
            var registerEmailEl = jQuery( '#register_email' ),
                registerUserEl = jQuery( '#register_user' );

            if ( registerEmailEl.length && registerUserEl.length ) {
                var registerEmailVal = registerEmailEl.val().trim(),
                    registerUserVal = registerUserEl.val().trim();

                if ( tdLogin.email_pattern.test( registerEmailVal ) && registerUserVal ) {

                    tdLogin.addRemoveClass( ['.td_display_err', 1, 'td_display_msg_ok'] );
                    tdLogin.showHideMsg( td_please_wait );

                    //call ajax
                    tdLogin.doAction( 'td_mod_register', registerEmailVal, registerUserVal, '' );
                } else {
                    tdLogin.showHideMsg( td_email_user_incorrect );
                }
            }
        },


        /**
         * handle all request made from forgot password tab
         */
        handlerForgotPass : function() {
            var forgotEmailEl = jQuery( '#forgot_email' );

            if ( forgotEmailEl.length ) {
                var forgotEmailVal = forgotEmailEl.val().trim();

                if ( tdLogin.email_pattern.test( forgotEmailVal ) ){

                    tdLogin.addRemoveClass( ['.td_display_err', 1, 'td_display_msg_ok'] );
                    tdLogin.showHideMsg( td_please_wait );

                    //call ajax
                    tdLogin.doAction( 'td_mod_remember_pass', forgotEmailVal, '', '' );
                } else {
                    tdLogin.showHideMsg( td_email_incorrect );
                }
            }
        },


        /**
         * swhich the div's acordingly to the user action (Log In, Register, Remember Password)
         *
         * ids_array : array of ids that have to be showed or hidden
         */
        showHideElements : function( ids_array ) {
            if ( ids_array.constructor === Array ) {
                var length = ids_array.length;

                for ( var i = 0; i < length; i++ ) {
                    if ( ids_array[ i ].constructor === Array && 2 === ids_array[ i ].length ) {
                        var jqElement = jQuery( ids_array[ i ][0] );
                        if ( jqElement.length ) {
                            if ( 1 === ids_array[ i ][1] ) {
                                jqElement.removeClass( 'td-login-hide' ).addClass( 'td-login-show' );
                            } else {
                                jqElement.removeClass( 'td-login-show' ).addClass( 'td-login-hide' );
                            }
                        }
                    }
                }
            }
        },


        showTabs : function( ids_array ) {
            if ( ids_array.constructor === Array ) {
                var length = ids_array.length;

                for ( var i = 0; i < length; i++ ) {
                    if ( ids_array[ i ].constructor === Array && 2 === ids_array[ i ].length ) {
                        var jqElement = jQuery( ids_array[ i ][0] );
                        if ( jqElement.length ) {
                            if ( 1 === ids_array[ i ][1] ) {
                                jqElement.addClass( 'td_login_tab_focus' );
                            } else {
                                jqElement.removeClass( 'td_login_tab_focus' );
                            }
                        }
                    }
                }
            }
        },


        /**
         * adds or remove a class from an html object
         *
         * param : array with object identifier (id - # or class - .)
         * ex: ['.class_indetifier', 1, 'class_to_add'] or ['.class_indetifier', 0, 'class_to_remove']
         */
        addRemoveClass : function( param ) {
            if ( param.constructor === Array && 3 === param.length ) {
                var tdElement = jQuery( param[0] );
                if ( tdElement.length ) {
                    if ( 1 === param[1] ) {
                        tdElement.addClass( param[2] );
                    } else {
                        tdElement.removeClass( param[2] );
                    }
                }
            }
        },


        showHideMsg : function( msg ) {
            var tdDisplayErr = jQuery( '.td_display_err' );
            if ( tdDisplayErr.length ) {
                if ( undefined !== msg && msg.constructor === String && msg.length > 0 ) {
                    tdDisplayErr.show();
                    tdDisplayErr.html( msg );
                } else {
                    tdDisplayErr.hide();
                    tdDisplayErr.html( '' );
                }
            }
        },


        /**
         * empty all fields in modal window
         */
        clearFields : function() {
            //login fields
            jQuery( '#login_email' ).val( '' );
            jQuery( '#login_pass' ).val( '' );

            //register fields
            jQuery( '#register_email' ).val( '' );
            jQuery( '#register_user' ).val( '' );

            //forgot pass
            jQuery( '#forgot_email' ).val( '' );
        },


        /**
         * call to server from modal window
         *
         * @param $action : what action (log in, register, forgot email)
         * @param $email  : the email beening sent
         * @param $user   : the user name beening sent
         */
        doAction : function( sent_action, sent_email, sent_user, sent_pass ) {
            jQuery.ajax({
                type: 'POST',
                url: td_ajax_url,
                data: {
                    action: sent_action,
                    email: sent_email,
                    user: sent_user,
                    pass: sent_pass,

                    // This parameter is used internally by the theme (by the 'on_ajax_login' booster method) to differentiate the login requests.
                    // The 'on_ajax_login' responses to all login requests, from: the theme version (or the responsive version) and the mobile version.
                    // The 'on_ajax_login' response must be stopped if the request comes from the theme version (or responsive version) and the theme option 'tds_login_sign_in_widget' is not set.
                    // The 'on_ajax_login' response must be stopped if the request comes from the mobile version and the theme option 'tds_login_mobile' is not set.
                    //
                    // IMPORTANT! In wpadmin, the main theme is known as being loaded, and we don't know anything about mobile theme as a theme. We know about her checking if the mobile plugin
                    // is activated or not. BUT EVEN WE KNOW IT IS ACTIVATED, WE DON'T KNOW IF THE LOGIN REQUEST COMES FROM THE THEME VERSION (OR RESPONSIVE VERSION) OR THE MOBILE VERSION.
                    mobile: true
                },
                success: function( data, textStatus, XMLHttpRequest ){
                    var td_data_object = jQuery.parseJSON( data ); //get the data object

                    //check the response from server
                    switch( td_data_object[0] ) {
                        case 'login':
                            if ( 1 === td_data_object[1] ) {
                                location.reload( true );
                            } else {
                                tdLogin.addRemoveClass( ['.td_display_err', 0, 'td_display_msg_ok'] );
                                tdLogin.showHideMsg( td_data_object[2] );
                            }
                            break;

                        case 'register':
                            if ( 1 === td_data_object[1] ) {
                                tdLogin.addRemoveClass( ['.td_display_err', 1, 'td_display_msg_ok'] );
                            } else {
                                tdLogin.addRemoveClass( ['.td_display_err', 0, 'td_display_msg_ok'] );
                            }
                            tdLogin.showHideMsg( td_data_object[2] );
                            break;

                        case 'remember_pass':
                            if ( 1 === td_data_object[1] ) {
                                tdLogin.addRemoveClass( ['.td_display_err', 1, 'td_display_msg_ok'] );
                            } else {
                                tdLogin.addRemoveClass( ['.td_display_err', 0, 'td_display_msg_ok'] );
                            }
                            tdLogin.showHideMsg( td_data_object[2] );
                            break;
                    }
                },
                error: function( MLHttpRequest, textStatus, errorThrown ){
                    //console.log(errorThrown);
                }
            });
        }
    };

})();



