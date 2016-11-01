<?php

class userController extends Controller {

	//Summary View
	public function summary()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$user_id = Session::get('user_id');
				$data = UserModel::getSummaryData($user_id);
				return View::make('user.summary')->with(array('data'=>$data));	
			}
			App::abort(403);
		}
		return Redirect::guest('/login');
	}

	//Buy Sell View
	public function buySellView()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$data = UserModel::getCurrencies();
				return View::make('user.buysell')->with(array('data'=>$data));	
			}
			App::abort(403);
		}
		return Redirect::guest('/login');
	}

	//BUY Review
	public function buyReview()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$validator = UserModel::validateBuy();

				 if($validator->fails()){
						Session::flash('buy_message','Something went wrong, please correct your inputs.');
						return Redirect::to('/users/exchange-currencies')->withErrors($validator)->withInput();
					} else {
                                                $data = UserModel::buy();
						$data = UserModel::buyReview($data);
						return View::make('user.buyreview')->with(array('data'=>$data));
					}
			}
			App::abort(403);
		}
		return Redirect::guest('/login');
	}

       //BUY Online Review
	public function buyOnlineReview()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$validator = UserModel::validateBuy();

				 if($validator->fails()){
					Session::flash('buy_message','Something went wrong, please correct your inputs.');
					return Redirect::to('/users/exchange-currencies')->withErrors($validator)->withInput();
				 } else {
                                     //get details for display
			             return View::make('user.buyOnlineReview')->with(array('data'=>$data));
				}
			}
			App::abort(403);
		}
		return Redirect::guest('/login');
	}

        //BUY Bank Review
	public function buyBankReview()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$validator = UserModel::validateBuy();

				 if($validator->fails()){
					Session::flash('buy_message','Something went wrong, please correct your inputs.');
					return Redirect::to('/users/exchange-currencies')->withErrors($validator)->withInput();
				 } else {
                                     //get details for display
			             return View::make('user.buyBankReview')->with(array('data'=>$data));
				}
			}
			App::abort(403);
		}
		return Redirect::guest('/login');
	}

	//Process SELL
	public function sell()
	{
		if(Session::get('user_id')) {
			if(Session::get('account_type')=='user') {
				$validator = UserModel::validateSell();
				 if($validator->fails()){
						Session::flash('sell_message','Something went wrong, please correct your inputs.');
						return Redirect::to('/users/exchange-currencies')->withErrors($validator)->withInput();
					} else {
		                           UserModel::sell();
					   Session::flash('message','Transaction was successful.');
					   return Redirect::to('/users/transactions');
					}
			}
			App::abort(403);
		}
		return Redirect::guest('/login');
	}

        //Sell Review
	public function sellReview()
	{
		if(Session::get('user_id')) {
			if(Session::get('account_type')=='user') {
				$validator = UserModel::validateSell();
				 if($validator->fails()) {
					Session::flash('sell_message','Something went wrong, please correct your inputs.');
					return Redirect::to('/users/exchange-currencies')->withErrors($validator)->withInput();
				} else {
		                      $data = UserModel::getSellDetails();
				      return View::make('user.sellReview')->with('data', $data);
				}
			}
			App::abort(403);
		}
		return Redirect::guest('/login');
	}

        public function paymentSummary()
	{
		if (Session::get('user_id')) {
                     if (Input::get('txnref')) {
                       $user_id = Session::get('user_id');
                       $ref_no = Input::get('txnref');
                       $event = Input::get('desc');
                        
                        if ($event) {
                              //payment cancelled.
                              $details = UserModel::updatePayment($user_id, $ref_no, 'Failed', $event, 'Online (InterSwitch)', null, Input::get('resp'));
		  	      return View::make('user.paymentFailed')->with('data', $details);
                        } else {
                           
                           $details = UserModel::getPaymentDetails($user_id, $ref_no);

                       if (!is_null($details)) {
                         $product_id = '6218';
                         $mac_key = '642AD5855E9E3CA9C8D83BCBD73944BBC9F20FA75D02C0FF04F4A6A99A191CF36249A5C414D85ACDBB173C7DAFB993F70E778373FBE130D9132EBE43B91BF676';
                         $hash = hash('sha512', $product_id.$ref_no.$mac_key);
                         $amount = $details->exchange_val * 100; //covert to kobo
                         $url = 'https://webpay.interswitchng.com/paydirect/api/v1/gettransaction.json?productid='.$product_id.'&transactionreference='.$ref_no.'&amount='.$amount;                           

                         $curl = curl_init();
                         curl_setopt($curl, CURLOPT_HTTPHEADER, array('Hash:'.$hash));      
                         curl_setopt ($curl, CURLOPT_URL, $url);  
                         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
                         $request = curl_exec ($curl);  
                         $request = json_decode($request, true);


                          if ($request['ResponseCode'] == "00") {
                                 $details = UserModel::updatePayment($user_id, $ref_no, 'Paid', $request['ResponseDescription'], 'Online (InterSwitch)', $request['PaymentReference'], $request['ResponseCode']);
				 Mail::send('emails.paymentSuccessful', $details, function($message) use ($details)
				 	{
				 	  $message->from('info@maplexchange.com', 'Maple Gold Exchange');
				 	  $message->to($details['email'], $details['last_name'].' '.$details['first_name'])->subject('Transaction Successful');
				 	});			
				 return View::make('user.paymentSuccess')->with('data', $details);

                           } else {
                                 //payment failed.
                                 $details = UserModel::updatePayment($user_id, $ref_no, 'Failed', $request['ResponseDescription'], 'Online (InterSwitch)', $request['PaymentReference'], $request['ResponseCode']);
				 return View::make('user.paymentFailed')->with('data', $details);
                           }
                       } else {
                            //fraud - payment does not exist
		            return View::make('user.paymentFailed')->with('data', ['event'=>'Fraudulent transaction']);
                       }
                    }
} else {		return Redirect::to('/users/summary');
}
		} else {
		   App::abort(403);
		}
	}

	//Transactions
	public function transactions()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$user_id = Session::get('user_id');
				$data = UserModel::getTransactions($user_id);
				return View::make('user.transactions')->with('data',$data);
			}
			App::abort(403);
		}
		return Redirect::guest('/login');
	}

	//Transaction View
	public function viewTransaction($transaction_id)
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$user_id = Session::get('user_id');
				$data = UserModel::getTransaction($user_id, $transaction_id);
				return View::make('user.transactionView')->with('data',$data);
			}
			App::abort(403);
		}
		return Redirect::guest('/login');
	}

	//Settings View
	public function userSettingsView()
	{

		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$user_id = Session::get('user_id');
		 		$data = UserModel::getUserData($user_id);
		 		return View::make('user.settings')->with('data',$data);
		 	}
			App::abort(403);
		}
		App::abort(403);
	}


	//Edit Users informations 
	public function editInfo()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$user_id = Session::get('user_id');
				$validator = UserModel::validateInfo();

				if($validator->passes())
				{
					UserModel::editUserInfo($user_id);
					Session::flash('editInfo_message','Changes were successful.');
					return Redirect::to('/users/settings');
				}
				else
				{
	             	Session::flash('editInfo_message','Something went wrong, please correct your inputs.');
					return Redirect::to('/users/settings')->withErrors($validator)->withInput();   
				}
			}
			App::abort(403);
		}
		App::abort(403);
	}

	//Edit Password
	public function editPassword()
	{
		if(Session::get('user_id') )
		{
			if(Session::get('account_type')=='user')
				{
					$user_id = Session::get('user_id');
					$validator = UserModel::validatePassword();

				 	if($validator->passes())
					{
						$state = UserModel::editPassword($user_id);
						if($state)
						{
							Session::flash('editPassword_message','Changes were successful.');	
							return Redirect::to('/users/settings');						
						}
						else
						{
							Session::flash('editPassword_message','Ops, The old password provided is wrong.');
							return Redirect::to('/users/settings');
						}
						
					}
					else
					{
		             	Session::flash('editPassword_message','Something went wrong, please correct your inputs.');
						return Redirect::to('/users/settings')->withErrors($validator)->withInput();   
					}
				}
				App::abort(403);
 		}
 		App::abort(403);
 	}


 	//Edit editECurrencies
	public function editECurrencies()
	{
		if(Session::get('user_id') )
		{
			if(Session::get('account_type')=='user')
				{
					$user_id = Session::get('user_id');
					$validator = UserModel::validateECurrencies();

				 	if($validator->passes())
					{
						UserModel::editECurrencies($user_id);
						Session::flash('editEwallets_message','Changes were successful.');
						return Redirect::to('/users/settings');
					}
					else
					{
		             	Session::flash('editEwallets_message','Something went wrong, please correct your inputs.');
						return Redirect::to('/users/settings')->withErrors($validator)->withInput();   
					}

				}
				App::abort(403);
 		}
 		App::abort(403);
 	}


 	//Edit Bank Details
	public function editBankDetails()
	{
		if(Session::get('user_id') )
		{
			if(Session::get('account_type')=='user')
				{
					$user_id = Session::get('user_id');
					$validator = UserModel::validateBankDetails();

				 	if($validator->passes())
					{
						UserModel::editBankDetails($user_id);
						Session::flash('editBank_message','Changes were successful.');
						return Redirect::to('/users/settings');
					}
					else
					{
		             	Session::flash('editBank_message','Something went wrong, please correct your inputs.');
						return Redirect::to('/users/settings')->withErrors($validator)->withInput();   
					}

				}
				App::abort(403);
 		}
 		App::abort(403);
 	}

}
