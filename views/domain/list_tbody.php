<?php
use \App\Helper\AppException;

if(empty($domains)) {
	?>
	<tr><td colspan="2">No domains are entered yet :(</td></tr>
	<?php
} else {
	foreach($domains as $name => $domain) {
		?>
		<tr>
			<td><?=htmlspecialchars($name)?></td>
			<td>
				<?php
				try {
					foreach($domain->ns as $ns) {
						echo $ns."<br>";
					}
				} catch(AppException $e) { echo '(waiting for data)'; }
				?>
			</td>
			<td>
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_domain_modal" data-domain="<?=htmlspecialchars($name)?>">Delete</button>
			</td>
		</tr>
		<?php
	}
}
