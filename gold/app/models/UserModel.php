<?php

class UserModel {


     //Get Summary Data
    public static function getSummaryData($user_id)
    {
        $cache_key = 'getUserSummary'.$user_id;
        $data = [];
        
        $transactions = Cache::remember($cache_key,5,function() use($user_id){
            $transactions = DB::table('transactions')
                                ->where('user_id',$user_id)
                                ->where('status', '<>', 'Initiated')
                                ->select('id','currency','amount','status','currency_val','exchange_val','created_at','type','ref_no', 'statement')
                                ->take(5)
                                ->orderBy('created_at','DESC')
                                ->get();

            return $transactions;
        });

        $currencies = DB::table('currencies')
                                     ->where('status','enabled')
                                     ->select('buy_value','sell_value','currency_name','image')
                                     ->get();


        $notifications = DB::table('notifications')
                                     ->where('user_id',$user_id)
                                     ->select('notices','added')
                                     ->get();


        $data['last_login'] = Session::get('last_login');
        $data['transactions'] = $transactions;
        $data['currencies'] = $currencies;
        $data['messages'] = $notifications;

        return $data;
    }

    //Process Buy
    public static function buy()
    {
        $data = Input::all();
        $user_id = Session::get('user_id');
        $currency = DB::table('currencies')
                                ->where('currency_name',Input::get('buy_currency'))
                                ->select('currency_name','buy_value')
                                ->first();

        $amount = Input::get('buy_amount');                       
        $exchange = Input::get('buy_amount') * $currency->buy_value;
        $exchange_kobo = $exchange * 100;
        $ref_no = $user_id.time();

        
        $site_redirect = 'http://maplexchange.com/users/payment-summary';
        $product_id = '6218';
        $pay_item_id = '101';
        $web_pay_currency = '566';
        $mac_key = '642AD5855E9E3CA9C8D83BCBD73944BBC9F20FA75D02C0FF04F4A6A99A191CF36249A5C414D85ACDBB173C7DAFB993F70E778373FBE130D9132EBE43B91BF676';
        $hash_val = hash('sha512', $ref_no.$product_id.$pay_item_id.$exchange_kobo.$site_redirect.$mac_key);
                            
        DB::table('transactions')
                            ->insert(
                                    array(
                                            'user_id'=> $user_id,
                                            'currency'=> $currency->currency_name,
                                            'currency_val'=> $currency->buy_value,
                                            'amount'=> Input::get('buy_amount'),
                                            'exchange_val'=> $exchange,
                                            'type'  =>  'Buy',
                                            'status' => 'Pending',
                                            'ref_no' => $ref_no,
                                            'statement' => '',
                                            'created_at'=>date('Y-m-d H:i:s')
                                          )
                                    );

        Cache::forget('getUserSummary'.$user_id);
        Cache::forget('getUserTransactions'.$user_id);
        Cache::forget('getTransactions');
        
        return [
                'ref_no' => $ref_no,
                'mac_key' => $mac_key,
                'hash_val' => $hash_val,
                'redirect_url' => $site_redirect,
                'product_id' => $product_id,
                'pay_item_id' => $pay_item_id,
                'currency'   => $web_pay_currency
        ];
        
     }

     //Buy Review
    public static function buyReview($others)
    {
        $data = Input::all();
        $user_id = Session::get('user_id');
        $first_name = Session::get('first_name');
        $last_name = Session::get('last_name');
        $email = Session::get('email');
        $currency_name = strtolower(Input::get('buy_currency'));
        
        $currency = DB::table('currencies')
                                ->where('currency_name',Input::get('buy_currency'))
                                ->select('currency_name','buy_value')
                                ->first();

        $amount = Input::get('buy_amount') * $currency->buy_value;
        $amount_kobo = $amount * 100; //convert to kobo


        $currency_set = DB::table('currencies_selected')
                                    ->where('user_id',$user_id)
                                    ->first();


        if(!is_null($currency_set) && $currency_set->$currency_name !=''){
            $data['status'] = true;
            $data['user_id'] = $user_id;
            $data['amount_summary'] = $amount;
            $data['amount'] = $amount_kobo;
            $data['currency_name'] = $currency_name;
            $data['currency_amount'] = Input::get('buy_amount');
            $data['first_name'] = $first_name;
            $data['last_name'] = $last_name;
            $data['email'] = $email;
            $data['ref_no'] = $others['ref_no'];
            $data['mac_key'] = $others['mac_key'];
            $data['hash_val'] = $others['hash_val'];
            $data['redirect_url'] = $others['redirect_url'];
            $data['product_id'] = $others['product_id'];
            $data['pay_item_id'] = $others['pay_item_id'];
            $data['currency'] = $others['currency'];
            
            return $data;
        }

        $data['status'] = false;
        return $data;
     }


