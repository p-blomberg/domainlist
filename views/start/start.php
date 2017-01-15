<?php
use \App\Helper\AppException;
?>
<h1><?=$app_name?></h1>

<?php
if(empty($domains)) {
	?>
	<p>No domains are entered yet :(</p>
	<?php
} else {
	?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>domain</th>
				<th>ns</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($domains as $name => $domain) {
				?>
				<tr>
					<td><?=$name?></td>
					<td><?php try { echo $domain->ns; } catch(AppException $e) { echo '(waiting for data)'; } ?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<?php
}
?>

<h2>Add domain</h2>
<div id="add_domain_error"></div>
<form>
	<input type="text" id="add_domain_domain" required pattern=".+\..+" placeholder="example.com">
	<button type="submit" class="btn btn-primary" id="add_domain_btn">Add</button>
</form>
