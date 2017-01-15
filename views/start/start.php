<h1><?=$app_name?></h1>

<table class="table table-striped">
	<thead>
		<tr>
			<th>domain</th>
			<th>ns</th>
		</tr>
	</thead>
	<tbody id="domainlist_tbody">
		<tr><td colspan="2">(waiting for data...)</td></tr>
	</tbody>
</table>

<h2>Add domain</h2>
<div id="add_domain_error"></div>
<form>
	<input type="text" id="add_domain_domain" required pattern=".+\..+" placeholder="example.com">
	<button type="submit" class="btn btn-primary" id="add_domain_btn">Add</button>
</form>
