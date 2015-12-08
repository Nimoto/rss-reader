function DeleteRss(user_id, url, parent_id){
	$.ajax({
	  type: "POST",
	  url: "/include/ajax/deleteRss.php",
	  data: { user_id: user_id, url: url }
	}).done(function( msg ) {
	  $("#"+parent_id).remove();
	});
}