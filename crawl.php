<?php  
include("classes/DomDocumentParser.php");

	function FollowLinks($url) {
		$parser = new DomDocumentParser($url);

		$linkList = $parser->getLinks();

		foreach ($linkList as $link ) {
			$href = $link->getAttribute("href");
			echo $href . "<br>";
		}
	}

$startUrl = "http://www.reecekenney.com";
FollowLinks($startUrl);

?>