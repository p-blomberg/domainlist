<script>
$(function() {
	$('#add_domain_btn').click(function(event) {
		console.info('add '+$('#add_domain_domain').val());
		event.preventDefault();
		$('#add_domain_error').html('');
		$(this).button('loading');
		$.post(
			'/domain/add',
			{ "name": $('#add_domain_domain').val() },
			function(data) {
				console.info(data);
				if(data.result == "ok") {
					$('#add_domain_domain').val('');
					reload_list();
				} else {
					console.warn('Bad response: ');
					console.warn(data);
					$('#add_domain_error').html('<div class="alert alert-danger">Request failed: '+data.error+'</div>');
				}
			},
			"json")
			.fail(function(jqXHR) {
				console.warn('POST failed: '+jqXHR.status+' '+jqXHR.statusText);
				$('#add_domain_error').html('<div class="alert alert-danger">Request failed, try again</div>');
			})
			.always(function() {
				$('#add_domain_btn').button('reset');
			});
	});
	$('#add_domain_domain').keypress(function(event) {
		$('#add_domain_error').html('');
	});
	$('#delete_domain_modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var recipient = button.data('domain') // Extract info from data-* attributes
		var modal = $(this)
		modal.find('#delete_domain_modal_domain_name').html(recipient)
		$('#delete_domain_modal_confirm').data('domain', recipient);
	})
	$('#delete_domain_modal_confirm').click(function(event) {
		console.info('delete '+$(this).data('domain'));
		$('#delete_domain_error').html('');
		$(this).button('loading');
		$.post(
			'/domain/delete',
			{ "name": $(this).data('domain') },
			function(data) {
				console.info(data);
				if(data.result == "ok") {
					$('#delete_domain_modal').modal('hide');
					reload_list();
				} else {
					console.warn('Bad response: ');
					console.warn(data);
					$('#delete_domain_error').html('<div class="alert alert-danger">Request failed: '+data.error+'</div>');
				}
			},
			"json")
			.fail(function(jqXHR) {
				console.warn('POST failed: '+jqXHR.status+' '+jqXHR.statusText);
				$('#delete_domain_error').html('<div class="alert alert-danger">Request failed, try again</div>');
			})
			.always(function() {
				$('#delete_domain_modal_confirm').button('reset');
			});
	});

	function reload_list() {
		$('#domainlist_tbody').load('/domain/list_tbody');
	}
	reload_list();
});
</script>
