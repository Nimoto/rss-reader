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
			$(".read-f").attr("onclick", "SortDate('desc');return false;");
			$(".read-f i").removeClass("glyphicon-sort-by-attributes-alt");
			$(".read-f i").addClass("glyphicon-sort-by-attributes");
		}else{
			$(".read-f").attr("onclick", "SortDate('asc');return false;");
			$(".read-f i").removeClass("glyphicon-sort-by-attributes");
			$(".read-f i").addClass("glyphicon-sort-by-attributes-alt");
		}
		
	});
}

function ExcludeRss(el, id){
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {exclude_rss: id}, function(){
		$(el).removeClass("btn-info");
		$(el).addClass("btn-default");
		$(el).attr("onclick", "IncludeRss(this, '"+id+"');return false;");
	});
}

function IncludeRss(el, id){
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {include_rss: id}, function(){
		$(el).removeClass("btn-default");
		$(el).addClass("btn-info");
		$(el).attr("onclick", "ExcludeRss(this, '"+id+"');return false;");
	});
}

function Paginator(el){
	$(".rss-items-wrap").load($(el).attr("href") + " .rss-items-wrap > *", function(){
		$('html, body').animate({ scrollTop: $(".pagination").offset().top }, 0);
		if(!!(window.history && history.pushState)){
			history.pushState(null, null, $(el).attr("href"));
		}
	});
}