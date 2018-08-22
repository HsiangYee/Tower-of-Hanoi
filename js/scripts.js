location.get=function(k){
	var data={};
	location.search.substr(1).split('&').forEach(function(s){
		s=s.split('=');
		var k=s.shift(),v=s.join('=');
		v=decodeURIComponent(v);
		
		data[k]=v;
	});
	
	if(k) return data[k];
	return data;
};

location.change=function(data){
	var get=this.get();
	for(var k in data){
		get[k]=data[k];
	}
	
	var arr=[];
	for(var j in get){
		arr.push(
			encodeURIComponent(j)+'='+encodeURIComponent(get[j])
		);
	}
	
	this.href=this.pathname+'?'+arr.join('&');
};

$(function(){
	$('.brick').draggable({
		revert:	'invalid'
	});
	
	$('.col').droppable({
		drop:	function(e,u){
			
		}
	});
	
});