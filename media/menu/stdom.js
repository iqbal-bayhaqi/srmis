/*=======Ver: 6.1.50831========*/
function stgPStr(p){var s="",its="",scr=(p.typ&2)/2,v=p.typ&1;with(p){its+=scr?"<table id='"+ids+"sct' cellpadding=0 cellspacing=0 "+stgCss(28)+">"+(v?"<tr "+stgCss(28)+">":"")+"<td  id='"+ids+"s0' align='center' valign='middle' "+stgCss(28,"display:none;")+">"+stgIStr(sc[0])+"</td>"+(v?"</tr><tr "+stgCss(28)+">":""):"";its+=scr?"<td  id='"+ids+"scc' "+stgCss(28)+"><div  id='"+ids+"sc"+"' "+stgCss(31)+">":"";its+="<table cellpadding=0 cellspacing="+mar+" id='"+ids+"tb"+"' "+stgCss(28)+(hal?" align="+stHAL[hal]:"")+">";for(var j=0;j<is.length;j++)its+=(v?"<tr "+stgCss(28)+">":"")+"<td "+stgCss(28)+">"+stgIStr(is[j])+"</td>"+(v?"</tr>":"");its+="</table>";its+=scr?"</div></td>":"";its+=scr?(v?"</tr><tr "+stgCss(28)+">":"")+"<td id='"+ids+"s1' align='center' valign='middle' "+stgCss(28,"display:none;")+">"+stgIStr(sc[1])+"</td>"+(v?"</tr>":"")+"</table>":"";s+="<table cellpadding=0 cellspacing=0 id='"+ids+"' "+stgCss(16,stgBg(bgC,bgI,bgR)+stgBd(bdW,bd,bdC)+"visibility:hidden;")+(hal?" align="+stHAL[hal]:"")+" "+stgEnt(p)+(wid?" width="+wid:"")+(hei?" height="+hei:"")+">";if(decH[0]){s+="<tr "+stgCss(28)+">"+(decW[3]?"<td width="+decW[3]+" height="+decH[0]+" id='"+ids+"c0"+"'  "+stgCss(28)+">"+stgImg(p.ids+"cor0",cor[0],decW[3],decH[0],0)+"</td>":"")+"<td id='"+ids+"d0"+"' "+stgCss(28)+">"+stgImg(p.ids+"dec0",dec[0],decW[0],decH[0],decB[0])+"</td>"+(decW[1]?"<td width="+decW[1]+" height="+decH[0]+" id='"+ids+"c1"+"' "+stgCss(28)+">"+stgImg(p.ids+"cor1",cor[1],decW[1],decH[0],0)+"</td>":"")+"</tr>";}s+="<tr "+stgCss(28)+">"+(decW[3]?"<td id='"+ids+"d3"+"' "+stgCss(28)+">"+stgImg(ids+"dec3",dec[3],decW[3],decH[3],decB[3])+"</td>":"")+"<td id='"+ids+"txt' "+stgCss(28)+">"+its+"</td>"+(decW[1]?"<td id='"+ids+"d1"+"' "+stgCss(28)+">"+stgImg(ids+"dec1",dec[1],decW[1],decH[1],decB[1])+"</td>":"")+"</tr>";if(decH[2]){s+="<tr "+stgCss(28)+">"+(decW[3]?"<td width="+decW[3]+" height="+decH[2]+"  id='"+ids+"c3"+"' "+stgCss(28)+">"+stgImg(ids+"cor3",cor[3],decW[3],decH[2],0)+"</td>":"")+"<td id='"+ids+"d2"+"' "+stgCss(28)+">"+stgImg(ids+"dec2",dec[2],decW[2],decH[2],decB[2])+"</td>"+(decW[1]?"<td width="+decW[1]+" height="+decH[2]+" id='"+ids+"c2"+"' "+stgCss(28)+">"+stgImg(ids+"cor2",cor[2],decW[1],decH[2],0)+"</td>":"")+"</tr>";}s+="</table>";}return s }
function stgIStr(i){var s="",t=i.typ&3;with(i){		s+=st_nav.nam!="konqueror"&&lnk?"<a  href='"+lnk+"' target='"+tar+"' id='"+i.ids+"lnk' "+stgCss(31,"text-decoration:none")+">":"";s+="<table cellspacing=0 cellpadding="+pad+" id='"+ids+"' "+stgCss(16,(wid?"width:"+stAdb(wid,0)+";":"")+(hei?"height:"+stAdb(hei,0)+";":"")+stgBd(bdW,bd,bdC[(stat&262144)/262144])+stgBg(bgC[(stat&512)/512],bgI[(stat&4096)/4096],bgR[(stat&32768)/32768])+stgCur(lnk?cur[1]:cur[0]))+" "+stgEnt(i)+" align='"+stHAL[hal]+"' valign='"+stVAL[val]+"'>";s+=icoW&&icoH?"<td id='"+ids+"il' "+stgCss(28)+" width="+lw+">"+stgImg(ids+"ico",ico[(stat&8)/8],icoW,icoH,icoB)+"</td>":"";s+="<td id='"+ids+"im' align='"+stHAL[thal]+"' valign='"+stVAL[tval]+"' "+stgCss(12,stgFnt(colr[(stat&2097152)/2097152],fnt[(stat&16777216)/16777216],dec[(stat&134217728)/134217728]))+" nowrap>";s+=t==2?stgImg(ids+"img",img[stat&1],imgW,imgH,imgB):txt;	s+="</td>";s+=arrW&&arrH?"<td id='"+ids+"ir' "+stgCss(28)+" align='right' width="+rw+">"+stgImg(ids+"arr",arr[(stat&64)/64],arrW,arrH,arrB)+"</td>":"";s+="</table>";	s+=st_nav.nam!="konqueror"&&lnk?"</a>":"";	}return s;}
function stgObj(i,w){if(!w)w=window;return w.document.getElementById(i);}
function stAdb(s,b){if(isNaN(s)){if(s.charAt(s.length-1)=="%") return s;else if(s.substr(s.length-2)=="px") return (parseInt(s)+b)+"px";}else return (s+b)+"px";}
function stgCss(a,s){if(!s)s="";var c="";for(var j=0;j<stCSSN.length;j++){var b=Math.pow(2,j);if((a&b)/b)c+=stCSSN[j]+":"+stCSSV[j]+";";}c+=s;if(c)return "style=\""+c+"\"";else return "";}
function stgBd(w,s,c){if(s=="none") return "";return "border-width:"+w+"px;border-style:"+stBDS[s]+";border-color:"+c+";"}
function stgBg(c,i,r){return "background-color:"+c+(i?";background-image:url("+i+");background-repeat:"+stREP[r]:"")+";"}
function stgCur(c){return c?"cursor:"+c+";":"";}
function stgFnt(c,f,d){return "color:"+c+";font:"+f+";"+stgTd(d);}
function stgTd(v,f){if(f) return (v?(v&1?"underline ":"")+(v&2?"line-through ":"")+(v&4?"overline":""):"none");return "text-decoration:"+(v?(v&1?"underline ":"")+(v&2?"line-through ":"")+(v&4?"overline":""):"none")+";";}
function stgEnt(o){var s="",f="",m=st_ms[o.mid];if(o.frm)	f=stgsfrm(m);for(var j=0;j<stENTS.length;j++)if(o[stENTS[j]]) s+=stENTS[j]+"=\""+f+"stsEnt(event,this,"+j+",'st_ms["+o.mid+"]"+(typeof(o.pid)=="undefined"?".ps["+o.id+"]":((o.typ&17)/8==2?".ps["+o.pid+"].sc["+o.sid+"]":".ps["+o.pid+"].is["+o.id+"]"))+"')\" ";return s;}
function stsEnt(e,o,ei,d){if(!stckD(o)) o._dat=eval(d);var t=o._dat;if(!t) return;switch(ei){case 0:if(!t.isOv&&!stisPar(o,e.relatedTarget)){eval(t.onmouseover+"(t)");t.isOv=1;}break;case 1:if(!e.relatedTarget||!stisPar(o,e.relatedTarget)){eval(t.onmouseout+"(t)");t.isOv=0;}break;case 2:e.cancelBubble=true;eval(t.onclick+"(t)");}}
function stisPar(p,c){if(!p||!c) return false;if(p==c) return true;do{if(c.parentNode)c=c.parentNode;else return false;if(p==c) return true;}while(c);return false;}
function staddP(p,w){if(!w)w=window;var d=w.document;if(w!=window) {p.frm=w.name;for(var j=0;j<p.is.length;j++)p.is[j].frm=w.name;if(p.typ&2==2){p.sc[0].frm=w.name;p.sc[1].frm=w.name;}}else if(p.frm){p.frm=0;for(var j=0;j<p.is.length;j++)p.is[j].frm=0;if(p.typ&2==2){p.sc[0].frm=0;p.sc[1].frm=0;}}try{			if(p.isSt)d.write(stgPStr(p));else {var o=d.createElement("div");o.style.margin="0px";o.style.padding="0px";o.style.fontStyle="normal";o.style.backgroundColor="transparent";o.style.borderStyle="none";o.style.position="absolute";o.style.left="0px";o.style.top="-9999px";o.style.visibility="hidden";o.style.zIndex=p.zid;o.id=p.ids+"dv";o.innerHTML=stgPStr(p);if(d.body.childNodes.length)d.body.insertBefore(o,d.body.childNodes[0]);else d.body.appendChild(o)}}catch(e){	if(p.frm){p.frm=0;for(var j=0;j<p.is.length;j++)p.is[j].frm=0;if(p.typ&2==2){p.sc[0].frm=0;p.sc[1].frm=0;}}	return false;}return true;}
function stsPop(p,w){if(!w)w=window;var scr=p.typ&2;p._layer=stgObj(p.ids,w);if(!p.isSt)p._shell=stgObj(p.ids+"dv",w);if(scr) p._sc=stgObj(p.ids+"sc",w);if(p.decH[0]) p._dec0=stgObj(p.ids+"d0",w);if(p.decW[1]) p._dec1=stgObj(p.ids+"d1",w);if(p.decH[2]) p._dec2=stgObj(p.ids+"d2",w);if(p.decW[3])p._dec3=stgObj(p.ids+"d3",w);if(p.decH[0]&&p.decW[3]) p._cor0=stgObj(p.ids+"c0",w);if(p.decH[0]&&p.decW[1]) p._cor1=stgObj(p.ids+"c1",w);if(p.decH[2]&&p.decW[1]) p._cor2=stgObj(p.ids+"c2",w);if(p.decH[2]&&p.decW[3]) p._cor3=stgObj(p.ids+"c3",w);stpPre(p,w);}
function stpPre(p,w){if((p.typ&2)/2) {for(var j=0;j<2;j++){stsIt(p.sc[j],w);stiPre(p.sc[j],w);}}for(var j=0;j<p.is.length;j++){stsIt(p.is[j],w);stiPre(p.is[j],w);}var rc=stgRc(p._layer);if(!p.isSt){p._shell.style.top=rc[0]+"px";p._shell.style.left=rc[1]+"px";}p._rc=rc;p._layer.style.visibility="";}
function stiPre(i,w){if(i.hei=="100%")i._layer.style.height=i._layer.parentNode.offsetHeight+"px";}
function stsIt(i,w){i._layer=stgObj(i.ids,w);i._font=stgObj(i.ids+"im",w);if(i.icoW) i._left=stgObj(i.ids+"ico",w);if(i.arrW) i._right=stgObj(i.ids+"arr",w);if((i.typ&3)==2) i._img=stgObj(i.ids+"img",w);if(i.lnk)	i._anchor=stgObj(i.ids+"lnk",w);	}
function stgRc(o){if(!o) return;var x=y=w=h=0;w=o.offsetWidth;h=o.offsetHeight;while(o){		x+=o.offsetLeft;y+=o.offsetTop;if((st_nav.nam=="konqueror"||st_nav.nam=="safari")&&o.style&&o.style.position.toLowerCase()=="absolute") break;if(o.parentNode&&o.parentNode.tagName=="DIV"&&o.parentNode.style.overflow.toLowerCase()=="hidden"){x-=o.parentNode.scrollLeft;y-=o.parentNode.scrollTop;}o=o.offsetParent;}return [x,y,w,h]}
function stckL(d,w){if(!w)w=window;var l;try{if(l=stgObj(d.ids,w))return d._layer=l;else return false;}catch(e){return false;}}
function stckD(c){if(c._dat) return true; return false;}
function stcIt(i,f){if(i.lock) return;if(i.stat==f) return;var m=st_ms[i.mid];	if(!stusrE(4,i,m)) return;	var o=i._layer,l=i._left,r=i._right,im=i._img,fn=i._font;with(i){if(o){if((stat&512)!=(f&512)&&bgC[(stat&512)/512]!=bgC[(f&512)/512])o.style.backgroundColor=bgC[(f&512)/512];if((stat&4096)!=(f&4096)&&bgI[(stat&4096)/4096]!=bgI[(f&4096)/4096])o.style.backgroundImage="url("+bgI[(f&4096)/4096]+")";if((stat&32768)!=(f&32768)&&bgR[(stat&32768)/32768]!=bgR[(f&32768)/32768])o.style.backgroundRepeat=stREP[bgR[(f&32768)/32768]];if((stat&262144)!=(f&262144)&&bdC[(stat&262144)/262144]!=bdC[(f&262144)/262144])o.style.borderColor=bdC[(f&262144)/262144];if((stat&2097152)!=(f&2097152)&&colr[(stat&2097152)/2097152]!=colr[(f&2097152)/2097152])fn.style.color=colr[(f&2097152)/2097152];if((stat&16777216)!=(f&16777216)&&fnt[(stat&16777216)/16777216]!=fnt[(f&16777216)/16777216])fn.style.font=fnt[(f&16777216)/16777216];		if((stat&134217728)!=(f&134217728)&&dec[(stat&134217728)/134217728]!=dec[(f&134217728)/134217728])fn.style.textDecoration=stgTd(dec[(f&134217728)/134217728],1);}if(l){if((stat&8)!=(f&8)&&ico[(stat&8)/8]!=ico[(f&8)/8])l.src=ico[(f&8)/8]?ico[(f&8)/8]:m.bnk;}if(r){if((stat&64)!=(f&64)&&arr[(stat&64)/64]!=arr[(f&64)/64])r.src=arr[(f&64)/64]?arr[(f&64)/64]:m.bnk;}if(im){if((stat&1)!=(f&1)&&img[(stat&1)/1]!=img[(f&1)/1])im.src=img[(f&1)/1]?img[(f&1)/1]:m.bnk;}	stat=f;}if(!stusrE(5,i,st_ms[i.mid])) return;}
function stick(i){if(i.myclick&&!i.myclick()) return;if(st_ms[i.mid].cks&1) {var m=st_ms[i.mid];for(var j=0;j<m.ps[0].is.length;j++){if(!(m.cks&2))m.ps[0].is[j].lock=0;if(m.ps[0].is[j].subP) m.ps[0].is[j].subP.lock=0;}				stcIt(i,i.ovst);if(i.subP) stshP(i.subP)}if(i.frm){i.parP.isOv=0;sthdPX(i.parP,2);}	if(i.lnk){if(st_nav.nam=="konqueror") window.open(i.lnk,i.tar);i._anchor.click();}}
function stiov(i){var m=st_ms[i.mid],sp=i.subP,pp=i.parP;if(i.myover&&!i.myover()) return;stcIt(i,i.ovst);if(pp.cIt&&pp.cIt!=i&&pp.cIt.subP){clearTimeout(pp.cIt.subP.tid);sthdPX(pp.cIt.subP,1);}pp.cIt=i;if(sp){clearTimeout(sp.tid);if(!sp.isSh||!sp.exed)sp.tid=setTimeout("stshP(st_ms["+sp.mid+"].ps["+sp.id+"]);",pp.typ&1?m.deSV:m.deSH);}}
function stiou(i){var m=st_ms[i.mid],sp=i.subP;if(i.myout&&!i.myout()) return;if(!i.subP||!i.subP.isSh)	stcIt(i,i.oust);if(sp){clearTimeout(sp.tid);sp.tid=setTimeout("sthdP(st_ms["+sp.mid+"].ps["+sp.id+"])",m.deHd);}}
function stpov(p){if(p.myover&&!p.myover()) return;clearTimeout(p.tid);while(p.parI){stcIt(p.parI,p.parI.ovst);clearTimeout(p.parI.parP.tid);p.parI.parP.cIt=p.parI;p=p.parI.parP;}}
function stpou(p){	if(p.myout&&!p.myout()) return;var m=st_ms[p.mid];var cs=";stusrE(6,st_ms["+p.mid+"].ps["+p.id+"],st_ms["+p.mid+"])";p.tid=setTimeout("sthdPX(st_ms["+p.mid+"].ps["+p.id+"])"+cs,m.deHd);}
function stuIts(m){for(var j=0;j<m.ps.length;j++)for(var k=0;k<m.ps[j].is.length;k++)stcIt(m.ps[j].is[k],m.ps[j].is[k].oust)}
function stshP(p){var o,m=st_ms[p.mid],w=p.id?stgtfrm(m):window;if(!stckL(p,w)){if(w&&staddP(p,w))stsPop(p,w);else if(m.cfsh&&!stckL(p))if(staddP(p))	stsPop(p);else return;else if(!m.cfsh)	return;	}	if(p.lock) return;if(o=p._shell)	{if(!stusrE(0,p,m)) return;	if(!p.isSt){var xy=stgPxy(p,1);o.style.left=xy[0]+"px";o.style.top=xy[1]+"px";}o.style.visibility="visible";p.isSh=1;p.exed=1;if(!m.hdp) p.lock=1;if(!stusrE(1,p,m)) return;}}
function sthdP(p){var m=st_ms[p.mid],o;if(!p._layer) return;if(p.lock) return;if(!stusrE(2,p,m)) return;	if(o=p._shell)o.style.visibility="hidden";if(p.parI)stcIt(p.parI,p.parI.oust);p.isSh=0;p.exed=1;if(!stusrE(3,p,m)) return;	}
function sthdPX(p,f){var cp=p;if(f)while(cp.cIt&&cp.cIt.subP&&cp.cIt.subP.isSh)cp=cp.cIt.subP;while(cp){if(cp.isOv||!cp.isSh||cp.isSt) break;clearTimeout(cp.tid);sthdP(cp);		cp.cIt=0;	if(f==1&&cp==p)break;if(cp.parI)cp=cp.parI.parP;else break;}}
function stgPxy(p){		var m=st_ms[p.mid],mx=eval(m.x),my=eval(m.y);mx=isNaN(mx)?0:mx;my=isNaN(my)?0:my;	var irc=p.parI?stgRc(p.parI._layer):[mx,my,0,0],prc=p.isSt?stgRc(p._layer):stgRc(p._shell),xd=p.dir&3,yd=(p.dir&12)/4,x=y=0,win=window,cf=p.frm&&p.frm!=window.name;if(cf)win=stgtfrm(m);var cl=stgcl(win),ct=stgct(win),cw=stgcw(win),ch=stgch(win);switch(xd){case 0:x=irc[0]-prc[2];break;case 1:x=irc[0];break;case 2:x=irc[0]+irc[2]-prc[2];break;case 3:x=irc[0]+irc[2];}switch(yd){case 0:y=irc[1]-prc[3];break;case 1:y=irc[1];break;case 2:y=irc[1]+irc[3]-prc[3];break;case 3:y=irc[1]+irc[3];}if(cf&&p.frm!=p.parI.frm){switch(m.cfD){case 0:y=0;break;case 1:y=ch-prc[3];break;case 2:x=0;break;case 3:x=cw-prc[2];break;}x+=cl;y+=ct;x=x+m.cfX;y=y+m.cfY;if(m.sfrn){var wcl=stgcl(),wct=stgct();if(!m.cfD||m.cfD==1)x-=wcl;if(m.cfD==2||m.cfD==3)y-=wct;}}y+=p.offY;x+=p.offX;if(arguments[1]&&p.id){	if(x+prc[2]>cl+cw) x=cl+cw-prc[2];if(y+prc[3]>ct+ch) y=ct+ch-prc[3];		if(x<cl) x=cl;if(y<ct) y=ct;}	p._rc=[x,y,prc[2],prc[3]];return [x,y]}
function stgcl(w){if(!w)w=window; return w.pageXOffset;}
function stgct(w){if(!w)w=window; return w.pageYOffset;}
function stgcw(w){if(!w)w=window; if(w.document.body.scrollTop)return w.innerWidth-16;return w.innerWidth;}
function stgch(w){if(!w)w=window; 		if(w.document.body.scrollLeft)return w.innerHeight-16;return w.innerHeight }
function stgImg(id,s,w,h,b){if(!s){s=st_cm.bnk;w=w==-1?1:w;h=h==-1?1:h;}return "<img id='"+id+"' src='"+s+"'"+(w!=-1?" width="+w:"")+(h!=-1?" height="+h:"")+" border="+b+">";}
function stmvto(xy,p){if(p.isSt||!p.isSh) return;var l=p._shell;l.style.left=xy[0]+"px";l.style.top=xy[1]+"px";p._rc=[xy[0],xy[1],p._rc[2],p._rc[3]]}
function stwinr(w){if(!w) return false;try{if(w.document&&w.document.body)return true;else return false;}catch(e){return false;}}
