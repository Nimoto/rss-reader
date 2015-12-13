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
		$authControl = new AuthFormController($arParams, $authForm, "/personal/");
		?>
	</div>
	<div class="col-md-4"></div>
</div>
<?php } else {?>
	<div class="row">
		<div class="col-md-12">
			<h1>Мои RSS-ленты <small><a href="?refresh=1"><i class="glyphicon glyphicon-refresh"></i></a></small></h1>
		</div>
	</div>
	<?php
		if($_POST["date"] || $_POST["read"]){
			$_SESSION["sort"] = $_POST;
		}
		if($_POST["exclude_rss"]){
			$_SESSION["sort"]["exclude_rss"][$_POST["exclude_rss"]] = $_POST["exclude_rss"];
		}
		if($_POST["include_rss"]){
			unset($_SESSION["sort"]["exclude_rss"][$_POST["include_rss"]]);
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
				<form id="filter" class="col-md-6" action="" method="post">
					<div class="form-line col-md-3">
						<span>Сортировать:</span> 
					</div>
					<div class="form-line col-md-4">
						<button type="submit" name="date" value="<?php echo $date_sort?>" onclick="SortDate('<?php echo $date_sort?>');return false;" class="date-f <?php echo $date_button?>"><span>Дате <i class="<?php echo $date_glif?>"></i></span></button>
					</div>
					<div class="form-line col-md-4">
						<button type="submit" name="read" value="<?php echo $read_sort?>" onclick="SortRead('<?php echo $date_sort?>');return false;" class="read-f <?php echo $read_button?>">Прочтению <i class="<?php echo $read_glif?>"></i></button>
					</div>
				</form>
				<div col="col-md-6"></div>
			</div>
			<div class="alert alert-warning" role="alert">
				<div class="col-md-12">
					<?php
						$rss_controller = new RssController($_USER->getProperty("id"), "rss/RssFilterChunk.php");
						if($rss_controller){
							$rss_controller->PrintRssList();
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php if($_GET["refresh"] == 1){
		$rss_controller = new RssController($_USER->getProperty("id"));
		$rss_controller->updateRss();
	}
	$arSort["sort"] = "date";
	$arSort["by"] = "desc";
	if($_SESSION["sort"]["date"]){
		$arSort["sort"] = "date";
		$arSort["by"] = $_SESSION["sort"]["date"];		
	}
	if($_SESSION["sort"]["read"]){
		$arSort["sort"] = "is_readen";
		$arSort["by"] = $_SESSION["sort"]["read"];		
	}
	$arParams = array();

	if($_SESSION["sort"]["exclude_rss"]){
		foreach ($_SESSION["sort"]["exclude_rss"] as $id) {
			$arParams["!rss_id"][] = $id;
		}
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