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
});
</script>
