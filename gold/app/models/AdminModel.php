<?php

class AdminModel {

	//Get System Summary
	public static function getSummaryData()
	{
	   $data['total_users'] = DB::table('users')->where('account_type','user')->count();
	   $data['total_active_users'] = DB::table('users')->where('status', 'Enabled')->where('account_type','user')->count();
	   $data['total_inactive_users'] = DB::table('users')->where('status', 'Disabled')->where('account_type','user')->count();

	
           $data['total_transactions'] = DB::table('transactions')->where('status','<>', 'Initiated')->count();
	   $data['total_buy_transactions'] = DB::table('transactions')->where('status','<>', 'Initiated')->where('type','Buy')->count();
	   $data['total_sell_transactions'] = DB::table('transactions')->where('status','<>', 'Initiated')->where('type', 'Sell')->count();
           $data['total_completed_transactions'] = DB::table('transactions')->where('status', 'Completed')->count();

           return $data;									
	}

	//Get Transactions
    public static function getTransactions()
    {
        $cache_key = 'getTransactions';
		$data = Cache::remember($cache_key,5,function() 
		{
	        $data = DB::table('transactions')
	        		    ->join('users', 'transactions.user_id', '=', 'users.id')
                                    ->where('transactions.status', '<>', 'Initiated')
	                            ->select('transactions.id as id','currency','amount','currency_val','exchange_val','transactions.created_at','type','ref_no','transactions.status', 'email')
	                            ->orderBy('transactions.created_at','DESC')
	                            ->get();
	        return $data;
         });

		return  $data;
    }

    //Get Transactions
    public static function getTransaction($id)
    {
        $cache_key = 'getTransaction'.$id;
		$data = Cache::remember($cache_key,5,function() use($id){
            $transaction = DB::table('transactions')
            			->join('users', 'transactions.user_id', '=', 'users.id')
                                ->where('transactions.id', $id)
                                ->where('transactions.status', '<>', 'Initiated')
                                ->select('transactions.id','currency','amount','currency_val','exchange_val','transactions.created_at','type','ref_no', 'transactions.status', 'statement', 'payment_method', 'payment_ref', 'response_code', 'email', 'first_name', 'last_name', 'phone_no')
                                ->get();

            return $transaction;
        });


		return  $data;
    }

    //Get Pending Transactions
    public static function getPendingTransaction($id)
    {
        $transaction = DB::table('transactions')
                           ->where('id', $id)
                           ->where('status','Pending')
                  ->select('id','currency','amount','currency_val','exchange_val','created_at','type','ref_no', 'status', 'statement', 'payment_method', 'payment_ref')
                                ->first();


	return  $transaction;
    }

    //updatePayment
    public static function updatePayment($id, $status, $statement, $payment_ref = null, $code = null)
   {
     $details = DB::table('transactions')
                                ->where('id',$id)
                                ->update(
                                      array('status' => $status, 'statement' => $statement, 'payment_ref' => $payment_ref, 'response_code' => $code)       
                                 );  
       if ($details) {
            $details = DB::table('transactions')
                                    ->where('id', $id)
                                    ->first();

            $user = DB::table('users')->where('id',$details->user_id)->first();

         $data['first_name'] = $user->first_name;
         $data['last_name'] = $user->last_name;
         $data['email'] = $user->email;
         $data['currency_name'] = $details->currency;
         $data['amount'] = $details->exchange_val;
         $data['currency_amount'] = $details->amount;
         $data['ref_no'] = $details->ref_no;
         $data['event'] = $details->statement;
         $data['payment_ref'] = $details->payment_ref;
         $data['payment_method'] = $details->payment_method;
         $data['response_code'] = $code;

         Cache::forget('getTransactions');
         Cache::forget('getTransaction'. $id);
         Cache::forget('getUserSummary'.$user->id);
         Cache::forget('getUserTransactions'.$user->id);

         return $data;

        } else {
          return null;
        }
   }

     //Update Transaction Status
    public static function updateTransactionStatus($id, $status, $statement)
    {
         $transaction = DB::table('transactions')
                        ->where('id',$id)
                        ->update(['status' => $status, 'statement'=> $statement]);

        if ($transaction) {
     		Cache::forget('getTransactions');
     		Cache::forget('getTransaction'. $id);
     		return true;
     	}
       return false;

    }

    //Get getUsers
    public static function getUsers()
    {
        $cache_key = 'getUsers';
		$data = Cache::remember($cache_key,5,function() 
		{
	        $data = DB::table('users')
	        		    ->where('account_type','user')
	                            ->select('id','first_name','last_name','email','phone_no','status','username')
	                            ->orderBy('created_at','DESC')
	                            ->get();
	        return $data;
	     });

			return  $data;
    }

    public static function viewUser($id)
	{
		$cache_key = 'viewUser'.$id;
		$data = Cache::remember($cache_key,5,function() use ($id) 
		{
			$user = DB::table('users')
				  ->where('id',$id)
				  ->first();
			return $user;
		});

		if($data)
			return $data;
		else
			return null;

	}

    //Get User Data
    public static function getUserData($user_id)
    {
        $info['username'] = Session::get('username');
        $info['first_name'] = Session::get('first_name');
        $info['last_name'] = Session::get('last_name');
        $info['phone_no'] = Session::get('phone_no');
        $info['email'] = Session::get('email');
        return $info;
    }

    public static function changeUserStatus($user_id, $status)
    {
		$data = DB::table('users')
			->where('id', $user_id)
			->update(array('status'=> $status));

		if ($data) {
			Cache::forget('getUsers');
			Cache::forget('viewUser'. $user_id);
			return true;
		} else {
			return false;
		}
	}

	public static function getReports()
	{
		
	}

	
	
