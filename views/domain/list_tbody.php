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
			<td><?=$name?></td>
			<td><?php try { echo $domain->ns; } catch(AppException $e) { echo '(waiting for data)'; } ?></td>
		</tr>
		<?php
	}
}
