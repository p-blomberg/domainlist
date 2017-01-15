<?php
echo $this->view("layout/head.php", ["title" => $controller->title()]);
?>
<div class="container" role="main">
	<?=$controller->body()?>
</div>
<?php
echo $this->view("layout/end.php", ["scripts" => $controller->scripts()]);
