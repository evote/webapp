//JavaScript
//Generate Vote
var vuid;

$(document).ready(function(){
	$("button#generateVoteB").click(function(){
		var voters = $('#voters').val();
		var options = $('#options').attr('value');
		
		if (voters && options){
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "ballot.cgi?json",
				data: '{"type": "prepare_voting","data":['+voters+','+options+']}',
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					  $('span#infoStep').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					  $('span#infoStep').parent().attr('class',"error");
				},
				success: function(data){
					if(data.error!='OK'){
						$('span#infoStep').text("data.error: " + data.error);
						$('span#infoStep').parent().attr('class',"error");
					}
					else {
						$('#p').attr('value',data.data[0]);
						$('#g').attr('value',data.data[1]);
						$('#vuid').attr('value',data.vuid);
						vuid = data.vuid;
						$('span#infoStep').text("Voting is prepared.");
						$('span#infoStep').parent().attr('class',"success");
						$('li#step1').attr('class','');
						$('li#step2').attr('class','active');
						$('#content1').attr('style','display:none;');
						$('#content2').attr('style','');
					}
				}
			});
		}
		else
		{
			$('span#infoStep').text("Please enter first Vouter quantity and Options quantity");
			$('span#infoStep').parent().attr('class',"error");
		}
		$('span#infoStep').fadeIn();
		return false;
	});
	
	$('button#saveVote').click(function(){
		var voters = $('#voters').val();
		var options = $('#options').attr('value');
		var p = $('#p').val();
		var g = $('#g').val();
		var vuid = $('#vuid').val();
		var name = $('#name').val();
		
		$('#info_n').text(name);
		$('#info_v').text(voters);
		$('#info_o').text(options);
		$('#info_p').text(p);
		$('#info_g').text(g);
		$('#info_VUID').text(vuid);
		
		var postData = 
			{
				"name":name,
				"voters":voters,
				"options":options,
				"p":p,
				"g":g,
				"vuid":vuid
			}
		 
		if(p && g && vuid){
			$.ajax({
				type: "POST",
				url:'functions.php',
				dataType: "json",
				data: {saveVote: JSON.stringify(postData)},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					$('span#infoStep').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					$('span#infoStep').parent().attr('class',"error");
				},
				success: function(data){
					$('span#infoStep').text('Voting is save correctly.');
					$('span#infoStep').parent().attr('class',"success");
					$('li#step2').attr('class','');
					$('li#step3').attr('class','active');
					$('#content2').attr('style','display:none;');
					$('#content3').attr('style','');
					
				}
			});
		}
		else
		{
			$('span#infoStep').text("Something turn wrong. Please try create voting again later.");
			$('span#infoStep').parent().attr('class',"error");
		}
		$('span#infoStep').fadeIn();
		return false;
		
	});
	
	
	
	$('button#generateOptions').click(function(){
		var options_list = $('#options_list').attr('value');
		$('#info_options').html(options_list);
		var postData = 
			{
				"options_list":options_list
			}
		if(options_list){
			$.ajax({
				type: "POST",
				url:'functions.php',
				dataType: "json",
				data: {saveOptions: JSON.stringify(postData)},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					$('span#infoStep').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					$('span#infoStep').parent().attr('class',"error");
				},
				success: function(data){
					$('span#infoStep').text("Options are saved correctly.");
					$('span#infoStep').parent().attr('class',"success");
					$('li#step3').attr('class','');
					$('li#step4').attr('class','active');
					$('#content3').attr('style','display:none;');
					$('#content4').attr('style','');
				}
			});
		}
		else
		{
			$('span#infoStep').text("Please enter options");
			$('span#infoStep').parent().attr('class',"error");
		}
		$('span#infoStep').fadeIn();
		return false;
		
	});
	
	$('button#saveEmail').click(function(){
		var email_list = $('#emails_list').attr('value');
		var postData = 
			{
				"email_list":email_list
			}
		if(email_list){
			$.ajax({
				type: "POST",
				url:'functions.php',
				dataType: "json",
				data: {saveEmail: JSON.stringify(postData)},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					$('span#infoStep').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					$('span#infoStep').parent().attr('class',"error");
				},
				success: function(data){
					$('span#infoStep').text("E-mail are saved correctly");
					$('span#infoStep').parent().attr('class',"success");
					$('li#step5').attr('class','');
					$('li#finish').attr('class','active');
					$('#content5').attr('style','display:none;');
					$('#content6').attr('style','');
				}
			});
		}
		else
		{
			$('span#infoStep').text("Please enter email");
			$('span#infoStep').parent().attr('class',"error");
		}
		$('span#infoStep').fadeIn();
		return false;
		
	});
	
	
	$('button#generateCards').click(function(){
		var voters = $('#voters').val();
		var options = $('#options').attr('value');
		var p = $('#p').val();
		var g = $('#g').val();
		var postData = 
			{
				"voters":voters,
				"options":options,
				"p":p,
				"g":g
			}
		if(options_list){
			$.ajax({
				type: "POST",
				url:'generator.cgi?json',
				dataType: "json",
				data: JSON.stringify({"type": "generate_votes","data":[voters,options,p,g]}),
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					$('span#infoStep').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					$('span#infoStep').parent().attr('class',"error");
				},
				success: function(data){
					saveCards(data.data);
					$('span#infoStep').text('Cards are saved correctly.');
					$('span#infoStep').parent().attr('class',"success");
					$('li#step4').attr('class','');
					$('li#step5').attr('class','active');
					$('#content4').attr('style','display:none;');
					$('#content5').attr('style','');
				}
			});
		}
		else
		{
			$('span#infoStep').text("");
			$('span#infoStep').parent().attr('class',"error");
		}
		$('span#infoStep').fadeIn();
		return false;
		
	});
	
	$('a#stopVoting').click(function(){
		var param=$(this).attr('href').replace("#","");
		console.log(param);
		if(param)
		{
			$.ajax({
				type: 'POST',
				url: 'ballot.cgi?json',
				dataType: 'json',
				data: JSON.stringify({"type": "stop_voting","vuid" :param}),
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					$('span#infoNav').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					$('span#infoNav').parent().attr('class',"error");
				},
				success: function(data){
					console.log(data);
					$('span#infoNav').text('Voting stop correct');
					$('span#infoNav').parent().attr('class',"success");
					$.ajax({
						type: 'POST',
						url: 'functions.php',
						dataType: 'json',
						data: {updateResult: JSON.stringify(data)},
						error: function(XMLHttpRequest, textStatus, errorThrown) { 
							$('span#infoNav').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
							$('span#infoNav').parent().attr('class',"error");
						},
						success: function(data){
							location.reload();
						}
					});
				}
			});
		}
		else{
			console.log(param);
		}
	});
});

function saveCards(data)
{
	console.log(vuid);
	$.ajax({
		type: "POST",
		url:'functions.php',
		dataType: "json",
		data: {saveCards:JSON.stringify(data)},
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			$('span#infoStep').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
			$('span#infoStep').parent().attr('class',"error");
		},
		success: function(dataR){
			$('span#infoStep').text();
			$('span#infoStep').parent().attr('class',"success");
			console.log(dataR);
			$.ajax({
				type: "POST",
				url:'ballot.cgi?json',
				dataType: "json",
				data: JSON.stringify({"type": "start_voting","vuid":vuid,"data":dataR}),
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					$('span#infoStep').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					$('span#infoStep').parent().attr('class',"error");
				},
				success: function(data){
					$('span#infoStep').text('Cards correctly save.');
					$('span#infoStep').parent().attr('class',"success");
					console.log(data);
				}
			});
		}
	});
	return false;
}