	//Admin Change Password
	public static function changepassword()
    {
        $rules = array('password'=>'required|alpha_num');
        $validator = Validator::make(Input::all(),$rules);

        if($validator->passes())
        {
            $new_password = Input::get('password');
	       	DB::table('users')->where('id', Session::get('user_id'))->update(array('password' =>md5($new_password)));
	        return 1;
        }
    }
     
     public static function addCurrency($inputs)
     {
     	$data = DB::table('currencies')
     						->insert(
     									array(
     											'currency_name' => $inputs['name'],
     											'buy_value' => $inputs['buy'],
     											'sell_value' => $inputs['sell'],
     											'status' => $inputs['status'],
     											//'image' => $inputs['logo'],
     											'min' => $inputs['min'],
     											'alias' => $inputs['alias']
     										  )
     							     );
     	if ($data) {
     		Cache::forget('getCurrencies');
     		return true;
     	}
     	return false;        
     }

     public static function editCurrency($currency_id, $inputs)
     {
     	$data = DB::table('currencies')
     						->where('id', $currency_id)
     						->update(
     									array(
     											'currency_name' => $inputs['name'],
     											'buy_value' => $inputs['buy'],
     											'sell_value' => $inputs['sell'],
     											'status' => $inputs['status'],
     										//	'image' => $inputs['logo'],
     											'min' => $inputs['min'],
     											'alias' => $inputs['alias']
     										  )
     							     );
     	if ($data) {
     		Cache::forget('getCurrencies');
     		Cache::forget('getCurrency'. $currency_id);
     		return true;
     	}
     	return false;        
     }

     public static function deleteCurrency($currency_id)
     {
     	$data = DB::table('currencies')
     						->where('id', $currency_id)
     						->delete();
     	if ($data) {
     		Cache::forget('getCurrencies');
     		Cache::forget('getCurrency'. $currency_id);
     		return true;
     	}
     	return false;
     }

     public static function deleteBank($bank_id)
     {
     	$data = DB::table('banks')
     						->where('id', $bank_id)
     						->delete();
     	if ($data) {
     		Cache::forget('getBanks');
     		Cache::forget('getBank'. $bank_id);
     		return true;
     	}
     	return false;
     }

     public static function editBank($bank_id, $inputs)
     {
     	$data = DB::table('banks')
     						->where('id', $bank_id)
     						->update(
                                array(
                                        'status' => Input::get('status'),
                                        'bank_name' => Input::get('bank_name')
                                    )       
                             );  
     	if ($data) {
     		Cache::forget('getBanks');
     		Cache::forget('getBank'. $bank_id);
     		return true;
     	}
     	return false;
     }

     public static function addBank($inputs)
     {
     	$data = DB::table('banks')
     						->insert(
                                array(
                                        'status' => Input::get('status'),
                                        'bank_name' => Input::get('bank_name')
                                    )       
                             );  
     	if ($data) {
     		Cache::forget('getBanks');
     		return true;
     	}
     	return false;
     }

     public static function getBankDetails($bank_id)
     {
     	$cache_key = 'getBank'.$bank_id;
		$data = Cache::remember($cache_key, 5, function() use ($bank_id) {
			$bank = DB::table('banks')
								->where('id', $bank_id)
								->select('id','bank_name','status')
	                            ->first();
			return $bank;
		});
     	if ($data) {
     	   return $data;
     	}
     	return null;
     }

     public static function getCurrency($currency_id) 
     {
     	$cache_key = 'getCurrency'.$currency_id;
		$data = Cache::remember($cache_key, 5, function() use ($currency_id) {
			$currency = DB::table('currencies')
								->where('id', $currency_id)
								->select('id','currency_name','buy_value','sell_value','status', 'image', 'alias', 'min')
	                            ->first();
			return $currency;
		});

		if ($data) {
			return $data;
		}
		return null;
     }

     public static function getCurrencies()
   	 {
       $c_cache_key = 'getCurrencies';
		$currencies = Cache::remember($c_cache_key, 5, function() {
			$currencies = DB::table('currencies')
								->select('id','currency_name','buy_value','sell_value', 'status')
	                            ->get();
			return $currencies;
		});

        $b_cache_key = 'getBanks';
		$banks = Cache::remember($b_cache_key, 5, function() {
			$banks = DB::table('banks')
								->select('id','bank_name', 'status')
	                            ->get();
			return $banks;
		});

		return [
			'banks' => $banks,
			'currencies' => $currencies
		];
     }
	
    //Edit User Information
    public static function editUserInfo($user_id)
    {
        DB::table('users')
                    ->where('id',$user_id)
                    ->update(
                                array(
                                        'first_name' => Input::get('first_name'),
                                        'last_name' => Input::get('last_name'),
                                        'phone_no' => Input::get('phone_no')
                                    )       
                             );  

    }

     //Validate User Information
    public static function validateInfo()
    {
        $rules = array(
                        'first_name'=>'required|alpha|max:20',
                        'last_name'=>'required|alpha|max:20',
                        'phone_no'=>'required|alpha'
                      );

        $validator = Validator::make(Input::all(),$rules);
        return $validator;
    }

    //Edit Password
    public static function editPassword($user_id)
    {
        $rules = array(
                        'password'=>'required|alpha_num|confirmed',
                        'password_confirmation'=>'required',
                      );

        $validator = Validator::make(Input::all(),$rules);
       
        if ($validator->passes()) {
            $new_password = Input::get('password');
            DB::table('users')->where('id',$user_id)->update(array('password' =>md5($new_password)));
            return 1;
        }

    }

    //Validate Password
    public static function validatePassword()
    {
        $rules = array(
                        'password'=>'required|alpha_num|confirmed',
                        'password_confirmation'=>'required',
                      );

        $validator = Validator::make(Input::all(),$rules);
        return $validator;

    }
}