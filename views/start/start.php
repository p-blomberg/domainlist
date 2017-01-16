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

<div class="modal fade" id="delete_domain_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				Do you want to delete the domain "<span id="delete_domain_modal_domain_name"></span>"?
				<div id="delete_domain_error"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-primary" id="delete_domain_modal_confirm">Yes</button>
			</div>
		</div>
	</div>
</div>
