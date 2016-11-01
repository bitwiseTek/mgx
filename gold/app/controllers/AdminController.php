<?php

class adminController extends Controller {

	//Summary
	public static function summary()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type') == 'admin')
			{
				$data = AdminModel::getSummaryData();
				return View::make('admin.summary')->with('data',$data);
			}
			App::abort(403);
		}
		App::abort(403);
	}

	//Transactions
	public static function transactions()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type') == 'admin' )
			{
				$data = AdminModel::getTransactions();
				return View::make('admin.transactions')->with('data',$data);
			}
			App::abort(403);
		}
		App::abort(403);
	}

	//View Transaction
	public static function viewTransaction($id)
	{
		if(Session::get('user_id'))
		{
			
			if( Session::get('account_type') == 'admin' )
			{
				$data = AdminModel::getTransaction($id);
				return View::make('admin.viewTransaction')->with('data',$data);
			}
			App::abort(403);
		}
		App::abort(403);
	}

        public static function queryInterSwitch($id)
    {
        if (Session::get('user_id')) {
            if ( Session::get('account_type') == 'admin' ) {
                $data = AdminModel::getPendingTransaction($id);
        
                if (!is_null($data)) {
                    $product_id = '6218';
                    $mac_key ='642AD5855E9E3CA9C8D83BCBD73944BBC9F20FA75D02C0FF04F4A6A99A191CF36249A5C414D85ACDBB173C7DAFB993F70E778373FBE130D9132EBE43B91BF676';
                    $hash = hash('sha512', $product_id.$data->ref_no.$mac_key);
                    $amount = $data->exchange_val * 100; //covert to kobo
                    $url = 'https://webpay.interswitchng.com/paydirect/api/v1/gettransaction.json?productid='.$product_id.'&transactionreference='.$data->ref_no.'&amount='.$amount;
                    
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Hash:'.$hash));
                    curl_setopt ($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    $request = curl_exec($curl);
                    
                    //dd($request);
                    $request = json_decode($request, true);
                    
                    if (!is_null($request)) {
                        if ($request['ResponseCode'] == "00") {
                            $details = AdminModel::updatePayment($id, 'Paid', $request['ResponseDescription'], $request['PaymentReference'], $request['ResponseCode']);
                            Mail::send('emails.paymentSuccessful', $details, function($message) use ($details)
                            {
                            $message->from('info@maplexchange.com', 'Maple Gold Exchange');
                            $message->to($details['email'], $details['last_name'].' '.$details['first_name'])->subject('Transaction Successful');
                            });
                        } else {
                            //payment failed.
                            AdminModel::updatePayment($id, 'Failed', $request['ResponseDescription'], $request['PaymentReference'], $request['ResponseCode']);
                        }
                    }
                    return Redirect::to('/admin/transactions');
                }
                return Redirect::to('/admin/transactions');
            }
            App::abort(403);
        }
        App::abort(403);
    }

	//Process Transaction
	public static function processTransaction()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type') == 'admin')
			{
                                $status = Input::get('transaction_status');
                                $id = Input::get('transaction_id');
                                $statement = Input::get('statement');
				$data = AdminModel::updateTransactionStatus($id, $status, $statement);

				if ($data) {
					Session::flash('success_message','User Status changed!');
					return Redirect::to('/admin/transactions');
				} else {
					Session::flash('failed_message','User Status could not be changed!');
					return Redirect::to('/admin/transactions/'.$id);
				}
			}
			App::abort(403);
		}
		App::abort(403);
	}

	//Users
	public static function users()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type') == 'admin' )
			{
				$data = AdminModel::getUsers();
				return View::make('admin.users')->with('data',$data);
			}
			App::abort(403);
		}
		App::abort(403);
	}

	//View User
	public static function viewUser($id)
	{
		if(Session::get('user_id'))
		{
			
			if( Session::get('account_type') == 'admin' )
			{
				$data = AdminModel::viewUser($id);
				return View::make('admin.viewUser')->with('data',$data);
			}
			App::abort(403);
		}
		App::abort(403);
	}

	public static function changeUserStatus($user_id)
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin') {
				$status = Input::get('status');
				$data = AdminModel::changeUserStatus($user_id, $status);

				if ($data) {
					Session::flash('user_success_message','User Status changed!');
					return Redirect::to('/admin/users');
				} else {
					Session::flash('user_failed_message','User Status could not be changed!');
					return Redirect::to('/admin/users/'.$user_id);
				}
			}
			App::abort(403);
		}
		App::abort(403);
	}
	
	//Reports Veiw
	public static function reports()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type') == 'admin')
			{
				return  View::make('admin.reports');
			}
			App::abort(403);
		}
		App::abort(403);

	}

	//Reports 
	public static function getReports()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type') == 'admin' )
			{
				$data = AdminModel::getReports();
				return $data;
			}
			App:abort(403);
		}
		App::abort(403);
	}

	//Config View
	public static function getCurrencies()
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
				$data = AdminModel::getCurrencies();
				return View::make('admin.currencies')->with(['data' => $data['currencies'], 'bank_data' => $data['banks']]);
			}
			App::abort(403);
		}
		App::abort(403);
	}

	//Config Update
	public static function editCurrency($currency_id)
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
				$inputs = Input::all();
				$data = AdminModel::editCurrency($currency_id, $inputs);

				if ($data) {
					Session::flash('currency_success_message','Currency updated!');
					return Redirect::to('/admin/currencies');
				} else {
					Session::flash('currency_failed_message','Currency could not be updated!');
					return Redirect::to('/admin/currencies');
				}
			}
			App::abort(403);
		}
		App::abort(403);
	}

	//Config Update
	public static function deleteCurrency($currency_id)
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
				$data = AdminModel::deleteCurrency($currency_id);

				if ($data) {
					Session::flash('currency_success_message','Currency deleted!');
					return Redirect::to('/admin/currencies');
				} else {
					Session::flash('currency_failed_message','Currency could not be deleted!');
					return Redirect::to('/admin/currencies');
				}
			}
			App::abort(403);
		}
		App::abort(403);
	}

	public static function addCurrency()
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
				$inputs = Input::all();
				$data = AdminModel::addCurrency($inputs);

				if ($data) {
					Session::flash('currency_success_message','Currency Added!');
					return Redirect::to('/admin/currencies');
				} else {
					Session::flash('currency_failed_message','Currency could not be added!');
					return Redirect::to('/admin/currencies');
				}
			}
			App::abort(403);
		}
		App::abort(403);
	}

        public static function addCurrencyView()
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
				return View::make('admin.addCurrency');
			}
			App::abort(403);
		}
		App::abort(403);
	}

	public static function viewCurrency($currency_id)
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
				$data = AdminModel::getCurrency($currency_id);
				return View::make('admin.viewCurrency')->with('data', $data);
			}
			App::abort(403);
		}
		App::abort(403);
	}

        public static function deleteBank($bank_id)
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
				$data = AdminModel::deleteBank($bank_id);

                                if($data) {
                           	  Session::flash('bank_message','Bank deleted!');
                                } else {
				  Session::flash('bank_message','Bank could not be deleted!');
                                }
				return Redirect::to('/admin/currencies');
			}
			App::abort(403);
		}
		App::abort(403);
	}

        public static function editBank($bank_id)
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
                                $inputs = Input::all();
				$data = AdminModel::editBank($bank_id, $inputs);

                                if($data) {
                           	  Session::flash('bank_message','Bank edited!');
                                } else {
				  Session::flash('bank_message','Bank could not be edited!');
                                }
				return Redirect::to('/admin/currencies');
			}
			App::abort(403);
		}
		App::abort(403);
	}

        public static function addBank()
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
                                $inputs = Input::all();
				$data = AdminModel::addBank($inputs);

                                if($data) {
                           	  Session::flash('bank_message','Bank added!');
                                } else {
				  Session::flash('bank_message','Bank could not be added!');
                                }
				return Redirect::to('/admin/currencies');
			}
			App::abort(403);
		}
		App::abort(403);
	}

        public static function addBankView()
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
                         return View::make('admin.addBank');
			}
			App::abort(403);
		}
		App::abort(403);
	}

        public static function editBankView($bank_id)
	{
		if (Session::get('user_id')) {
			if (Session::get('account_type') == 'admin' ) {
                          $data = AdminModel::getBankDetails($bank_id);
                          return View::make('admin.editBank')->with('data',$data);
			}
			App::abort(403);
		}
		App::abort(403);
	}

	//Settings View
	public static function settings()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type') == 'admin' )
			{
				$user_id = Session::get('user_id');
		 		$data = UserModel::getUserData($user_id);
				return View::make('admin.settings')->with('data',$data);
			}
			App::abort(403);
		}
		App::abort(403);
	}


	//Edit informations 
	public function editInfo()
	{
		if(Session::get('user_id'))
		{
			if(Session::get('account_type')=='user')
			{
				$user_id = Session::get('user_id');
				$validator = AdminModel::validateInfo();

				if($validator->passes())
				{
					AdminModel::editUserInfo($user_id);
					Session::flash('editInfo_message','Transaction was successfully done, an SMS/Email will be sent to you shortly');
					return Redirect::to('/admin/settings');
				}
				else
				{
	             	Session::flash('editInfo_message','Error');
					return Redirect::to('/admin/settings')->withErrors($validator)->withInput();   
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
			if(Session::get('account_type')=='admin')
				{
					$user_id = Session::get('user_id');
					$validator = AdminModel::validatePassword();

				 	if($validator->passes())
					{
						AdminModel::editPassword($user_id);
						Session::flash('editPassword_message','Transaction was successfully done, an SMS/Email will be sent to you shortly');
						return Redirect::to('/admin/settings');
					}
					else
					{
		             	Session::flash('editPassword_message','Error');
						return Redirect::to('/admin/settings')->withErrors($validator)->withInput();   
					}
				}
				App::abort(403);
 		}
 		App::abort(403);
 	}

 	/*//Transaction Processed Message
 	public function processedTransaction()
	{
		if(Session::get('user_id') )
		{
			if(Session::get('account_type')=='admin')
				{
					$user_id = Session::get('user_id');
					$validator = AdminModel::validateProcessTransaction();

				 	if($validator->passes())
					{
						AdminModel::updateTransactionStatus($id);
						Session::flash('processTransaction_message','Transaction was successfully processed, return to transaction page');
						return Redirect::to('/admin/settings');
					}
					else
					{
		             	Session::flash('editPassword_message','Error');
						return Redirect::to('/admin/settings')->withErrors($validator)->withInput();   
					}
				}
				App::abort(403);
 		}
 		App::abort(403);
 	}*/

}