    public static function getPaymentDetails($user_id, $ref_no)
   {
     $details = DB::table('transactions')
                                ->where('user_id',$user_id)
                                ->where('ref_no',$ref_no)
                                ->first();
      return $details;

   }

   public static function updatePayment($user_id, $ref_no, $status, $event, $payment_method, $payment_ref = null, $response_code)
   {
     $details = DB::table('transactions')
                                ->where('user_id',$user_id)
                                ->where('ref_no',$ref_no)
                                ->update(
                                      array('status' => $status, 'statement' => $event, 'payment_method' => $payment_method, 'payment_ref' => $payment_ref, 'response_code' => $response_code)       
                                 );  
       if ($details) {
            $details = DB::table('transactions')
                                    ->where('user_id',$user_id)
                                    ->where('ref_no',$ref_no)
                                    ->first();

         $data['user_id'] = Session::get('user_id');
         $data['first_name'] = Session::get('first_name');
         $data['last_name'] = Session::get('last_name');
         $data['email'] = Session::get('email');
         $data['currency_name'] = $details->currency;
         $data['amount'] = $details->exchange_val;
         $data['currency_amount'] = $details->amount;
         $data['ref_no'] = $ref_no;
         $data['event'] = $event;
         $data['payment_ref'] = $payment_ref;
         $data['payment_method'] = $payment_method;
         $data['response_code'] = $response_code;
        
         Cache::forget('getUserSummary'.$user_id);
         Cache::forget('getUserTransactions'.$user_id);
         Cache::forget('getTransactions');
         Cache::forget('getTransaction'. $details->id);
         return $data;
        } else {
          return null;
        }
   }

     //Process Sell
     public static function sell()
    {
        $data = Input::all();
        $user_id = Session::get('user_id');
        $currency = DB::table('currencies')
                                ->where('currency_name', Input::get('sell_currency'))
                                ->select('currency_name', 'sell_value')
                                ->first();

        $exchange = Input::get('sell_amount') * $currency->sell_value;
        $ref_no = $user_id.time();
                            
        DB::table('transactions')
                            ->insert(
                                    array(
                                            'user_id'=>$user_id,
                                            'currency'=>$currency->currency_name,
                                            'currency_val'=>$currency->sell_value,
                                            'amount'=> Input::get('sell_amount'),
                                            'exchange_val'=> $exchange,
                                            'type'  =>  'Sell',
                                            'status' => 'Pending',
                                            'ref_no' => $ref_no,
                                            'created_at'=>date('Y-m-d H:i:s')
                                          )
                                    );

        Cache::forget('getUserSummary'.$user_id);
        Cache::forget('getUserTransactions'.$user_id);

        return $ref_no;
     }

    //Sell review data
     public static function getSellDetails()
    {
        $data = Input::all();
        $currency_name = strtolower(Input::get('sell_currency'));
        $user_id = Session::get('user_id');
        $currency = DB::table('currencies')
                                ->where('currency_name', Input::get('sell_currency'))
                                ->select('currency_name', 'sell_value')
                                ->first();

        $currency_set = DB::table('currencies_selected')
                                    ->where('user_id',$user_id)
                                    ->first();

       if (!is_null($currency_set) && $currency_set->$currency_name !='') {
          return [
             'currency' => $currency,
             'input' => $data,
             'status' => true
          ];
       }
        return [
          'status' => false
        ];
     }

