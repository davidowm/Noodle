$(document).ready(function() {
	
	$(".result").on("click", function(){
		
		var id = $(this).attr("data-linkid");
		var url = $(this).attr("href");
		
		console.log(id);

		if(!id){
			alert("data-linkid attribute not found");
		}

		increaseLinkClicks(id,url);

		console.log(id);

		return false;
	});
});

function increaseLinkClicks(linkId, url){

	console.log("increaseLinkClicks")

	console.log(linkId);

	$.post("ajax/updateLinkCount.php", {linkId: linkId}).done(function(result){
		if(result != "") {
			alert(result);
			return;

		}

		window.location.href = url;
	});
}