<?php  
include("classes/DomDocumentParser.php");

$alreadyCrawled = array();
$crawling = array();

	function createLink($src, $url) {
		$scheme = parse_url($url)["scheme"]; //http
		$host = parse_url($url)["host"]; //website ex. www.bbc.com

		if (substr($src, 0,2) == '//') {
			$src = $scheme . ":" . $src;
		}
		elseif (substr($src,0,1) =="/") {
			$src = $scheme . "://" . $host . $src;
		}
		elseif (substr($src,0,2) =="./") {
			$src = $scheme . "://" . $host . dirname(parse_url($url)["path"]) . substr($src, 1);
		}
		elseif (substr($src,0,3) =="../") {
			$src = $scheme . "://" . $host .  "/" . $src;
		}
		elseif (substr($src,0,5) !="https" && substr($src,0,4) !="http") {
			$src = $scheme . "://" . $host . "/" . $src;
		}


		return $src;
	}

	function getDetails($url) {
		$parser = new DomDocumentParser($url);

		$titleArray = $parser->getTitleTags();

		$title = $titleArray->item(0)->nodeValue;

		$title = str_replace("\n", "", $title);

		if (sizeof($titleArray) == 0 || $titleArray-> item(0) == NULL) {
			return;
		}

		if($title == "") {
			return;
		}

	$description = "";
	$keywords = "";

	$metasArray = $parser->getMetatags();

	foreach($metasArray as $meta) {

		if($meta->getAttribute("name") == "description") {
			$description = $meta->getAttribute("content");
		}

		if($meta->getAttribute("name") == "keywords") {
			$keywords = $meta->getAttribute("content");
		}

		//echo $meta->getAttribute("name") . "<br>";
		//echo $meta->getAttribute("content") . "<br>";


	}

	$description = str_replace("\n", "", $description);
	$keywords = str_replace("\n", "", $keywords);

	echo "URL: $url, Description: $description, keywords: $keywords<br>";

	}

	function FollowLinks($url) {
		global $alreadyCrawled;
		global $crawling;

		$parser = new DomDocumentParser($url);

		$linkList = $parser->getLinks();

		foreach ($linkList as $link ) {
			$href = $link->getAttribute("href");

			if(strpos($href, "#") !== false) {
				continue;
			}
			else if (substr($href, 0,11) == "javascript:") {
				continue;
			} 

			$href = createLink($href, $url);

			if (!in_array($href, $alreadyCrawled)) {
				$alreadyCrawled[] = $href;
				$crawling[] = $href;

				getDetails($href);
			}
			else return;

			//echo $href . "<br>";

			array_shift($crawling);

			foreach($crawling as $site) {
				FollowLinks($site);
			}


		}
	}

$startUrl = "http://www.cnn.com";
FollowLinks($startUrl);

?>