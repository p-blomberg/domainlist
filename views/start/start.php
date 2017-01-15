<h1><?=$app_name?></h1>

<?php
if(empty($domains)) {
	?>
	<p>No domains are entered yet :(</p>
	<?php
} else {
	?>
	<table>
		<thead>
			<tr>
				<th>domain</th>
				<th>ns</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($domains as $d) {
				?>
				<tr>
					<td><?=$d?></td>
					<td><?=$d->ns?></td>
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
