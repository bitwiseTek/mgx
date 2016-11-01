$('document').ready(function(){


$('#buy_amount').keyup(function(e){

	e.preventDefault();
	var amount = parseInt($(this).val());
	var excahnge_rate = parseInt($('#buy_currency option:selected').attr('buy_value'));
	var amount_pay = amount * excahnge_rate;

	if(isNaN(amount))
	{
		$('#buy_message').html('');
	}
	else
	{
		var message = 'You will pay N'+amount_pay;
		$('#buy_message').html(message);
	}
	

});

$('#sell_amount').keyup(function(e){

	e.preventDefault();
	var amount = parseInt($(this).val());
	var excahnge_rate = parseInt($('#sell_currency option:selected').attr('sell_value'));
	var amount_pay = amount * excahnge_rate;

	if(isNaN(amount))
	{
		$('#sell_message').html('');
	}
	else
	{
		var message = 'You will receive N'+amount_pay;
		$('#sell_message').html(message);
	}

 });


 $.getJSON('/utility/currency-drop-down',{},function(data)
	{
		$.each(data,function(n,value){

			$('.currency_drop_down').append(
				'<option buy_value="'+value.buy_value+'" sell_value="'+value.sell_value+'" value="'+value.currency_name+'">'+value.currency_name+'</option>'
			 );
		}) 
	});


  $.getJSON('/utility/get-banks',{},function(data)
	{
		var user_bank_name = data.user_bank;

		$.each(data.banks,function(n,value){

			if(user_bank_name==value.bank_name)
			{
				$('.bank_names').append(
					'<option selected value="'+value.bank_name+'">'+value.bank_name+'</option>'
			 	 );
			}
			else
			{
				$('.bank_names').append(
					'<option value="'+value.bank_name+'">'+value.bank_name+'</option>'
			 	);
			}
		}) 
	});

	
});

