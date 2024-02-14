<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getUpdateSettings()
    {

        return view('core.authenticated.settings.update_settings');
    }





    public function getViewSettings()
    {

        return view('core.authenticated.settings.settings_listing');
    }



	public function getShutDownServer(Request $request)
	{
		try
		{
			$all = $request->all();
			$dataStr = "token=".\Auth::user()->token;
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/shutdownServer';
			$server_output = sendPostRequest($url, $dataStr);
			//dd($server_output);
			$result = json_decode($server_output);
			//dd($result);
		


			if($result==null)
			{
				return \Redirect::back()->with('error', 'Error encountered');
			}

			//dd($result);
			if($result->status === 5000)
			{
				return \Redirect::back()->with('error', 'Error encountered');
			}
			else if($result->status == -1)
			{
				return \Redirect::back()->with('message','Your logged in session has expired. You have been logged out. Please log in again');
			}
			else
			{
				return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'We can not restart the server. Please manually restart the server');
			}
		}
		catch(\Exception $e)
		{
			return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'We can not restart the server. Please manually restart the server');
		}
	}




	public function getRestartServer(Request $request)
	{
		try
		{
			$all = $request->all();
			$dataStr = "token=".\Auth::user()->token;
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/restartServer';
			$server_output = sendPostRequest($url, $dataStr);
			//dd($server_output);
			$result = json_decode($server_output);
			//dd($result);
		


			if($result==null)
			{
				return \Redirect::back()->with('error', 'Error encountered');
			}

			//dd($result);
			if($result->status === 5000)
			{
				return \Redirect::back()->with('error', 'Error encountered');
			}
			else if($result->status == -1)
			{
				return \Redirect::back()->with('message','Your logged in session has expired. You have been logged out. Please log in again');
			}
			else
			{
				return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'We can not restart the server. Please manually restart the server');
			}
		}
		catch(\Exception $e)
		{
			return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'We can not restart the server. Please manually restart the server');
		}
	}


	
	public function getStartService(Request $request)
	{
		try
		{
			$all = $request->all();
			//$dataStr = "token=".\Auth::user()->token;
			$dataStr = "";
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/checkMemoryUsage';
			$server_output = sendPostRequest($url, $dataStr);
			//dd($server_output);
			$result = json_decode($server_output);
			//dd($result);
		


			if($result==null)
			{
				return \Redirect::back()->with('error', 'Error encountered');
			}

			//dd($result);
			if($result->status === 5000)
			{
				return \Redirect::back()->with('error', 'Error encountered');
			}
			else if($result->status == -1)
			{
				return \Redirect::back()->with('message','Your logged in session has expired. You have been logged out. Please log in again');
			}
			else
			{
				return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'We can not restart the server. Please manually restart the server');
			}			
		}
		catch(\Exception $e)
		{
			dd($e);
			return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'We can not restart the server. Please manually restart the server');
		}
	}


}
