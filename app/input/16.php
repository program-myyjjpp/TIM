<input id="<?php echo($inputname);?>"  class="inputtext" name="<?php echo($inputname);?>" type="text" value="<?php echo($inputvalue);?>" hx="<?php echo($inputvalue);?>" />
<script type="text/javascript">
$(function(){
	if (typeof(insertiColorPicker)=="undefined")
	{
		insertiColorPicker='a';
		(function(a){a(function(){a(document).bind("click",function(){if($iColor.is(":visible")){$iColor.fadeOut("fast")[0].tar=null}});$iColor=a('<div id="iColorPicker"><table class="pickerTable"><thead></thead><tbody><tr><td colspan="16" id="colorPreview"></td></tr></tbody></table></div>').css({"display":"none","position":"absolute"}).appendTo(a("body")).each(function(){var b=[],c="",d=["f00","ff0","0f0","0ff","00f","f0f","fff","ebebeb","e1e1e1","d7d7d7","ccc","c2c2c2","b7b7b7","acacac","a0a0a0","959595","ee1d24","fff100","00a650","00aeef","2f3192","ed008c","898989","7d7d7d","707070","626262","555","464646","363636","262626","111","000","f7977a","fbad82","fdc68c","fff799","c6df9c","a4d49d","81ca9d","7bcdc9","6ccff7","7ca6d8","8293ca","8881be","a286bd","bc8cbf","f49bc1","f5999d","f16c4d","f68e54","fbaf5a","fff467","acd372","7dc473","39b778","16bcb4","00bff3","438ccb","5573b7","5e5ca7","855fa8","a763a9","ef6ea8","f16d7e","ee1d24","f16522","f7941d","fff100","8fc63d","37b44a","00a650","00a99e","00aeef","0072bc","0054a5","2f3192","652c91","91278f","ed008c","ee105a","9d0a0f","a1410d","a36209","aba000","588528","197b30","007236","00736a","0076a4","004a80","003370","1d1363","450e61","62055f","9e005c","9d0039","790000","7b3000","7c4900","827a00","3e6617","045f20","005824","005951","005b7e","003562","002056","0c004b","30004a","4b0048","7a0045","7a0026"];a.each(d,function(f,e){c+='<td style="background:#'+e+'" hx="'+e+'"></td>';if(f%16==15){b.push("<tr>"+c+"</tr>");c=""}});a(this).find("thead").html(b.join(""))}).on({"mouseover":function(b){var c=a(b.target).attr("hx");c!=undefined&&a("#colorPreview").css("background","#"+c).attr("hx",c)},"click":function(b){var c=this.tar,d=a(b.target).attr("hx");if(!d){b.stopPropagation();return false}c.set.call(a(c).attr("hx",d),d)},"coord":function(c){var b=a.extend({"x":0,"y":0},c.num||null);a(this).fadeIn("fast").css({"top":c.posix.y+b.y,"left":c.posix.x+b.x})}})});a.fn.iColor=function(b,d){var c=a.extend({"x":0,"y":0,"type":"click","open":function(){},"set":function(f){var e="#"+f;this[!this.attr("type")?"html":"val"](e).css("background",e)}},b);return this.each(function(){var f=a(this),e=f.attr("hx");this.set=d||(a.isFunction(b)?b:c.set);if(e){e=a.trim(e);if(e[0]=="#"){e=e.substring(1)}!this.set&&console.log(this);e.length&&this.set.call(f,e+["","00","0"][e.length%3])}})[c.type](function(h){var g=h.target,f=$iColor[0].tar||null;if(f==g&&g.show){return}g.show=true;h.stopPropagation();c.open.call(a(g),h);$iColor.trigger({"type":"coord","num":d,"posix":{"x":h.pageX,"y":h.pageY}})[0].tar=g})}})(jQuery);
	}
	$("#<?php echo($inputname);?>").iColor({
		'type': 'click', 
		'open': function(e) {
			var color = this.data('color');
		},
		'set': function(hx) {
			this.data('color', '#'+hx);
			this.val('').css('background', '#' + hx);
			$("#<?php echo($inputname);?>").val('#'+hx);
		}
	});
});
</script>