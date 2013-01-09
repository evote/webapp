//vote

$(document).ready(function(){
	$("a").click(function(){
		var param = $(this).attr('href').split("|");
		//console.log('{"type": "take_my_vote","vuid":'+param[0].replace("#","")+',"data":['+param[1]+','+param[2]+','+param[3]+','+param[4]+']}');
		if (param){
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "ballot.cgi?json",
				data: JSON.stringify({"type": "take_my_vote","vuid":param[0].replace("#",""),"data":[param[1],param[2],param[3],param[4]]}),
				//url: "test.php",
				//data: 'myData: postData',
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					  //$('div#loginResult').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					  //$('div#loginResult').attr('class',"error");
					  alert("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					  console.log("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
				},
				success: function(data){
					//alert(data);
					//if(data.error) {
					if(data.error!='OK'){
						console.log("error: " + data.vuid);
					}
					else {
						//$("body").text('Glos oddany');
						$("#content_full").html('Twoj glos zostal oddany poprawnie.');
						$("#content_full").append('<a href="list.php">Lista</a>');
						console.log("success: " + data.vuid);
					}
				}
			});
		}
		else
		{
			$('div#loginResult').text("enter voters and options").attr('class',"error");
		}
		$('div#loginResult').fadeIn();
		return false;
	});
});