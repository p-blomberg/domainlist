<h1><?=$app_name?></h1>

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
				<td><?=$d->ns()?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
