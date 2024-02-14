<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Illuminate\Contracts\Auth\Guard;
use JWTAuth;

class VillageBankingController extends Controller
{

    public function __construct()
    {
        parent::__construct();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }





    public function getViewMyGroups(Request $request, $id=NULL)
    {
        $user = \Auth::user();
        $groupMemberMap = \App\Models\VillageBankGroupMember::where('username', '=', $user->username)
            ->pluck('smartcoops_member_code', 'village_bank_group_id')->toArray();

        $groupSettings = \App\Models\VillageBankGroupSetting::whereIn('village_bank_group_id', array_keys($groupMemberMap))
            ->pluck('village_bank_group_id')->toArray();

        $villageBankGroups = \App\Models\VillageBankGroup::whereIn('id', array_keys($groupMemberMap))->get()->toArray();
        return view('core.authenticated.village_banking.my_groups', compact('request', 'groupSettings', 'villageBankGroups', 'groupMemberMap'));
    }


    public function getViewGroupTransactions(Request $request, $id=NULL)
    {
        return view('core.authenticated.village_banking.my_groups_transactions', compact('request'));
    }


	
    public function getVillageBankingList(Request $request)
    {
        return view('core.authenticated.village_banking.all_groups');
    }
}