    //Validate Buy
    public static function validateBuy()
    {
        $rules = array(
                        'buy_currency' => 'required',
                        'buy_amount' => 'required|max:5|min:2'
                      );

        $validator = Validator::make(Input::all(),$rules);
        return $validator;
    }

    //Validate Sell
    public static function validateSell()
    {
        $rules = array(
                        'sell_currency' => 'required',
                        'sell_amount' => 'required|max:5|min:2'
                        );

        $validator = Validator::make(Input::all(),$rules);
        return $validator;
    }

    //Get Currency
    public static function getCurrencies()
    {
        $currencies = DB::table('currencies')
                                     ->where('status','enabled')
                                     ->select('id','currency_name','buy_value','sell_value','image')
                                     ->get();
        return $currencies;
    }

    //Get Transactions
    public static function getTransactions($user_id)
    {

        $cache_key = 'getUserTransactions'.$user_id;
        $data = Cache::remember($cache_key,5,function() use($user_id)
        {
            $data = DB::table('transactions')
                                ->where('user_id',$user_id)
                                ->where('status', '<>', 'Initiated')
                                ->select('id','currency','amount','currency_val','exchange_val','created_at','type','ref_no','status')
                                ->orderBy('created_at','DESC')
                                ->limit(20)
                                ->get();
            return $data;
        });
        return $data; 
    }

    //Get Transaction
    public static function getTransaction($user_id, $transaction_id)
    {
        $data = DB::table('transactions')
                                ->where('user_id',$user_id)
                                ->where('status','<>', 'Initiated')
                                ->where('id',$transaction_id)
                                ->select('currency','amount','currency_val','exchange_val','created_at','type','ref_no','status', 'statement', 'payment_method', 'payment_ref')
                                ->orderBy('created_at','DESC')
                                ->first();
        return $data;
    }

    //Get User Data
    public static function getUserData($user_id)
    {
        $user = DB::table('users')
                            ->where('id',$user_id)
                            ->select('first_name','last_name','email','phone_no','bank_account','bank_name')
                            ->first();

       $currencies = DB::table('currencies_selected')
                                    ->where('user_id',$user_id)
                                    ->first();

        if(is_null($currencies))
        {
            $currencies = new stdClass;
            $currencies->payza = "";
            $currencies->payza_email = "";
            $currencies->solidtrust = ""; 
            $currencies->solidtrust_email = "";
            $currencies->bitcoin = ""; 
            $currencies->bitcoin_email = "";
            $currencies->neteller = ""; 
            $currencies->neteller_email = "";
            $currencies->egopay = ""; 
            $currencies->egopay_email = "";
            $currencies->okpay = ""; 
            $currencies->okpay_acct = "";
            $currencies->binary = ""; 
            $currencies->binary_acct = "";
            $currencies->perfectmoney = ""; 
            $currencies->perfectmoney_acct = ""; 
            $currencies->webmoney = ""; 
            $currencies->webmoney_acct = "";
        }

        $data['info'] = $user;
        $data['currencies'] = $currencies;
        return $data;
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

        Session::put('first_name',Input::get('first_name'));
        Session::put('last_name',Input::get('last_name'));
        Session::put('phone_no',Input::get('phone_no'));
    }

     //Validate User Information
    public static function validateInfo()
    {
        $rules = array(
                        'first_name'=>'required|alpha|max:20|min:3',
                        'last_name'=>'required|alpha|max:20|min:3',
                        'phone_no'=>'required|max:11|min:11'
                      );

        $data = Input::except('email','edit_info');
        $validator = Validator::make($data,$rules);
        return $validator;
    }

    //Edit Password
    public static function editPassword($user_id)
    {
    
        $new_password = Input::get('new_password');
        $old_password = Input::get('old_password');

        $get_password = DB::table('users')->where('id',$user_id)->select('password')->first();

        if(md5($old_password)==$get_password->password)
        {
            DB::table('users')->where('id',$user_id)->update(array('password' =>md5($new_password)));
            return true; 
        }
        else
        {
            return false;
        }
               

    }

    //Validate Password
    public static function validatePassword()
    {
        $rules = array(
                        'old_password'=>'required',
                        'new_password'=>'required|min:5|max:20',
                      );

        $validator = Validator::make(Input::all(),$rules);
        return $validator;

    }

