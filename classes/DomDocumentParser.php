<?php
class DomDocumentParser {

	private $doc;

	public function __construct($url) {

		$options = array(
			'http'=>array('method'=>"GET", 'header'=>"User-Agent: moodleBot/0.1\n")
			);
		$context = stream_context_create($options);

		$this->doc = new DomDocument();
		echo "URL: " . $url . "<br>";
		echo "Context: " . $context . "<br>";
		
		@$this->doc->loadHTML(file_get_contents($url, false, $context));
	}

	public function getlinks() {
		return $this->doc->getElementsByTagName("a");
	}

	public function getTitleTags() {
		return $this->doc->getElementsByTagName("title");
	}

	public function getMetaTags() {
		return $this->doc->getElementsByTagName("meta");
	}

	public function getImages() {
		return $this->doc->getElementsByTagName("img");
	}

}
?>