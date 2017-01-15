<?php
echo $this->view("layout/head.php", ["title" => $controller->title()]);
?>
<div id="body_wrapper">
	<?=$controller->body()?>
</div>
<?php
echo $this->view("layout/end.php");
