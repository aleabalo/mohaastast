
var domTT_offsetX=0;var domTT_offsetY=2;var domTT_direction='southeast';var domTT_mouseHeight=20;var domTT_closeLink='X';var domTT_screenEdgePadding=5;var domTT_activateDelay=500;var domTT_maxWidth=300;var domTT_useGlobalMousePosition=true;var domTT_classPrefix='domTT';var domTT_fade='neither';var domTT_lifetime=0;var domTT_grid=0;var domTT_trail=false;var domTT_closeAction='hide';var domTT_dragStickyTips;if(typeof(domTT_dragStickyTips)=='undefined')
{var domTT_dragStickyTips=false;}
var domTT_lastOpenID='0';var domTT_onePopup=false;var domTT_predefined=new Hash();var domTT_tooltips=new Hash();if(domLib_useLibrary&&domTT_useGlobalMousePosition)
{var domTT_mousePosition=new Hash();document.onmousemove=function(in_event)
{if(typeof(in_event)=='undefined')
{in_event=event;}
domTT_mousePosition=domLib_getEventPosition(in_event);if(domTT_dragStickyTips&&domTT_dragMouseDown)
{domTT_dragUpdate(in_event);}}}
function domTT_activate(in_this,in_event)
{if(!domLib_useLibrary){return false;}
if(typeof(in_event)=='undefined')
{in_event=window.event;}
var owner=document.body;if(in_event.type.match(/key|mouse|click|contextmenu/i))
{if(in_this.nodeType&&in_this.nodeType!=9)
{var owner=in_this;}}
else
{if(typeof(in_this)=='string'&&!(owner=document.getElementById(in_this)))
{owner=document.body.appendChild(document.createElement('div'));owner.style.display='none';owner.id=in_this;}}
if(!owner.id)
{owner.id='__autoId'+domLib_autoId++;}
if(domTT_onePopup&&domTT_lastOpenID!='0')
{domTT_deactivate(domTT_lastOpenID);}
domTT_lastOpenID=owner.id;var tooltip=domTT_tooltips.get(owner.id);if(tooltip)
{if(tooltip.get('eventType')!=in_event.type)
{if(tooltip.get('type')=='greasy')
{tooltip.set('closeAction','destroy');domTT_deactivate(owner.id);}
else if(tooltip.get('status')!='inactive')
{return owner.id;}}
else
{if(tooltip.get('status')=='inactive')
{tooltip.set('status','pending');tooltip.set('activateTimeout',domLib_setTimeout(domTT_runShow,tooltip.get('delay'),[owner.id,in_event]));return owner.id;}
else
{return owner.id;}}}
var options=new Hash('caption','','content','','closeLink',domTT_closeLink,'parent',document.body,'position','absolute','type','greasy','direction',domTT_direction,'delay',domTT_activateDelay,'classPrefix',domTT_classPrefix,'closeAction',domTT_closeAction,'lifetime',domTT_lifetime,'grid',domTT_grid,'fade',domTT_fade,'trail',domTT_trail,'inframe',false);for(var i=2;i<arguments.length;i+=2)
{if(arguments[i]=='predefined')
{var predefinedOptions=domTT_predefined.get(arguments[i+1]);for(var j in predefinedOptions.elementData)
{options.set(j,predefinedOptions.get(j));}}
else
{options.set(arguments[i],arguments[i+1]);}}
options.set('eventType',in_event.type);if(options.has('statusText'))
{try{window.status=options.get('statusText');}catch(e){}}
if(!options.has('content')||options.get('content')=='')
{if(typeof(owner.onmouseout)!='function')
{owner.onmouseout=function(in_event){domTT_mouseout(this,in_event);};}
return owner.id;}
options.set('owner',owner);options.set('id','[domTT]'+owner.id);try
{domTT_create(options);}catch(e)
{alert(e);}
options.set('delay',in_event.type.match(/click|mousedown|contextmenu/i)?0:parseInt(options.get('delay')));domTT_tooltips.set(owner.id,options);options.set('status','pending');options.set('activateTimeout',domLib_setTimeout(domTT_runShow,options.get('delay'),[owner.id,in_event]));return owner.id;}
function domTT_create(in_options)
{var tipOwner=in_options.get('owner');var parentObj=in_options.get('parent');var parentDoc=parentObj.ownerDocument;var tipObj=parentObj.appendChild(parentDoc.createElement('div'));tipObj.style.position='absolute';tipObj.style.left='0px';tipObj.style.top='0px';tipObj.style.visibility='hidden';tipObj.id=in_options.get('id');tipObj.className=in_options.get('classPrefix');var content;if(in_options.get('caption')||(in_options.get('type')=='sticky'&&in_options.get('caption')!==false))
{var tipLayoutTable=tipObj.appendChild(parentDoc.createElement('table'));tipLayoutTable.style.borderCollapse='collapse';if(domLib_isKonq)
{tipLayoutTable.cellSpacing=0;}
var tipLayoutTbody=tipLayoutTable.appendChild(parentDoc.createElement('tbody'));var numCaptionCells=0;var captionRow=tipLayoutTbody.appendChild(parentDoc.createElement('tr'));var captionCell=captionRow.appendChild(parentDoc.createElement('td'));captionCell.style.padding='0px';var caption=captionCell.appendChild(parentDoc.createElement('div'));caption.className=in_options.get('classPrefix')+'Caption';caption.style.height='100%';caption.appendChild(parentDoc.createTextNode(in_options.get('caption')));if(in_options.get('type')=='sticky')
{var numCaptionCells=2;var closeLinkCell=captionRow.appendChild(parentDoc.createElement('td'));closeLinkCell.style.padding='0px';var closeLink=closeLinkCell.appendChild(parentDoc.createElement('div'));closeLink.className=in_options.get('classPrefix')+'Caption';closeLink.style.height='100%';closeLink.style.textAlign='right';closeLink.style.cursor=domLib_stylePointer;closeLink.style.borderLeftWidth=caption.style.borderRightWidth='0px';closeLink.style.paddingLeft=caption.style.paddingRight='0px';closeLink.style.marginLeft=caption.style.marginRight='0px';if(in_options.get('closeLink').nodeType)
{closeLink.appendChild(in_options.get('closeLink').cloneNode(1));}
else
{closeLink.innerHTML=in_options.get('closeLink');}
closeLink.onclick=function(){domTT_deactivate(tipOwner.id);};closeLink.onmousedown=function(in_event){if(typeof(in_event)=='undefined'){in_event=event;}in_event.cancelBubble=true;};if(domLib_isMacIE){closeLinkCell.appendChild(parentDoc.createTextNode("\n"));}}
if(domLib_isMacIE){captionCell.appendChild(parentDoc.createTextNode("\n"));}
var contentRow=tipLayoutTbody.appendChild(parentDoc.createElement('tr'));var contentCell=contentRow.appendChild(parentDoc.createElement('td'));contentCell.style.padding='0px';if(numCaptionCells)
{if(domLib_isIE)
{contentCell.colSpan=numCaptionCells;}
else
{contentCell.setAttribute('colspan',numCaptionCells);}}
content=contentCell.appendChild(parentDoc.createElement('div'));if(domLib_isIE50)
{content.style.height='100%';}}
else
{content=tipObj.appendChild(parentDoc.createElement('div'));}
content.className=in_options.get('classPrefix')+'Content';if(in_options.get('content').nodeType)
{content.appendChild(in_options.get('content').cloneNode(1));}
else
{content.innerHTML=in_options.get('content');}
if(in_options.has('width'))
{tipObj.style.width=parseInt(in_options.get('width'))+'px';}
var maxWidth=domTT_maxWidth;if(in_options.has('maxWidth'))
{if((maxWidth=in_options.get('maxWidth'))===false)
{tipObj.style.maxWidth=domLib_styleNoMaxWidth;}
else
{maxWidth=parseInt(in_options.get('maxWidth'));tipObj.style.maxWidth=maxWidth+'px';}}
if(maxWidth!==false&&(domLib_isIE||domLib_isKonq)&&tipObj.offsetWidth>maxWidth)
{tipObj.style.width=maxWidth+'px';}
var offset_x,offset_y;if(in_options.get('position')=='absolute'&&!(in_options.has('x')&&in_options.has('y')))
{switch(in_options.get('direction'))
{case'northeast':offset_x=domTT_offsetX;offset_y=0-tipObj.offsetHeight-domTT_offsetY;break;case'northwest':offset_x=0-tipObj.offsetWidth-domTT_offsetX;offset_y=0-tipObj.offsetHeight-domTT_offsetY;break;case'southwest':offset_x=0-tipObj.offsetWidth-domTT_offsetX;offset_y=domTT_mouseHeight+domTT_offsetY;break;case'southeast':offset_x=domTT_offsetX;offset_y=domTT_mouseHeight+domTT_offsetY;break;}
if(in_options.get('inframe'))
{var iframeObj=domLib_getIFrameReference(window);if(iframeObj)
{var frameOffsets=domLib_getOffsets(iframeObj);offset_x+=frameOffsets.get('left');offset_y+=frameOffsets.get('top');}}}
else
{offset_x=0;offset_y=0;in_options.set('trail',false);}
in_options.set('offsetX',offset_x);in_options.set('offsetY',offset_y);in_options.set('offsetWidth',tipObj.offsetWidth);in_options.set('offsetHeight',tipObj.offsetHeight);if(domLib_canFade&&typeof(alphaAPI)=='function')
{if(in_options.get('fade')!='neither')
{var fadeHandler=new alphaAPI(tipObj,50,50,100,0,null,10);fadeHandler.setAlpha(0);in_options.set('fadeHandler',fadeHandler);}}
else
{in_options.set('fade','neither');}
if(in_options.get('trail')&&typeof(tipOwner.onmousemove)!='function')
{tipOwner.onmousemove=function(in_event){domTT_mousemove(this,in_event);};}
if(typeof(tipOwner.onmouseout)!='function')
{tipOwner.onmouseout=function(in_event){domTT_mouseout(this,in_event);};}
if(in_options.get('type')=='sticky')
{if(in_options.get('position')=='absolute'&&domTT_dragStickyTips)
{if(domLib_isIE)
{captionRow.onselectstart=function(){return false;};}
captionRow.onmousedown=function(in_event){domTT_dragStart(tipObj,in_event);};captionRow.onmousemove=function(in_event){domTT_dragUpdate(in_event);};captionRow.onmouseup=function(){domTT_dragStop();};}}
else if(in_options.get('type')=='velcro')
{tipObj.onmouseout=function(in_event){if(typeof(in_event)=='undefined'){in_event=event;}if(!domLib_isDescendantOf(in_event[domLib_eventTo],tipObj)){domTT_deactivate(tipOwner.id);}};}
if(in_options.get('position')=='relative')
{tipObj.style.position='relative';}
in_options.set('node',tipObj);in_options.set('status','inactive');}
function domTT_show(in_ownerId,in_event)
{var tooltip=domTT_tooltips.get(in_ownerId);var status=tooltip.get('status');var tipObj=tooltip.get('node');if(tooltip.get('position')=='absolute')
{var mouse_x,mouse_y;if(tooltip.has('x')&&tooltip.has('y'))
{mouse_x=tooltip.get('x');mouse_y=tooltip.get('y');}
else if(!domTT_useGlobalMousePosition||status=='active'||tooltip.get('delay')==0)
{var eventPosition=domLib_getEventPosition(in_event);mouse_x=eventPosition.get('x');mouse_y=eventPosition.get('y');if(tooltip.get('inframe'))
{mouse_x-=eventPosition.get('scroll_x');mouse_y-=eventPosition.get('scroll_y');}}
else
{mouse_x=domTT_mousePosition.get('x');mouse_y=domTT_mousePosition.get('y');if(tooltip.get('inframe'))
{mouse_x-=domTT_mousePosition.get('scroll_x');mouse_y-=domTT_mousePosition.get('scroll_y');}}
if(tooltip.get('grid'))
{if(in_event.type!='mousemove'||(status=='active'&&(Math.abs(tooltip.get('lastX')-mouse_x)>tooltip.get('grid')||Math.abs(tooltip.get('lastY')-mouse_y)>tooltip.get('grid'))))
{tooltip.set('lastX',mouse_x);tooltip.set('lastY',mouse_y);}
else
{return false;}}
var coordinates={'x':mouse_x+tooltip.get('offsetX'),'y':mouse_y+tooltip.get('offsetY')};coordinates=domTT_correctEdgeBleed(tooltip.get('offsetWidth'),tooltip.get('offsetHeight'),coordinates.x,coordinates.y,domTT_offsetX,domTT_offsetY,tooltip.get('type'),tooltip.get('inframe')?window.parent:window);tipObj.style.left=coordinates.x+'px';tipObj.style.top=coordinates.y+'px';tipObj.style.zIndex=domLib_zIndex++;}
if(status=='pending')
{tooltip.set('status','active');tipObj.style.display='';tipObj.style.visibility='visible';var fade=tooltip.get('fade');if(fade!='neither')
{var fadeHandler=tooltip.get('fadeHandler');if(fade=='out'||fade=='both')
{fadeHandler.pause();if(fade=='out')
{fadeHandler.reset();}}
if(fade=='in'||fade=='both')
{fadeHandler.fadeIn();}}
if(tooltip.get('type')=='greasy'&&tooltip.get('lifetime')!=0)
{tooltip.set('lifetimeTimeout',domLib_setTimeout(domTT_runDeactivate,tooltip.get('lifetime'),[in_ownerId]));}}
if(tooltip.get('position')=='absolute')
{domLib_detectCollisions(tipObj);}}
function domTT_deactivate(in_ownerId)
{var tooltip=domTT_tooltips.get(in_ownerId);if(tooltip)
{var status=tooltip.get('status');if(status=='pending')
{domLib_clearTimeout(tooltip.get('activateTimeout'));tooltip.set('status','inactive');}
else if(status=='active')
{if(tooltip.get('lifetime'))
{domLib_clearTimeout(tooltip.get('lifetimeTimeout'));}
var tipObj=tooltip.get('node');if(tooltip.get('closeAction')=='hide')
{var fade=tooltip.get('fade');if(fade!='neither')
{var fadeHandler=tooltip.get('fadeHandler');if(fade=='out'||fade=='both')
{fadeHandler.pause();fadeHandler.fadeOut();}
else
{fadeHandler.stop();}}
else
{tipObj.style.display='none';}}
else
{tooltip.get('parent').removeChild(tipObj);domTT_tooltips.remove(in_ownerId);}
tooltip.set('status','inactive');domLib_detectCollisions(tipObj,true);}}}
function domTT_mouseout(in_owner,in_event)
{if(!domLib_useLibrary){return false;}
if(typeof(in_event)=='undefined')
{in_event=event;}
var toChild=domLib_isDescendantOf(in_event[domLib_eventTo],in_owner);var tooltip=domTT_tooltips.get(in_owner.id);if(tooltip&&(tooltip.get('type')=='greasy'||tooltip.get('status')!='active'))
{if(!toChild)
{domTT_deactivate(in_owner.id);}}
else if(!toChild)
{try{window.status=window.defaultStatus;}catch(e){}}}
function domTT_mousemove(in_owner,in_event)
{if(!domLib_useLibrary){return false;}
if(typeof(in_event)=='undefined')
{in_event=event;}
var tooltip=domTT_tooltips.get(in_owner.id);if(tooltip&&tooltip.get('trail')&&tooltip.get('status')=='active')
{domTT_show(in_owner.id,in_event);}}
function domTT_addPredefined(in_id)
{var options=new Hash();for(var i=1;i<arguments.length;i+=2)
{options.set(arguments[i],arguments[i+1]);}
domTT_predefined.set(in_id,options);}
function domTT_correctEdgeBleed(in_width,in_height,in_x,in_y,in_offsetX,in_offsetY,in_type,in_window)
{var win,doc;var bleedRight,bleedBottom;var pageHeight,pageWidth,pageYOffset,pageXOffset;win=(typeof(in_window)=='undefined'?window:in_window);if(domLib_standardsMode&&(domLib_isIE||domLib_isGecko))
{doc=win.document.documentElement;}
else
{doc=win.document.body;}
if(domLib_isIE)
{pageHeight=doc.clientHeight;pageWidth=doc.clientWidth;pageYOffset=doc.scrollTop;pageXOffset=doc.scrollLeft;}
else
{pageHeight=doc.clientHeight;pageWidth=doc.clientWidth;if(domLib_isKonq)
{pageHeight=win.innerHeight;}
pageYOffset=win.pageYOffset;pageXOffset=win.pageXOffset;}
if((bleedRight=(in_x-pageXOffset)+in_width-(pageWidth-domTT_screenEdgePadding))>0)
{in_x-=bleedRight;}
if((in_x-pageXOffset)<domTT_screenEdgePadding)
{in_x=domTT_screenEdgePadding+pageXOffset;}
if((bleedBottom=(in_y-pageYOffset)+in_height-(pageHeight-domTT_screenEdgePadding))>0){if(in_type=='sticky')
{in_y-=bleedBottom;}
else
{in_y-=in_height+(2*in_offsetY)+domTT_mouseHeight;}}
if((in_y-pageYOffset)<domTT_screenEdgePadding)
{if(in_type=='sticky')
{in_y=domTT_screenEdgePadding+pageYOffset;}
else
{in_y+=in_height+(2*in_offsetY)+domTT_mouseHeight;}}
return{'x':in_x,'y':in_y};}
function domTT_isActive(in_ownerId)
{var tooltip=domTT_tooltips.get(in_ownerId);if(!tooltip||tooltip.get('status')!='active')
{return false;}
else
{return true;}}
function domTT_runDeactivate(args){domTT_deactivate(args[0]);}
function domTT_runShow(args){domTT_show(args[0],args[1]);}
function domTT_replaceTitles()
{var elements=domLib_getElementsByClass('tooltip');for(var i=0;i<elements.length;i++)
{if(elements[i].title)
{var content=elements[i].title.replace(new RegExp('\'','g'),'\\\'');elements[i].onmouseover=new Function('in_event',"domTT_activate(this, in_event, 'content', '"+content+"')");elements[i].onmouseout=new Function('in_event',"domTT_deactivate(domTT_lastOpenID)");elements[i].title='';}}}