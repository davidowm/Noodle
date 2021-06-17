<?php  
INCLUDE("CONFIG.PHP");
INCLUDE("classes/SiteResultsProvider.php");
INCLUDE("classes/ImageResultsProvider.php");

	if (isset($_GET["term"])) {
		$term = $_GET["term"];
	}
	else{
		exit("You must enter a search term");
	}
	

	$type = isset($_GET["type"]) ? $_GET["type"] : "sites";
	$page = isset($_GET["page"]) ? $_GET["page"] : "1";

	/* Code above is the same as code below...
	if (isset($_GET["type"])) {
		$type = $_GET["type"];
	}
	else{
		$type = "sites";
	}
	*/

?>



<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Doodle</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
</head>
<body>

	<div class="wrapper">
	
		<div class="header">


			<div class="headerContent">

				<div class="logoContainer">
					<a href="index.php">
						<img src="assets/images/Logo.png">
					</a>
				</div>

				<div class="searchContainer">

					<form action="search.php" method="GET">

						<div class="searchBarContainer">
							<input type="hidden" name="type" value="<?php echo $type; ?>">
							<input class="searchBox" type="text" name="term" value="<?php echo $term; ?>">
							<button class="searchButton">
								<img src="assets/images/icons/search.png">
							</button>
						</div>

					</form>


				</div>



			</div>

			<div class="tabsContainer">
				<ul class="tabList">
					<li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
						<a href='<?php echo "search.php?term=$term&type=sites"; ?>'>Sites</a>
					</li>
					<li  class="<?php echo $type == 'images' ? 'active' : '' ?>">
						<a href='<?php echo "search.php?term=$term&type=images"; ?>'>Images</a>
					</li>
				</ul>	

			</div>

		</div>


		<div class="mainResultsSection">
			<?php  
				//echo $type;
				if ($type== "sites"){
				$resultsProvider = new SiteResultsProvider($con);
				$pageSize = 20;
				}
				else{
				$resultsProvider = new ImageResultsProvider($con);
				$pageSize = 30;

				}
				//echo $resultsProvider->getNumResults($term);
				$numResults = $resultsProvider->getNumResults($term);
				echo "<p class='resultsCount'>$numResults results found</p>";
				
				echo $resultsProvider->getresultsHtml($page,$pageSize,$term);

			?>
		</div>
		<div class="paginationContainer">

			<div class="pageButtons">



				<div class="pageNumberContainer">
					<img src="assets/images/pageStart.png">
				</div>

				<?php

				$pagesToShow = 10;
				$numPages = ceil($numResults / $pageSize);
				$pagesLeft = min($pagesToShow, $numPages);
				$currentPage = $page - floor(($pagesToShow / 2));

				if ($currentPage < 1) {
					$currentPage = 1;
				}

				if ($currentPage + $pagesLeft > $numPages) {
					$currentPage = $numPages  + 1 - $pagesLeft;
				}

				while($pagesLeft != 0 && $currentPage <= $numPages) {

					if ($currentPage == $page){
						echo "<div class='pageNumberContainer'>
								<img src='assets/images/pageSelected.png'>
								<span class='pageNumber'>$currentPage</span>
							</div>";

					}
					else {
					echo "<div class='pageNumberContainer'>
						<a href='search.php?term=$term&type=$type&page=$currentPage'>
							<img src='assets/images/page.png'>
							<span class='pageNumber'>$currentPage</span>
							</a>
						</div>";

					}

					$currentPage++;
					$pagesLeft--;

				}





				?>

				<div class="pageNumberContainer">
					<img src="assets/images/pageEnd.png">
				</div>



			</div>




		</div>


	</div>

	<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>	
<script type="text/javascript" src="assets/js/script.js"></script>

</body>
</html>