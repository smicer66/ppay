<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

class PageController extends Controller
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


	public function getPrivacyPolicy()
	{
		return view('guests.privacypolicy');
	}

    public function getMenus($dom)
    {
        $menus = \App\Models\Menu::where('school_id','=', $this->school->id)->get();
        return view('saas.pages.web_menus',  compact('menus'));
    }

    public function postNewMenu()
    {
        $input = \Input::all();
        $rules = array(
            'menuname' => 'required'
        );
        $msg = array(
            'menuname.required' => 'You must provide the name of your menu.'
        );
        $validator = Validator::make($input, $rules, $msg);
        if ($validator->fails()){
            $errors = $validator->messages();
            $str = "";
            foreach ( $errors->all() as $error ) {
                $str = $str."".$error."<br />";
            }

            \Session::flash('error', $str);
            return Redirect::back();
        }


        $menu = new \App\Models\Menu();
        $menu->id = primary_key();
        $menu->school_id = $this->school->id;
        $menu->menu_name = $input['menuname'];
        $menu->created_by_user_id = \Auth::user()->id;
        $menu->status = 'Valid';
        $menu->auth = 0;
$menu->menu_code = strtoupper(str_random(6));
        $menu->save();
        return redirect('/admin/menus')->with('message', 'New Menu successfully created');
    }

    public function getCreateMenuItem($dom, $id, $menuItemId=NULL)
    {
        $menu = \App\Models\Menu::where('id', '=', \Crypt::decrypt($id))->first();
        $menuitems = \App\Models\MenuItem::where('menu_id', '=', $menu->id)
            ->whereNull('parent_item_id')->get();
        if($menuItemId!=NULL)
            $menuItem = \App\Models\MenuItem::where('id', '=', \Crypt::decrypt($menuItemId))->first();

        return view('saas.pages.new_menu_item',  compact('menu', 'menuItem', 'menuitems'));
    }

    public function getViewMenuItems($dom, $menuId)
    {
        $menuId = \Crypt::decrypt($menuId);
        $menu = \App\Models\Menu::where('id', '=', $menuId)->first();
        $menuitems = \App\Models\MenuItem::where('menu_id', '=', $menuId)->with('parentMenuItem')->get();
        return view('saas.pages.web_menu_items',  compact('menuitems', 'menu'));
    }


    public function getMenuItemActionDone($dom, $id, $action)
    {
        $id = \Crypt::decrypt($id);
        if($action=='DELETE-MENU-ITEM')
        {
            $mnitem = \App\Models\MenuItem::where('id', '=', $id)->first();
            $menuId = $mnitem->menu_id;
            $mnitem->delete();
            return redirect('/admin/menus/view-items/'.\Crypt::encrypt($menuId))->with('message', 'Menu Item deleted successfully created');
        }
        else if($action=='DELETE-MENU')
        {
            $mitem = \App\Models\Menu::where('id', '=', $id)->first();
            $mitem->delete();
            return redirect('/admin/menus')->with('message', 'Menu deleted successfully created');
        }
    }


    public function getCreateMenuItemStepTwo($dom, $mItemId)
    {
        $mItem = \Crypt::decrypt($mItemId);

        $ften = NULL;
        $mItem = \App\Models\MenuItem::where('id', '=', $mItem)->first();
        if($mItem->feature=='PAGE')
        {
            $ften = \App\Models\Page::where('created_by_user_id', '=', \Auth::user()->id)
                ->where('status', '=', 'Published')->get();
        }
        return view('saas.pages.new_menu_item_step_two',  compact('ften', 'mItem'));
    }

    public function postCreateMenuItemStepTwo()
    {
        $input = (\Input::all());
        $node = explode('::::', $input['node']);
        $id = $node[1];
        $node = $node[0];
        $mItem = $input['mItem'];
        $mItem = \Crypt::decrypt($mItem);
        $mItem->featureId = $id;
        $mItem->url = "/pages/".$node;
        if($mItem->save())
        {
            return redirect('/admin/menus')->with('message', 'New Menu Item successfully created');
        }
    }

    public function postMenuItem()
    {
        $input = \Input::all();
        $rules = array(
            'name' => 'required'
        );
        $msg = array(
            'name.required' => 'You must provide the name of your menu item.'
        );
        $validator = Validator::make($input, $rules, $msg);
        if ($validator->fails()){
            $errors = $validator->messages();
            $str = "";
            foreach ( $errors->all() as $error ) {
                $str = $str."".$error."<br />";
            }

            \Session::flash('error', $str);
            return Redirect::back();
        }

        //dd($input);
        $linkType = $input['linkType'];
        $name = $input['name'];
        $url = $input['url'];
        $menu_id = $input['menu_id'];
        $parent_item_id = $input['parent_item_id'];

        if($linkType=='PAGE') {
$menuItemId = primary_key();
            $menuItem = new \App\Models\MenuItem();
            $menuItem->id = $menuItemId;
            $menuItem->school_id = $this->school->id;
            $menuItem->menu_id = \Crypt::decrypt($menu_id);
            $menuItem->created_by_user_id = \Auth::user()->id;
            $menuItem->menu_item_name = $name;
            $menuItem->parent_item_id = $parent_item_id=='-1' ? NULL : \Crypt::decrypt($parent_item_id);
            $menuItem->feature = $linkType;
            $menuItem->item_auth = isset($input['item_auth']) ? $input['item_auth'] : NULL;
            $menuItem->featureId = NULL;
            $menuItem->url = NULL;
	    $menuItem->save();
//dd($menuItem);
            return redirect('/admin/menus/create-menu-item-step-two/'.\Crypt::encrypt($menuItemId));
        }
        else if($linkType=='EXTERNAL URL'){
            $menuItem = new \App\Models\MenuItem();
            $menuItem->id = primary_key();
            $menuItem->school_id = $this->school->id;
            $menuItem->menu_id = \Crypt::decrypt($menu_id);
            $menuItem->created_by_user_id = \Auth::user()->id;
            $menuItem->menu_item_name = $name;
            $menuItem->parent_item_id = $parent_item_id=='-1' ? NULL : $parent_item_id;
            $menuItem->feature = $linkType;
            $menuItem->featureId = NULL;
            $menuItem->url = $url;
            $menuItem->item_auth = isset($input['item_auth']) ? $input['item_auth'] : NULL;
            $menuItem->save();
            return redirect('/admin/menus')->with('message', 'Menu Item successfully created');

        }
        else if($linkType=='DASHBOARD'){
            $menuItem = new \App\Models\MenuItem();
            $menuItem->id = primary_key();
            $menuItem->school_id = $this->school->id;
            $menuItem->menu_id = \Crypt::decrypt($menu_id);
            $menuItem->created_by_user_id = \Auth::user()->id;
            $menuItem->menu_item_name = $name;
            $menuItem->parent_item_id = $parent_item_id=='-1' ? NULL : $parent_item_id;
            $menuItem->feature = $linkType;
            $menuItem->featureId = NULL;
            $menuItem->url = "http://".$this->school->domain."/dashboard";
            $menuItem->item_auth = isset($input['item_auth']) ? $input['item_auth'] : NULL;
            $menuItem->save();
            return redirect('/admin/menus')->with('message', 'Menu Item successfully created');
        }
        else if($linkType=='ADMISSION'){
            $menuItem = new \App\Models\MenuItem();
            $menuItem->id = primary_key();
            $menuItem->school_id = $this->school->id;
            $menuItem->menu_id = \Crypt::decrypt($menu_id);
            $menuItem->created_by_user_id = \Auth::user()->id;
            $menuItem->menu_item_name = $name;
            $menuItem->parent_item_id = $parent_item_id=='-1' ? NULL : $parent_item_id;
            $menuItem->feature = $linkType;
            $menuItem->featureId = NULL;
            $menuItem->url = "http://".$this->school->domain."/admission";
            $menuItem->item_auth = isset($input['item_auth']) ? $input['item_auth'] : NULL;
            $menuItem->save();
            return redirect('/admin/menus')->with('message', 'Menu Item successfully created');
        }


    }

    public function actOnPage($dom, $id, $action)
    {
        $pg = \App\Models\Page::where('id', '=', \Crypt::decrypt($id))->first();
        if($pg!=NULL)
        {
            if($action == 'Publish')
            {
                $pg->status = 'Published';
                $pg->save();
                return redirect('/admin/pages')->with('message', 'Selected Web Page successfully published');
            }
            else if($action == 'UnPublish')
            {
                $pg->status = 'Saved';
                $pg->save();
                return redirect('/admin/pages')->with('message', 'Selected Web Page successfully unpublished');
            }
            else if($action == 'Delete')
            {
                $pg->delete();
                return redirect('/admin/pages')->with('message', 'Selected Web Page successfully deleted');
            }
            else
            {
                return redirect('/admin/pages');
            }
        }
        return redirect('/admin/pages');
    }

    public function postCreatePage()
    {
        $input = (\Input::all());

        $rules = array(
            'name' => 'required'
        );
        $msg = array(
            'name.required' => 'You must provide the name of your page.'
        );
        $validator = Validator::make($input, $rules, $msg);
        if ($validator->fails()){
            $errors = $validator->messages();
            $str = "";
            foreach ( $errors->all() as $error ) {
                $str = $str."".$error."<br />";
            }

            \Session::flash('error', $str);
            return Redirect::back();
        }

        $trait = str_slug($input['name'], "-");
        $contents = $input['page'];
        $contentsNoHtml = strip_tags($input['page']);
        $id = in_array('id', array_keys($input)) ? $input['id'] : NULL;

        $pg = $id==NULL ? new \App\Models\Page() : \App\Models\Page::where('id', '=', \Crypt::decrypt($id))->first();
        if($id==NULL) {
            $pg->id = primary_key();
            $pg->school_id = $this->school->id;
            $pg->created_by_user_id = \Auth::user()->id;
            $pg->status = 'Saved';
        }
        $pg->page_name = $input['name'];
        $pg->trait_url = $trait;
        $pg->contents = $contents;
        $pg->contents_no_html = $contentsNoHtml;
        if($pg->save())
        {
            if($id==NULL)
                return redirect('/admin/pages')->with('message', 'New Web Page successfully created');
            else
                return redirect('/admin/pages')->with('message', 'Web Page saved successfully');
        }else
        {
            \Session::flash('error', 'Saving Web Page was not successful. Please try again');
            return Redirect::back();
        }
    }

    public function getWebPages()
    {
        $pages = \App\Models\Page::where('school_id', '=', $this->school->id)->where('created_by_user_id', '=', \Auth::user()->id)->get();
		return view('saas.pages.web_pages',  compact('pages'));
    }


	public function getWebPage($domain, $pageurl)
	{
		//$page = \App\Models\Page::where('trait_url', '=', $pageurl)->where('status', '=', 'Published')->first();
		$page = getPage($pageurl);
		$lp = \App\Models\LandingPage::where('school_id', '=', $this->school->id);
		if($lp->count()>0)
		{
			$lp = $lp->first();
			if($lp->inner==1){
				return view('utility.'.$this->school->id.'.inner_page',  compact('page'));
			}else
			{
				return view('layouts.school_site_page',  compact('page'));
			}
		}
	}


    public function getCreatePage($dom, $id=NULL)
    {
        if($id!=NULL) {

            $page = \App\Models\Page::where('school_id', '=', $this->school->id)->where('id', '=', \Crypt::decrypt($id))->first();
        }

        return view('saas.pages.new_page',  compact('page'));
    }

    public function getUploadLandingPage($dom)
    {

        $lps = \App\Models\LandingPage::where('school_id', '=', $this->school->id)->with(['user'=>function($x){
            $x->with('user_profile');
        }])->get();

        return view('saas.pages.upload_index',  compact('lps'));
    }


    public function actOnWebsite($dom, $id, $action)
    {

		$dirPath = base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'utility'.DIRECTORY_SEPARATOR.$this->school->id);
		$dirPath1 = public_path('utility'.DIRECTORY_SEPARATOR.$this->school->id);

		if(deleteDir($dirPath))
		{
			if(deleteDir($dirPath1))
			{
				$id = \Crypt::decrypt($id);
				$lp = \App\Models\LandingPage::where('id', '=', $id);
				$lp->delete();
				return redirect('/admin/landingpage/upload')->with('message', 'Landing Page deleted successfully');
			}
		}
		return redirect('/admin/landingpage/upload')->with('message', 'Landing Page deletion failed. Please try again');

    }


    public function postUploadLandingPage()
    {
        $input = \Input::all();


        $file = "indexfile";
$innerFile = "innerFile";
        //dd($file);
        $image = \Input::file($file);
$imageInner = \Input::file($innerFile);
        $zipfile = \Input::file('zipfile');
        //$front = "front".$i;

        if((isset($image) && !is_null($image)) || (isset($zipfile) && !is_null($zipfile)))
        {
        }else{
            return redirect('/admin/landingpage/upload')->with('message', 'Landing Page or accessory Zip file must be uploaded');
        }

        $cnt = 0;
        $cnt1 = 0;

        if(isset($image) && !is_null($image) && $image->getClientOriginalExtension()=='php')
        {

            $path = base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'utility'.DIRECTORY_SEPARATOR.$this->school->id);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }else
			{
				$dir = $path;
				$dirPath = base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'utility'.DIRECTORY_SEPARATOR.$this->school->id);
				$dirPath1 = public_path('utility'.DIRECTORY_SEPARATOR.$this->school->id);

				if(deleteDir($dirPath))
				{
					if(deleteDir($dirPath1))
					{

					}
				}
			}
            $fileName = 'landingpage.blade.php';
            //dd($path);
            if($image->move($path, $fileName)) {
                $lp1 = \App\Models\LandingPage::where('school_id', '=', $this->school->id);
                $lp = $lp1->count() == 0 ? new \App\Models\LandingPage() : $lp1->first();
                if($lp1->count()==0)
                {
                    $lp->id = primary_key();
                }
                $lp->created_by = \Auth::user()->id;
                $lp->school_id = $this->school->id;
                $lp->lp_updated_at = (new \DateTime)->format('Y-m-d H:i:s');
$lp->outer = 1;
                $lp->save();
                $cnt1 = 1;
            }else
            {
                $cnt1 = -1;
            }
        }





	if(isset($imageInner) && !is_null($imageInner) && $imageInner->getClientOriginalExtension()=='php')
        {

            $path = base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'utility'.DIRECTORY_SEPARATOR.$this->school->id);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }else
			{
				$dir = $path;
				$dirPath = base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'utility'.DIRECTORY_SEPARATOR.$this->school->id);
				$dirPath1 = public_path('utility'.DIRECTORY_SEPARATOR.$this->school->id);


			}
            $fileName = 'inner_page.blade.php';
            //dd($path);
            if($imageInner->move($path, $fileName)) {
                $lp1 = \App\Models\LandingPage::where('school_id', '=', $this->school->id);
                $lp = $lp1->count() == 0 ? new \App\Models\LandingPage() : $lp1->first();
                if($lp1->count()==0)
                {
                    $lp->id = primary_key();
                }
                $lp->created_by = \Auth::user()->id;
                $lp->school_id = $this->school->id;
                $lp->lp_updated_at = (new \DateTime)->format('Y-m-d H:i:s');
				$lp->inner = 1;
                $lp->save();
                $cnt3 = 1;
            }else
            {
                $cnt3 = -1;
            }
        }



        if(isset($zipfile) && !is_null($zipfile) && $zipfile->getClientOriginalExtension()=='zip')
        {
            $lp = \App\Models\LandingPage::where('school_id', '=', $this->school->id);
            if($lp->count()>0) {
                $path = public_path('utility' . DIRECTORY_SEPARATOR . $this->school->id);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $fileName = 'tester.zip';
                $zipfile->move($path, $fileName);
                $zip = new \ZipArchive;

                if ($zip->open($path . DIRECTORY_SEPARATOR . $fileName) === true) {
                    $zip->extractTo($path);
                    $zip->close();
                    $cnt = 1;

                    $lp = $lp->first();
                    $lp->lp_updated_at = (new \DateTime)->format('Y-m-d H:i:s');
                    $lp->save();
                } else {
                    $cnt = -1;
                }
            }
            else{
                $cnt = -2;
            }

        }


        if($cnt==1 && $cnt1==1) {
            //landing page was present and uploaded successfully
            //zip file was present and not uploaded successfully
            return redirect('/admin/landingpage/upload')->with('message', 'Landing Page and accessory Zip file upload was successful');
        }
        else {
            if ($cnt1 == 1) {
                //landing page was present and uploaded successfully
                return redirect('/admin/landingpage/upload')->with('message', 'Landing Page successfully uploaded');
            }
            else if ($cnt1 == -1) {
                //landing page was present and uploaded successfully
                return redirect('/admin/landingpage/upload')->with('message', 'Landing Page was not successfully uploaded');
            }
            else if ($cnt1 == 0) {
                //landing page was not present
                return redirect('/admin/landingpage/upload')->with('message', 'School Website upload was not successful. To Upload you must select the landing page');
            }
            else {
                if ($cnt == 1) {
                    return redirect('/admin/landingpage/upload')->with('message', 'School Website Accessory files uploaded successfully');
                }
                else if ($cnt == 0){
                    return redirect('/admin/landingpage/upload')->with('message', 'School Website upload failed');
                }
                else if($cnt == -2)
                {
                    return redirect('/admin/landingpage/upload')->with('message', 'School Website upload failed');
                }
            }
        }


    }


    public function getIndex()
    {
        return view('core.guest.index');
    }


    public function getDevelopersPage()
    {
        return view('core.guest.developerspage');
    }

	public function getLiveChat()
	{
        return view('core.guest.livechat');
	}



	public function getDownloadMobile()
	{
       	return view('core.guest.downloadmobilepage');
	}


	public function getContactUsPage()
	{
        return view('core.guest.contactuspage');
	}

	public function getTermsAndConditions()
	{
        return view('core.guest.termsandconditionspage');
	}


	public function getComingSoon(Request $request)
	{
		$all = $request->all();


		/*$token = $all['token'];
		$payload = JWTAuth::setToken($token)->getPayload();

		\Session::put('jwt_token', $all['token']);
		\Session::put('server_token', $all['stk']);

        	$user = JWTAuth::toUser($token);
//dd($user);*/
		return view('guests.payment.web.bills.coming_soon', compact('all'));
	}


}
