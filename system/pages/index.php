<?php
global $_USER;
if($_GET["logout"] == "yes"){
	unset($_SESSION["login"]);
	unset($_USER);
}
if(!$_USER){?>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h1>Авторизация</h1>
		<?php
		$arParams = array(
				"template" => "form/MainFormChunk.php",
			);
		
		$authForm = new MainForm();
		$authForm->addField(new Field("login", "Ваш логин", "text", null, "not_empty"));
		$authForm->addField(new Field("pass", "Ваш пароль", "password", null, "not_empty"));
		$authForm->addButton(new Field("send", "Отправить", "submit", null));
		$authControl = new AuthFormController($arParams, $authForm, "/");
		?>
	</div>
	<div class="col-md-4"></div>
</div>
<?php } else {?>
	<div class="row">
		<div class="col-md-12">
			<h1>Мои RSS-ленты <small><a class="refresh" onclick="RefreshRss();return false;" href="#"><i class="glyphicon glyphicon-refresh"></i></a></small></h1>
		</div>
	</div>
	<?php
		if($_POST["date"] || $_POST["read"]){
			$_SESSION["sort"] = $_POST;
		}
		if($_POST["include_rss"]){
			$_SESSION["sort"]["include_rss"][$_POST["include_rss"]] = $_POST["include_rss"];
		}
		if($_POST["exclude_rss"]){
			unset($_SESSION["sort"]["include_rss"][$_POST["exclude_rss"]]);
		}

		$arParams = array();

		if($_SESSION["sort"]["include_rss"]){
			foreach ($_SESSION["sort"]["include_rss"] as $id) {
				$arParams["rss_id"][] = $id;
			}
		}

		$date_glif = "glyphicon glyphicon-sort-by-attributes-alt";
		$date_button = "btn btn-warning";
		$date_sort = "asc";
		$read_glif = "glyphicon glyphicon-sort-by-attributes-alt";
		$read_button = "btn btn-success";
		$read_sort = "asc";
		if($_SESSION["sort"]["date"] == "desc"){
			$date_glif = "glyphicon glyphicon-sort-by-attributes-alt";
			$date_button = "btn btn-warning";
			$read_button = "btn btn-success";
			$date_sort = "asc";
		}else if($_SESSION["sort"]["date"] == "asc"){
			$date_glif = "glyphicon glyphicon-sort-by-attributes";
			$date_button = "btn btn-warning";
			$read_button = "btn btn-success";
			$date_sort = "desc";
		}else if($_SESSION["sort"]["read"] == "desc"){
			$read_glif = "glyphicon glyphicon-sort-by-attributes-alt";
			$read_button = "btn btn-warning";
			$date_button = "btn btn-success";
			$read_sort = "asc";
		}else if($_SESSION["sort"]["read"] == "asc"){
			$read_glif = "glyphicon glyphicon-sort-by-attributes";
			$read_button = "btn btn-warning";
			$date_button = "btn btn-success";
			$read_sort = "desc";
		}
	?>



	<div class="row filter">
		<div class="col-md-12">
			<div class="alert alert-warning" role="alert">
				<form id="filter" class="col-md-12 filter-main" action="" method="post">
					<div class="form-line filter-span-wrap col-md-2">
						<span class="form-line filter-span">Сортировать:</span> 
					</div>
					<div class="form-line col-md-2">
						<button type="submit" name="date" value="<?php echo $date_sort?>" onclick="SortDate('<?php echo $date_sort?>');return false;" class="date-f <?php echo $date_button?>"><span>Дате <i class="<?php echo $date_glif?>"></i></span></button>
					</div>
					<div class="form-line col-md-2">
						<button type="submit" name="read" value="<?php echo $read_sort?>" onclick="SortRead('<?php echo $date_sort?>');return false;" class="read-f <?php echo $read_button?>">Прочтению <i class="<?php echo $read_glif?>"></i></button>
					</div>
					<div class="form-line col-md-3">
						
					</div>
					<div class="form-line col-md-3">
						<button type="submit" name="readen-all" value="<?php echo $_USER->getProperty("id")?>" onclick="ReadAllRss('<?php echo $_USER->getProperty("id")?>');return false;" class="btn btn-primary">Отметить все как прочитанное</button>
					</div>
				</form>
				<div col="col-md-6"></div>
			</div>
			<div class="alert alert-warning" role="alert">
				<div class="form-line col-md-3">
					<?php
						$rss_controller = new RssController($_USER->getProperty("id"), "rss/RssSelectFilterChunk.php");
						if($rss_controller){
							$rss_controller->PrintRssList();
						}
					?>
				</div>
				<div class="col-md-9 rss-points-wrap">					
					<?php
						if($arParams){
							$arFilter["id"] = $arParams["rss_id"];
							$rss_controller = new RssController($_USER->getProperty("id"), "rss/RssFilterChunk.php", $arFilter);
							if($rss_controller){
								$rss_controller->PrintRssList();
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php if($_POST["refresh"] == 1){
		$rss_controller = new RssController($_USER->getProperty("id"));
		$rss_controller->updateRss();
	}

	if($_SESSION["sort"]["date"]){
		$arSort["date"] = $_SESSION["sort"]["date"];
	}
	if($_SESSION["sort"]["read"]){
		$arSort["is_readen"] = $_SESSION["sort"]["read"];
		$arSort["date"] = "desc";
	}

	if(empty($arSort)){
		$arSort["date"] = "desc";		
	}
?>
<div class="row rss-items-wrap">
<?php
	$rss_item_controller = new RssItemsController($_USER->getProperty("id"),"rss/RssListChunk.php", $arParams);
	$rss_item_controller->printRssItems($arSort);
	$paginator_controller = new PaginatorController($rss_item_controller->getProperty("paginator"), "paginator/PaginatorChunk.php");
	$paginator_controller->printPaginator();
}?>
</div>