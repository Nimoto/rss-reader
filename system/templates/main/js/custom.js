function DeleteRss(user_id, url, parent_id){
	$.ajax({
	  type: "POST",
	  url: "/include/ajax/deleteRss.php",
	  data: { user_id: user_id, url: url }
	}).done(function( msg ) {
	  $("#"+parent_id).remove();
	});
	return false;
}

function RefreshRss(){	
	$(".refresh").html("<img class='loader' src='/system/templates/main/img/loader.png'>");
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {refresh: 1}, function(){
		$(".refresh").html("<i class=\"glyphicon glyphicon-refresh\"></i>");		
	});
	return false;
}

function PlayPodcast(url){
	$(".player").css("display", "block");
	$(".player audio").attr("src", url);
	$(".player audio").attr("autoplay", true);
	return false;
}

function SortDate(direct){
	$(".read-f").removeClass("btn-warning");
	$(".read-f").addClass("btn-success");
	$(".date-f").removeClass("btn-success");
	$(".date-f").addClass("btn-warning");
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {date: direct}, function(){
		if(direct == "asc"){
			$(".date-f").attr("onclick", "SortDate('desc');return false;");
			$(".date-f i").removeClass("glyphicon-sort-by-attributes-alt");
			$(".date-f i").addClass("glyphicon-sort-by-attributes");
		}else{
			$(".date-f").attr("onclick", "SortDate('asc');return false;");
			$(".date-f i").removeClass("glyphicon-sort-by-attributes");
			$(".date-f i").addClass("glyphicon-sort-by-attributes-alt");
		}
	});
}
function SortRead(direct){
	$(".date-f").removeClass("btn-warning");
	$(".date-f").addClass("btn-success");
	$(".read-f").removeClass("btn-success");
	$(".read-f").addClass("btn-warning");
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {read: direct}, function(){
		if(direct == "asc"){
			$(".read-f").attr("onclick", "SortRead('desc');return false;");
			$(".read-f i").removeClass("glyphicon-sort-by-attributes-alt");
			$(".read-f i").addClass("glyphicon-sort-by-attributes");
		}else{
			$(".read-f").attr("onclick", "SortRead('asc');return false;");
			$(".read-f i").removeClass("glyphicon-sort-by-attributes");
			$(".read-f i").addClass("glyphicon-sort-by-attributes-alt");
		}
		
	});
}

function ExcludeRss(el, id){
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {exclude_rss: id}, function(){
		$(el).remove();
	});
}

/*
function IncludeRss(el, id){
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {include_rss: id}, function(){
		$(el).removeClass("btn-default");
		$(el).addClass("btn-info");
		$(el).attr("onclick", "ExcludeRss(this, '"+id+"');return false;");
	});
}*/

function Paginator(el){
	$(".rss-items-wrap").load($(el).attr("href") + " .rss-items-wrap > *", function(){
		$('html, body').animate({ scrollTop: $(".pagination").offset().top }, 0);
		if(!!(window.history && history.pushState)){
			history.pushState(null, null, $(el).attr("href"));
		}
	});
}

function IsRead(el, id){
	$.ajax({
	  type: "POST",
	  url: "/include/ajax/isRead.php",
	  data: { id: id, action: 1 }
	}).done(function( msg ) {
		$(el).parent().html("<a onclick=\"IsNotRead(this, '"+id+"');return false;\" href=\"#\"><i class=\"glyphicon glyphicon-ok\"></i></a>");
		$(".rss-wrap-"+id).removeClass("alert-info");
		$(".rss-wrap-"+id).addClass("alert-success");
	});
	return false;
}

function IsNotRead(el, id){
	$.ajax({
	  type: "POST",
	  url: "/include/ajax/isRead.php",
	  data: { id: id, action: 0 }
	}).done(function( msg ) {
		$(el).parent().html("<a onclick=\"IsRead(this, '"+id+"');return false;\" href=\"#\">отметить как<br />прочитанное</a>");
		$(".rss-wrap-"+id).removeClass("alert-success");
		$(".rss-wrap-"+id).addClass("alert-info");
	});
	return false;
}

function ReadAllRss(user_id){
	$.ajax({
	  type: "POST",
	  url: "/include/ajax/isRead.php",
	  data: { user_id: user_id, action: 1 }
	}).done(function( msg ) {
		$(".is-read").html("<a onclick=\"IsNotRead(this, '"+user_id+"');return false;\" href=\"#\"><i class=\"glyphicon glyphicon-ok\"></i></a>");
		$(".rss-wrapper").removeClass("alert-info");
		$(".rss-wrapper").addClass("alert-success");
	});
	return false;
}

function ChooseRss(id){
	$("#rss"+id).addClass("active");
	$(".rss-points-wrap").append('<button name="exclude_rss" onclick="ExcludeRss(this, '+id+'); return false;" value="'+id+'" type="submit" class="btn btn-info">'+$("#rss"+id).html()+'<i class="glyphicon glyphicon-remove"></i></button>');	
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {include_rss: id}, function(){
		
	});
}