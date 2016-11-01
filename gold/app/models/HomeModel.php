<?php

class HomeModel {

	public static function getExchangeRates()
	{

		$rates = DB::table('currencies')
							->where('status','enabled')
							->select('currency_name','buy_value','sell_value','image','id','alias')
							->get();
		return $rates;

	}

	public static function generateToken($email)
	{

		$rules = array('email'=>'required|email');		
		$validator = Validator::make(Input::all(),$rules);
		
		if($validator->passes())
		{
			$exist = DB::table('users')
								  ->where('email',$email)
								  ->orWhere('username',$email)
								  ->select('email','id','first_name','last_name')
								  ->first();
			if(!is_null($exist))
			{
				$token = md5($email.date('Y-m-d H:i:s'));

				DB::table('users')
							->where('id',$exist->id)
							->update(
										array(
												'recovery_token' => $token,
												'recovery_time'	 => date('Y-m-d H:i:s',strtotime('+ 1 days'))
											 )
								    );


				$data = array(
								'name' =>$exist->last_name.' '.$exist->first_name,
								'token'=>$token,
								'email'=>$exist->email
							  );

				$result['status'] = true;
				$result['data'] = $data;
				$result['user'] = $exist;
				return $result;
			}
			else
			{
				$result['status'] = false;
				return $result;
			}
		}
		else
		{
			$result['status'] = false;
			return $result;
		}
	}

	//Password recovery check token
	public static function checkToken()
	{
		
		$rules = array(
						'email'=>'required|email',
						'token'=>'required'
					  );

		$validator = Validator::make(Input::all(),$rules);
		
		if($validator->passes())
		{
			$exist = DB::table('users')
								  ->where('email',Input::get('email'))
								  ->where('recovery_token',Input::get('token'))
								  ->select('recovery_time','email','recovery_token')
								  ->first();
			if(!is_null($exist))
			{
				$token_time = strtotime($exist->recovery_time);
				$now = strtotime(date('Y-m-d H:i:s'));

				if($token_time >= $now)
				{
					$data['token'] = $exist->recovery_token;
					$data['email'] = $exist->email;
					$data['status'] = true;
					return $data;
				}
				else
				{
					$data['message'] = 'Sorry your token has expired, request a new token!';
					$data['status'] = false;
					return $data;
				}				
			}
			else
			{
				$data['message'] = 'Something went wrong, please make sure to click the link from your email';
				$data['status'] = false;
				return $data;
			}
		}
		else
		{
			$data['message'] = 'Something went wrong, please make sure to click the link from your email';
			$data['status'] = false;
			return $data;
		}
		
	}

	public static function newPassword()
	{

		$rules = array(
						'password'=>'required|confirmed|alpha_num',
						'password_confirmation'=>'required'
					  );	

		$validator = Validator::make(Input::all(),$rules);
		
		if($validator->passes())
		{
			$update = DB::table('users')
						  ->where('email',Input::get('email'))	
						  ->where('recovery_token',Input::get('token'))	
						  ->update(
									array(
											'password' => md5(Input::get('password')),
											'recovery_token' => ' '
										 )
								  );

			if($update)
			{
				$data['validator'] = $validator;
				$data['status'] = true;
				return $data;
			}
			else
			{
				$data['validator'] = $validator;
				$data['status'] = false;
				return $data;
			}
			
		}
		else
		{
			$data['validator'] = $validator;
			$data['status'] = false;
			return $data;
		}
	}

	public static function registerValidate($inputs)
	{
		
		$rules = array(
				'username'=>'required|unique:users|between:4,12',
				'first_name'=>'required|alpha|max:20',
				'last_name'=>'required|alpha|max:20',
				'email'=>'required|email|unique:users',
				'email_confirmation'=>'required',
				'password'=>'required|confirmed',
				'password_confirmation'=>'required',
				'phone_no'=>'required|max:11',
				'address'=>'required|max:100',
				'state'=>'required',
				'country'=>'required',
				'dob'=>'required',
				'zip_code'=>'required'
			);

		
		$validator = Validator::make($inputs,$rules);
		return $validator;

	}

	public static function register($inputs)
	{

		$insert_data = array(
				'username'=>$inputs['username'],
				'first_name'=>$inputs['first_name'],
				'last_name'=>$inputs['last_name'],
				'email'=>$inputs['email'],
				'password'=> md5($inputs['password']),
				'phone_no'=> $inputs['phone_no'],
				'address'=>$inputs['address'],
				'state'=>$inputs['state'],
				'country'=>$inputs['country'],
				'dob'=>$inputs['dob'],
				'zip_code'=>$inputs['zip_code'],
				'account_type'=>'user',
				'last_login' => date('Y-m-d H:i:s'),
				'created_at'=> date('Y-m-d H:i:s'),
				'status' => 'Enabled'
			);
		
		$insert = DB::table('users')->insert($insert_data);
		return $insert_data;
		

	}

	public static function loginValidate($inputs)
	{

		$rules = array(
			'username'=>'required|between:4,12',
			'password'=>'required'
		);

		$validator = Validator::make($inputs,$rules);
		return $validator;
		
	}

	
	public static function setLoginSession($user)
	{

		Session::put('account_type', $user->account_type) ;
		Session::put('user_id', $user->id);
		Session::put('username', $user->username);
		Session::put('account_status', $user->status);
		Session::put('first_name',$user->first_name);
		Session::put('last_name', $user->last_name);
		Session::put('phone_no', $user->phone_no);
		Session::put('email', $user->email);
		Session::put('last_login', $user->last_login);
		Session::put('bank_name', $user->bank_name);
		Session::put('bank_account', $user->bank_account);

	}

	public static function check($inputs)
	{

		$user = DB::table('users')
							->where('username',$inputs['username'])
							->where('password',md5($inputs['password']))
							->select('first_name','last_name','account_type','id','username','phone_no','email','last_login','status','bank_name','bank_account','status')
							->first();

		if(!is_null($user))
		{
			DB::table('users')
					->where('username',$inputs['username'])
					->where('password',md5($inputs['password']))
					->where('status','Enabled')
					->update(array('last_login' => date('Y-m-d H:i:s')));
		}
		
		return $user;
	}

	public static function getCurrencyDropDown()
	{

		$currencies = DB::table('currencies')
									->where('status','enabled')
									->select('buy_value','sell_value','currency_name')
									->get();

		return json_encode($currencies);
	}

	public static function getBanks()
	{

		$banks = DB::table('banks')
									->where('status','enabled')
									->select('bank_name')
									->get();


		$user = DB::table('users')
								->where('id',Session::get('user_id'))
								->select('bank_name')
								->first();
		$data['banks'] = $banks;
		$data['user_bank'] = $user->bank_name;

		return json_encode($data);
	}

}