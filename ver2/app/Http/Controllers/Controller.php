<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Session;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected $user;
    protected $all_merchant_schemes = [];
    protected $countries = [];
	protected $all_banks = [];
    protected $all_device_types = [];
    protected $all_card_schemes = [];
    protected $all_acquirers = [];
    protected $all_issuers = [];
    protected $all_provinces = [];
    protected $all_districts = [];
    protected $all_accounts = [];
    protected $all_ecards = [];

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            $this->authorization();
            $this->breadcrumbs['HOME'] = '/';
            $this->breadcrumbs['DASHBOARD'] = '/dashboard';


            if (\Auth::user()) {
                $loginKey = 'login_'.\Auth::user()->id;
//dd(\Auth::user());
                $authData = \Session::get($loginKey);

		  if($authData!=null)
		  {
                $accounts = \Session::get('accounts');
                $cards = \Session::get('cards');

                $data = json_decode($authData, TRUE);



                //dd($data);

                $this->countries = json_decode($data['all_countries']);
                $this->all_banks = json_decode($data['all_banks']);
                $this->all_device_types = json_decode($data['all_device_types']);
                $this->all_merchant_schemes = json_decode($data['all_merchant_schemes']);
                $this->all_card_schemes = json_decode($data['all_card_schemes']);
                $this->all_acquirers = json_decode($data['all_acquirers']);
                $this->all_issuers = json_decode($data['all_issuers']);
                $this->all_provinces = json_decode($data['all_provinces']);
                $this->all_districts = json_decode($data['all_districts']);
                $this->all_accounts = json_decode($accounts);
                $this->all_ecards = json_decode($cards);
                //dd($this->all_districts);
		 }
            }




            view()->share([
                'breadcrumbs' => $this->breadcrumbs,
                'countries' => $this->countries,
                'all_banks' => $this->all_banks,
                'all_device_types' => $this->all_device_types,
                'all_merchant_schemes' => $this->all_merchant_schemes,
                'all_card_schemes' => $this->all_card_schemes,
                'all_acquirers' => $this->all_acquirers,
                'all_issuers' => $this->all_issuers,
                'all_provinces' => $this->all_provinces,
                'all_districts' => $this->all_districts,
                'all_accounts' => $this->all_accounts,
                'all_ecards' => $this->all_ecards
            ]);
            return $next($request);
        });
    }

    public function authorization()
    {
        $this->user  = \Auth::user();
    }
}
