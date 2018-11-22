$(document).ready(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	    }
	});
	var tokenPiwik = $('meta[name="_tokenPiwik"]').attr('content');
	console.log(tokenPiwik);
	var formData ={
		module: 'API',
			method: 'VisitsSummary.getVisits',
			idSite: 1,
			period: 'day',
			date: 'today',
			format: 'JSON',
			token_auth: tokenPiwik,
	}
	var type = "get";
	var my_url = '/analytics/index.php';

	$.ajax({

		type:type,
		url:my_url,
		data:formData,

			success: function(data){
				console.log(data);
				var visitas = data.value;
				console.log(visitas);
				$('#VisitsSummary').text(visitas);
			},
			error: function(data){
				console.log(data);
			}
	});
});