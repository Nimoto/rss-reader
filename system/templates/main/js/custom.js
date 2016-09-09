function  getWindowHeight(){
           var windowWidth, windowHeight;
           if (self.innerHeight) {
                   windowHeight = self.innerHeight;
           } else if (document.documentElement && document.documentElement.clientHeight) {
                   windowHeight = document.documentElement.clientHeight;
           } else if (document.body) {
                   windowHeight = document.body.clientHeight;
           }
           return windowHeight;
    }


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
	$.ajax({
	  type: "POST",
	  url: "/include/ajax/updateRss.php",
	  data: { refresh: 1 }
	}).done(function( html ) {
	  $(".rss-items-wrap").html(html);
	  $(".refresh").html("<i class=\"glyphicon glyphicon-refresh\"></i>");
	  DocumentReady();
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
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {read: direct}, function(){
		if(direct == -1){
			$(".read-f").attr("onclick", "SortRead(1);return false;");
			$(".read-f").addClass("btn-success");
			$(".read-f").removeClass("btn-default");
		}else{
			$(".read-f").addClass("btn-default");
			$(".read-f").removeClass("btn-success");
			$(".read-f").attr("onclick", "SortRead(-1);return false;");
		}		
	});
}

function ExcludeRss(el, id){
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {exclude_rss: id}, function(){
		$(el).remove();
		$("#rss"+id).attr("onclick", "ChooseRss("+id+");return false;");
		$("#rss"+id).removeClass("active");
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
		if($(".read-f").val() == "-1"){
			$(".rss-wrap-"+id).parent().remove();
		}else{
			$(el).parent().html("<a onclick=\"IsNotRead(this, '"+id+"');return false;\" href=\"#\"><i class=\"glyphicon glyphicon-ok\"></i></a>");
			$(".rss-wrap-"+id).removeClass("alert-info");
			$(".rss-wrap-"+id).addClass("alert-success");
		}
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
	$(".rss-points-wrap").append('<button name="exclude_rss" id="but'+id+'" onclick="ExcludeRss(this, '+id+'); return false;" value="'+id+'" type="submit" class="btn btn-info">'+$("#rss"+id).html()+'<i class="glyphicon glyphicon-remove"></i></button>');	
	$(".rss-items-wrap").load(location.href + " .rss-items-wrap > *", {include_rss: id}, function(){
		$("#rss"+id).attr("onclick", "var elem = document.getElementById('but"+id+"');ExcludeRss(elem, "+id+"); return false;");
	});
}

function OpenLink(el, link){
	console.log("open link" + link);
	$(".navbar-nav li").removeClass("active");
	$(".ajax-wrapper").load(link + " .ajax-wrapper > *", function(){
	 	DocumentReady();
	 	$(el).parent().addClass("active");
		if(!!(window.history && history.pushState)){
			history.pushState(null, null, link);
		}
	});
}

function setWrapHeight(){
	 var page_h = getWindowHeight();
	 $(".wrapper").css("min-height", (page_h - 120) + "px");
}

function DocumentReady(){
	 setWrapHeight();
	 var cnt = 0;
	 $(".select").mCustomScrollbar();

	 $("input[name=button_auth]").on("click", function(){
	 	$(".auth-panel").load(location.href + " .auth-panel > *", {full_name: $(".full_name").val(), login: $(".login").val(), pass: $(".pass").val(), confirm_pass: $(".confirm_pass").val(), email: $(".email").val(),  id: $(".id").val(), submit_auth: $(".send").val()}, function(){
	 		DocumentReady();
	 	});
	 });

	 $("input[name=button_rss_add]").on("click", function(){
	 	$(".user-rss-list-wrap").append('<div class="col-md-12"><div class="rss-wrapper alert  alert-info" id="new-rss'+(cnt)+'" role="alert">'+$(".rss_url").val()+'<div onclick=\'DeleteRss('+$(".id").val()+', "'+$(".rss_url").val()+'", "new-rss'+cnt+'")\' class="delete" data-url="'+$(".rss_url").val()+'"><i class="glyphicon glyphicon-remove"></i></div></div></div>');
	 	cnt++;
	 	$(".rss_add").load(location.href + " .rss_add > *", {rss_url: $(".rss_url").val(), id: $(".id").val(), submit_rss_add: $(".add").val()}, function(){	
	 		DocumentReady();
	 	});
	 });
}


$(document).ready(function(){
	 DocumentReady();
});

$(window).on("resize", function(){ 
	setWrapHeight();
});