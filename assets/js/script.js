var timer;

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

	var grid = $(".imageResults");

	grid.on("layoutComplete",function(){
		$(".gridItem img").css("visibility", "visible");
	});

	grid.masonry({
		itemSelector: ".gridItem",
		columnWidth: 200,
		gutter: 5,
		isInitLayout: false
	});


	$("[data-fancybox]").fancybox({
		caption : function( instance, item ) {
	        var caption = $(this).data('caption') || '';
			var siteUrl = $(this).data('siteurl') || '';
	        if ( item.type === 'image' ) {
	            caption = (caption.length ? caption + '<br />' : '') 
	            + '<a href="' + item.src + '">View image</a><br>'
	            + '<a href="' + siteUrl + '">Visit page</a>';
	        }

	        return caption;
	    },		
		afterShow : function( instance, item ) {
				increaseImageClicks(item.src);
	        }

	});

});

function loadImage(src,className){
	var image = $("<img>");
	//console.log(className);
	//console.log(image);

	image.on("load", function(){
		$("." + className + " a").append(image);
		
		clearTimeout(timer);

		timer = setTimeout(function(){
		$(".imageResults").masonry();
		},500);	
		
	});

	image.on("error", function(){
		//console.log("Error - broken");
		$("." + className).remove();
		$.post("ajax/setBroken.php",{src: src});
	});

	image.attr("src", src);
}

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

function increaseImageClicks(imageUrl){

	//console.log("increaseLinkClicks")

	//console.log(linkId);

	$.post("ajax/updateImageCount.php", {imageUrl: imageUrl}).done(function(result){
		if(result != "") {
			alert(result);
			return;

		}

		window.location.href = url;
	});	
}