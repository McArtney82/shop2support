jQuery(document).ready(function($) {
	$('#the-list > tr').each(function () {
		var thisrow = jQuery(this)
		var link = jQuery(this).children('td.link').children('a').html()
		var id = jQuery(this).children('td.ID').children('a').html()
		var status =  jQuery(this).children('td.status').children('.status-span').data('status')
		if (link && status === "loading"){
			$.ajax({
				type:'post',
				url:myAjax.ajaxurl,
				dataType : "json",
				data:{
					"action":"get_s2slink_status",
					"id": id,
					"link": link
				},
				success:function(data){
					if(data === '404' || data === '503' || data==='400' || data==='403'){
						thisrow.children('td.status').html('<span style="color:orangered">Failed</span>')
					} else if(data === '200') {
						thisrow.children('td.status').html('<span style="color:green">Passed</span>')
					} else {
						thisrow.children('td.status').html('<span style="color:orange">Check ' + data + '</span>')
					}

				}
			})
		} else {
			if(!link){
				thisrow.children('td.status').html('<span style="color:orangered">Failed</span>')
			}
		}
	})
	$('#s2s-csv-btn').on('click',function(e){
		$(this).prop('disabled', true)
		e.preventDefault();
		$('.csv-loading').addClass('is-active')
		$.ajax({
			type:'post',
			url:myAjax.ajaxurl,
			dataType : "json",
			data:{
				"action":"s2s_export_csv",
				"exportType":$('#csv-type').val()
			},
			success:function(data){
				$('.csv-loading').removeClass('is-active')
				$(this).prop('disabled', false)
				console.log(data)
			}
		})
	})
})