    //Edit EWallets
    public static function editECurrencies($user_id)
    {
        
        $check = DB::table('currencies_selected')->where('user_id',$user_id)->first();

        if(!is_null($check))
        {
            DB::table('currencies_selected')
                                ->where('user_id',$user_id)
                                ->update(
                                            array(
                                                    'payza' => Input::get('payza'),
                                                    'payza_email' => Input::get('payza_email'),
                                                    'solidtrust' => Input::get('solidtrust'),
                                                    'solidtrust_email' => Input::get('solidtrust_email'),
                                                    'bitcoin' => Input::get('bitcoin'),
                                                    'bitcoin_email' => Input::get('bitcoin_email'),
                                                    'neteller' => Input::get('neteller'),
                                                    'neteller_email' => Input::get('neteller_email'),
                                                    'egopay' => Input::get('egopay'),
                                                    'egopay_email' => Input::get('egopay_email'),
                                                    'okpay' => Input::get('okpay'),
                                                    'okpay_acct' => Input::get('okpay_acct'),
                                                    'binary' => Input::get('binary'),
                                                    'binary_acct' => Input::get('binary_acct'),
                                                    'perfectmoney' => Input::get('perfectmoney'),
                                                    'perfectmoney_acct' => Input::get('perfectmoney_acct'),
                                                    'webmoney' => Input::get('webmoney'),
                                                    'webmoney_acct' => Input::get('webmoney_acct'),
                                                 )
                                        );
        }
        else
        {
            DB::table('currencies_selected')
                                ->insert(
                                            array(
                                                    'user_id' => $user_id,
                                                    'payza' => Input::get('payza'),
                                                    'payza_email' => Input::get('payza_email'),
                                                    'solidtrust' => Input::get('solidtrust'),
                                                    'solidtrust_email' => Input::get('solidtrust_email'),
                                                    'bitcoin' => Input::get('bitcoin'),
                                                    'bitcoin_email' => Input::get('bitcoin_email'),
                                                    'neteller' => Input::get('neteller'),
                                                    'neteller_email' => Input::get('neteller_email'),
                                                    'egopay' => Input::get('egopay'),
                                                    'egopay_email' => Input::get('egopay_email'),
                                                    'okpay' => Input::get('okpay'),
                                                    'okpay_acct' => Input::get('okpay_acct'),
                                                    'binary' => Input::get('binary'),
                                                    'binary_acct' => Input::get('binary_acct'),
                                                    'perfectmoney' => Input::get('perfectmoney'),
                                                    'perfectmoney_acct' => Input::get('perfectmoney_acct'),
                                                    'webmoney' => Input::get('webmoney'),
                                                    'webmoney_acct' => Input::get('webmoney_acct'),
                                                 )
                                        );
        }

    }

    //Validate EWallets
    public static function validateECurrencies()
    {
        
        $rules = array(
                        'egopay_email'=>'email',
                        'bitcoin_email'=>'email', 
                        'neteller_email'=>'email',
                        'payza_email'=>'email',
                        'solidtrust_email'=>'email',
                        'okpay_acct'=>'alpha_num',
                        'binary_acct'=>'alpha_num',
                        'perfectmoney_acct'=>'alpha_num',
                        'webmoney_acct'=>'alpha_num'
                      );

        $validator = Validator::make(Input::all(),$rules);
        return $validator;

    }


    //Edit Bank Details
    public static function editBankDetails($user_id)
    {
        $bank_account = Input::get('bank_account');

        $get_bank_account = DB::table('users')->where('id',$user_id)->select('bank_account')->first();

         
            DB::table('users')
                        ->where('id',$user_id)
                        ->update(
                                    array(
                                            'bank_name' => Input::get('bank_name'),
                                            'bank_account' => $bank_account
                                         )
                                );
                    

    }

    //Validate Banks
    public static function validateBankDetails()
    {
        
        $rules = array('bank_account'=>'required|min:8|max:16');

        $validator = Validator::make(Input::all(), $rules);
        return $validator;

    }

}