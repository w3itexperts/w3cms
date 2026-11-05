<?php

namespace Modules\AppManager\Http\Controllers;

use Illuminate\Http\Request;
use Modules\AppManager\Entities\W3app;
use Modules\AppManager\Entities\W3appFile;
use Modules\AppManager\Entities\DownloadHistory;
use Modules\AppManager\Entities\ThemePreset;
use App\Models\Country;
use App\Models\Language;
use App\Models\User;
use Storage;
use Str;
use Cache;
use ZipArchive;
use File;

class W3appsController extends ModuleController
{
	/**
	 * Display a listing of the resource.
	 * @return Renderable
	 */
	public function index(Request $request)
	{

		$resultQuery = W3app::where('type', 'T')->with('author');
		if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }
            if($request->filled('status')) {
                $resultQuery->where('status', '=', $request->input('status'));
            }
            if($request->filled('author_id')) {
                $resultQuery->where('author_id', '=', $request->input('author_id'));
            }
            if($request->filled('technology_platform')) {
                $resultQuery->where('technology_platform', '=', $request->input('technology_platform'));
            }
            if($request->filled('type')) {
                $resultQuery->where('type', '=', $request->input('type'));
            }
            if($request->filled('launching_date_from') && $request->filled('launching_date_to')) {
                $resultQuery->whereBetween('launching_date', [$request->input('launching_date_from'), $request->input('launching_date_to')]);
            }
            if($request->filled('keywords')) {
                $resultQuery->where('keywords', 'like', "%{$request->input('keywords')}%");
            }
            if($request->filled('feature_tags')) {
                $resultQuery->where('feature_tags', 'like', "%{$request->input('feature_tags')}%");
            }
        }

		$page_title = __('appmanager::common.all_w3apps');
		$w3apps = $resultQuery->paginate(config('Reading.nodes_per_page'));
		$technology_platform = config('appmanager.technology_platform');
		$type = config('appmanager.type');
		$status = config('appmanager.status');
		$authors = User::get();
		return view('appmanager::appsmanager.index', compact('w3apps', 'page_title', 'technology_platform', 'type', 'status', 'authors'));
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Renderable
	 */
	public function create()
	{
		return view('appmanager::appsmanager.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * @param Request $request
	 * @return Renderable
	 */
	public function store(Request $request)
	{
		$file_extension         = config("appmanager.file_extension");
		$file_extension_type    = implode(',', array_keys($file_extension));
		$validation = $this->validate($request, 
			[
				'title'                     => 'required',
				'slug'                      => 'required',
				'author_id'                 => 'required',
				'author_email'              => 'required',
			],
			[
				'title.required'                => 'The title field is required.',
				'slug.required'                 => 'The slug field is required.',
				'author_id.required'            => 'The author field is required.',
				'author_email.required'         => 'The author email field is required.',
			],
		);

		$w3app                        = new W3app();
		$w3app->title                 = $request->title;
		$w3app->slug                  = $request->slug;
		$w3app->author_id             = $request->author_id;
		$w3app->author_email          = $request->author_email;
		$w3app->code                  = $request->code;
		$w3app->description           = $request->description;
		$w3app->status                = $request->status;
		$res                            = $w3app->save();

		if($res) 
		{
			$w3appFile = array();
			if($request->hasFile('file')){ 
				foreach($request->file('file') as $imageKey=> $imageArray) {
					$originalExtension  = '.'.$imageArray->getClientOriginalExtension();
					$originalName       = $imageArray->getClientOriginalName();
					$fileName           = time().'_'.$originalName;
					$imageArray->storeAs('public/w3apps-images', $fileName);

					$w3appFile[] = array(
									'w3app_id'  => $w3app->id,
									// 'type'      => array_key_exists($originalExtension, $file_extension) ? $file_extension[$originalExtension] : '',
									'type'      => 'I',
									'file'      => $fileName,
								);

				}

				W3appFile::insert($w3appFile);

			}
			return redirect()->route('admin.appmanager.index')->with('success', __('appmanager::common.w3app_added_successfully'));
		}
		return redirect()->route('admin.appmanager.index')->with('error', __('appmanager::common.problem_in_form_submition'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param int $id
	 * @return Renderable
	 */
	public function edit($id)
	{
		$w3app = W3App::with('w3app_files')->findorFail($id);
		return view('appmanager::appsmanager.edit', compact('w3app'));
	}

	/**
	 * Update the specified resource in storage.
	 * @param Request $request
	 * @param int $id
	 * @return Renderable
	 */
	public function update(Request $request, $id)
	{
		$file_extension         = config("appmanager.file_extension");
		$file_extension_type    = implode(',', array_keys($file_extension));
		$validation = $this->validate($request, 
			[
				'title'                     => 'required',
				'slug'                      => 'required',
				'author_id'                 => 'required',
				'author_email'              => 'required',
			],
			[
				'title.required'                => 'The title field is required.',
				'slug.required'                 => 'The slug field is required.',
				'author_id.required'            => 'The author field is required.',
				'author_email.required'         => 'The author email field is required.',
			],
		);

		$w3app                        = W3app::findorFail($id);
		$w3app->title                 = $request->title;
		$w3app->slug                  = $request->slug;
		$w3app->author_id             = $request->author_id;
		$w3app->author_email          = $request->author_email;
		$w3app->status                = $request->status;
		$w3app->description           = $request->description;
		$res                          = $w3app->save();

		if($res) 
		{
			$w3appFile = array();
			if($request->hasFile('file')){ 
				foreach($request->file('file') as $imageKey=> $imageArray) {
					$originalExtension  = $imageArray->getClientOriginalExtension();
					$originalName       = $imageArray->getClientOriginalName();
					$fileName           = time().'_'.$originalName;
					$imageArray->storeAs('public/w3apps-images', $fileName);

					$w3appFile[] = array(
									'w3app_id'    => $w3app->id,
									// 'type' => array_key_exists($originalExtension, $file_extension) ? $file_extension[$originalExtension] : '',
									'type' => 'I',
									'file' => $fileName,
									);

				}

				W3appFile::insert($w3appFile);

			}
			return redirect()->route('admin.appmanager.index')->with('success', __('appmanager::common.w3app_updated_successfully'));
		}
		return redirect()->route('admin.appmanager.index')->with('error', __('appmanager::common.problem_in_form_submition'));
	}

	/**
	 * Remove the specified resource from storage.
	 * @param int $id
	 * @return Renderable
	 */
	public function destroy($id)
	{
		$w3app    	= W3app::findorFail($id);
		$res		= $w3app->delete();

		if($res) 
		{
			Storage::deleteDirectory('public/w3apps-files/'.$w3app->slug);
			return redirect()->route('admin.appmanager.index')->with('success', __('appmanager::common.w3app_deleted_successfully'));
		}
		return redirect()->route('admin.appmanager.index')->with('error', __('appmanager::common.problem_in_form_submition'));
	}

	public function edit_w3app_file(Request $request, $id='')
	{
		$w3appFile = W3appFile::findorFail($id);
		if($request->isMethod('post'))
		{
			$file_extension         = config("appmanager.file_extension");
			$file_extension_type    = implode(',', array_keys($file_extension));
			$request->validate([
				//'file' => 'mimes:'.$file_extension_type
			]);

			if($request->hasFile('file')){ 

				if($w3appFile->file && file_exists(Storage::path('public/w3apps-images/'.$w3appFile->file)))
				{
					Storage::delete('public/w3apps-images/'.$w3appFile->file);
				}

				$originalExtension  = $request->file('file')->getClientOriginalExtension();
				$originalName       = $request->file('file')->getClientOriginalName();
				if($request->input('title'))
				{
					$originalName   = Str::slug($request->input('title'), '_').'.'.$originalExtension;
				}
				$fileName           = time().'_'.$originalName;
				$request->file('file')->storeAs('public/w3apps-images', $fileName);
				$w3appFile->type         = array_key_exists($originalExtension, $file_extension) ? $file_extension[$originalExtension] : 'I';
				$w3appFile->file         = $fileName;
			} 
			else 
			{
				if($w3appFile->file && file_exists(Storage::path('public/w3apps-images/'.$w3appFile->file)))
				{
					$ext = pathinfo($w3appFile->file, PATHINFO_EXTENSION);
					$file_title = Str::slug($request->input('title'), '_');
					$fileName = time().'_'.$file_title.'.'.$ext;
					Storage::move('public/w3apps-images/'.$w3appFile->file, 'public/w3apps-images/'.$fileName);
					$w3appFile->file         = $fileName;
				}
			}
			$w3appFile->title    = $request->input('title');
			$w3appFile->detail   = $request->input('detail');
			$res                 = $w3appFile->save();

			if($res)
			{
				return redirect()->route('admin.appmanager.index')->with('success', __('appmanager::common.w3app_file_updated_successfully'));
			}
			return redirect()->route('admin.appmanager.index')->with('error', __('appmanager::common.something_went_wrong'));

		}
		return view('appmanager::appsmanager.edit_w3app_file', compact('w3appFile'));
	}

	public function destroy_w3app_file($id)
	{
		$w3appFile   = W3appFile::findorFail($id);
		$res = $w3appFile->delete();
		if($res) 
		{
			if($w3appFile)
			{
				if($w3appFile->file && file_exists(Storage::path('public/w3apps-images/'.$w3appFile->file)))
				{
					Storage::delete('public/w3apps-images/'.$w3appFile->file);
				}
			}
			return redirect()->back()->with('success', __('appmanager::common.w3app_file_deleted_successfully'));
		}
		return redirect()->back()->with('error', __('appmanager::common.something_went_wrong'));
	}

	/**
	 * Display a listing of the resource.
	 * @return Renderable
	 */
	public function themes(Request $request)
	{
		$resultQuery = W3app::where('type', 'T')->with('author');
		if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }
            if($request->filled('status')) {
                $resultQuery->where('status', '=', $request->input('status'));
            }
            if($request->filled('author_id')) {
                $resultQuery->where('author_id', '=', $request->input('author_id'));
            }
            if($request->filled('technology_platform')) {
                $resultQuery->where('technology_platform', '=', $request->input('technology_platform'));
            }
            if($request->filled('type')) {
                $resultQuery->where('type', '=', $request->input('type'));
            }
            if($request->filled('launching_date_from') && $request->filled('launching_date_to')) {
                $resultQuery->whereBetween('launching_date', [$request->input('launching_date_from'), $request->input('launching_date_to')]);
            }
            if($request->filled('keywords')) {
                $resultQuery->where('keywords', 'like', "%{$request->input('keywords')}%");
            }
            if($request->filled('feature_tags')) {
                $resultQuery->where('feature_tags', 'like', "%{$request->input('feature_tags')}%");
            }
        }

		$page_title = __('appmanager::common.themes');
		$w3apps = $resultQuery->paginate(config('Reading.nodes_per_page'));
		$technology_platform = config('appmanager.technology_platform');
		$type = config('appmanager.type');
		$status = config('appmanager.status');
		$authors = User::get();
		return view('appmanager::appsmanager.themes', compact('w3apps', 'page_title', 'technology_platform', 'type', 'status', 'authors'));
	}

	/**
	 * Display a listing of the resource.
	 * @return Renderable
	 */
	public function plugins(Request $request)
	{

		$resultQuery = W3app::where('type', 'P')->with('author');
		if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }
            if($request->filled('status')) {
                $resultQuery->where('status', '=', $request->input('status'));
            }
            if($request->filled('author_id')) {
                $resultQuery->where('author_id', '=', $request->input('author_id'));
            }
            if($request->filled('technology_platform')) {
                $resultQuery->where('technology_platform', '=', $request->input('technology_platform'));
            }
            if($request->filled('type')) {
                $resultQuery->where('type', '=', $request->input('type'));
            }
            if($request->filled('launching_date_from') && $request->filled('launching_date_to')) {
                $resultQuery->whereBetween('launching_date', [$request->input('launching_date_from'), $request->input('launching_date_to')]);
            }
            if($request->filled('keywords')) {
                $resultQuery->where('keywords', 'like', "%{$request->input('keywords')}%");
            }
            if($request->filled('feature_tags')) {
                $resultQuery->where('feature_tags', 'like', "%{$request->input('feature_tags')}%");
            }
        }

		$page_title = __('appmanager::common.themes');
		$w3apps = $resultQuery->with('author')->paginate(config('Reading.nodes_per_page'));
		$technology_platform = config('appmanager.technology_platform');
		$type = config('appmanager.type');
		$status = config('appmanager.status');
		$authors = User::get();
		return view('appmanager::appsmanager.plugins', compact('w3apps', 'page_title', 'technology_platform', 'type', 'status', 'authors'));
	}

	public function upload_theme(Request $request, $id=Null)
	{
		if($request->isMethod('post'))
		{
			$request->merge(['type' => 'T']);
			if($this->saveForm($request, $id)) 
			{
				return redirect()->route('admin.appmanager.themes')->with('success', __('appmanager::common.w3app_added_successfully'));
			}
			return redirect()->route('admin.appmanager.themes')->with('error', __('appmanager::common.problem_in_form_submition'));
		}

		$authors = User::get();
		$page_title = __('appmanager::common.upload_theme');
		$technology_platform = config('appmanager.technology_platform');
		$type = config('appmanager.type');
		$status = config('appmanager.status');
		$w3app = W3app::with('w3app_files')->where('id', $id)->first();
		return view('appmanager::appsmanager.upload_theme', compact('authors', 'page_title', 'technology_platform', 'type', 'status', 'w3app'));
	}

	public function upload_plugin(Request $request, $id=Null)
	{
		if($request->isMethod('post'))
		{
			$request->merge(['type' => 'P']);
			if($this->saveForm($request, $id)) 
			{
				return redirect()->route('admin.appmanager.plugins')->with('success', __('appmanager::common.w3app_added_successfully'));
			}
			return redirect()->route('admin.appmanager.plugins')->with('error', __('appmanager::common.problem_in_form_submition'));
		}

		$authors = User::get();
		$page_title = __('appmanager::common.upload_plugin');
		$technology_platform = config('appmanager.technology_platform');
		$type = config('appmanager.type');
		$status = config('appmanager.status');
		$w3app = W3app::with('w3app_files')->where('id', $id)->first();
		return view('appmanager::appsmanager.upload_plugin', compact('authors', 'page_title', 'technology_platform', 'type', 'status', 'w3app'));
	}

	private function saveForm($request, $id=Null)
	{
		$file_extension         = config("appmanager.file_extension");
		$file_extension_type    = implode(',', array_keys($file_extension));


		$rules = array(
					'title'                     => 'required',
					'slug'                      => 'required|unique:w3apps,slug',
					'author_id'                 => 'required',
					'author_email'              => 'required',
					'screenshots'               => 'required',
					'package_zip'               => 'required',
					'technology_platform'       => 'required',
				);

		$rules['preview_image'] = $id ? 'nullable' : 'required';

		if($id)
		{
			unset($rules['screenshots'], $rules['package_zip'], $rules['slug'], $rules['preview_image']);
		}
		
		if($request->input('preview_image') && Str::contains($request->input('preview_image'), 'screenshot.png'))
		{
			$rules['preview_image'] = 'nullable';
		}

		$validateData = $this->validate($request, $rules,
			[
				'preview_image.in' => 'The preview image name should be screenshot.png'
			],
			[
				'author_id' 			=> 'author',
				'author_email' 			=> 'author email',
				'package_zip' 			=> 'pacakage zip',
				'technology_platform'	=> 'technology platform'
			]
		);

		$screenshots = $this->uploadFiles($request, $id);
		if($screenshots)
		{
			$request->merge(['screenshots' => $screenshots]);
		}

		$w3app  = W3app::updateOrCreate(['id' => $id], array_filter($request->all()));

		if($w3app) 
		{
			if($request->input('package_zip'))
			{
				$w3appFile[] = array(
								'w3app_id'  => $w3app->id,
								'type'      => 'zip',
								'file'      => $request->input('package_zip'),
							);

				W3appFile::insert($w3appFile);
			}

			return true;
		}

		return false;
	}

	private function uploadFiles($request, $id=Null)
	{
		$w3app = W3app::where('id', $id)->first();
		$newDestinationPath = 'w3apps-files/'.$request->input('slug');

		$files = array('preview_image', 'screenshots', 'package_zip');
		$zip = new ZipArchive;
		$screenshots = [];

		foreach ($files as $value) {

			if($request->input($value))
			{
				if ($value == 'screenshots' && $zip->open(Storage::disk('public')->path('tempUpload/'.$request->input($value))) === true) {
					$zip->extractTo(Storage::disk('public')->path($newDestinationPath));
				    for ($i = 0; $i < $zip->numFiles; $i++) {
				        $screenshots[] = $zip->getNameIndex($i);
				        if($w3app && $w3app->{$value})
						{
							$this->removeFile('w3apps-files/'.$w3app->slug.'/'.$w3app->{$value});
						}
				    }
					$zip->close();

				}
				else
				{
					if(Storage::disk('public')->copy('tempUpload/'.$request->input($value), $newDestinationPath.'/'.$request->input($value)))
					{
						if($w3app && $w3app->{$value})
						{
							$this->removeFile('w3apps-files/'.$w3app->slug.'/'.$w3app->{$value});
						}
					}
				}
			}
		}

		return implode(',', $screenshots);
	}

	private function removeFile($path=Null)
	{
		if(Storage::disk('public')->exists($path))
		{
			return Storage::disk('public')->delete($path);
		}
	}

	public function view_w3app($id='')
	{
		$w3app = W3app::with('w3app_files', 'author')->findorFail($id);
		$page_title = __('appmanager::common.upload_plugin');
		$technology_platform = config('appmanager.technology_platform');
		$type = config('appmanager.type');
		$status = config('appmanager.status');
		$w3app = W3app::with('w3app_files')->where('id', $id)->first();
		return view('appmanager::appsmanager.view_w3app', compact('w3app', 'page_title', 'technology_platform', 'type', 'status'));
	}

	public function api_themes(Request $request)
	{
		$resultQuery = W3app::select('title', 'slug', 'author_email', 'preview_image', 'screenshots', 'package_zip', 'demo_link', 'documentation_link', 'description', 'launching_date', 'feature_tags', 'updated_at')->where('status', 'L')->where('type', $request->input('type') ? $request->input('type') : 'T')->with('author');
        if($request->input('search_apps') && $request->input('search_apps') != 'all_theme')
		{
        	$resultQuery->where(function ($query) use($request) {
        		$query->orWhere('title', 'like', "%{$request->input('search_apps')}%");
                $query->orWhere('keywords', 'like', "%{$request->input('search_apps')}%");
                $query->orWhere('feature_tags', 'like', "%{$request->input('search_apps')}%");
           	});
		}
		$w3apps = $resultQuery->get();

		if($w3apps)
		{
			$themes = array();
		    foreach($w3apps as $key => $value)
		    {
		    	$value['preview_image'] = $value->preview_image ? asset('storage/w3apps-files/'.$value->slug.'/'.$value->preview_image) : asset('images/noimage.jpg');
		        $screenshots = explode(',', $value->screenshots);
		        $feature_tags = explode(',', $value->feature_tags);
		        sort($screenshots);
		        if($screenshots)
		        {
		            foreach($screenshots as $key => $screenshot)
		            {
		                $screenshots[$key] = asset('storage/w3apps-files/'.$value->slug.'/'.$screenshot);
		            }
		        }
		        $value['screenshots'] = $screenshots;
		        $value['tags'] = $feature_tags;
		        $value['package'] = asset('storage/w3apps-files/'.$value->slug.'/'.$value->package_zip);
		        $value['admin_theme'] = $value->type == 'A' ? true : false;
		        $themes[] = $value;
		    }
			return response()->json( array('success' => true, 'themes' => $w3apps, 'themes_count' => count($w3apps)) );
		}
		return response()->json( array('success' => false, 'themes' => $w3apps, 'themes_count' => 0) );
	}

	/**
	 * Display a listing of the W3cms Admin Themes.
	 * @return Renderable
	 */
	public function admin_themes(Request $request)
	{
		$resultQuery = W3app::where('type', 'A')->with('author');
		if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }
            if($request->filled('status')) {
                $resultQuery->where('status', '=', $request->input('status'));
            }
            if($request->filled('author_id')) {
                $resultQuery->where('author_id', '=', $request->input('author_id'));
            }
            if($request->filled('technology_platform')) {
                $resultQuery->where('technology_platform', '=', $request->input('technology_platform'));
            }
            if($request->filled('type')) {
                $resultQuery->where('type', '=', $request->input('type'));
            }
            if($request->filled('launching_date_from') && $request->filled('launching_date_to')) {
                $resultQuery->whereBetween('launching_date', [$request->input('launching_date_from'), $request->input('launching_date_to')]);
            }
            if($request->filled('keywords')) {
                $resultQuery->where('keywords', 'like', "%{$request->input('keywords')}%");
            }
            if($request->filled('feature_tags')) {
                $resultQuery->where('feature_tags', 'like', "%{$request->input('feature_tags')}%");
            }
        }

		$page_title = __('appmanager::common.admin_themes');
		$w3apps = $resultQuery->paginate(config('Reading.nodes_per_page'));
		$technology_platform = config('appmanager.technology_platform');
		$type = config('appmanager.type');
		$status = config('appmanager.status');
		$authors = User::get();
		return view('appmanager::appsmanager.admin_themes', compact('w3apps', 'page_title', 'technology_platform', 'type', 'status', 'authors'));
	}

	public function upload_admin_theme(Request $request, $id=Null)
	{
		if($request->isMethod('post'))
		{
			$request->merge(['type' => 'T']);
			if($this->saveForm($request, $id)) 
			{
				return redirect()->route('admin.appmanager.themes')->with('success', __('appmanager::common.w3app_added_successfully'));
			}
			return redirect()->route('admin.appmanager.themes')->with('error', __('appmanager::common.problem_in_form_submition'));
		}

		$authors = User::get();
		$page_title = __('appmanager::common.upload_admin_theme');
		$technology_platform = config('appmanager.technology_platform');
		$type = config('appmanager.type');
		$status = config('appmanager.status');
		$w3app = W3app::with('w3app_files')->where('id', $id)->first();
		return view('appmanager::appsmanager.upload_admin_theme', compact('authors', 'page_title', 'technology_platform', 'type', 'status', 'w3app'));
	}
	
    public function get_language_file(Request $request)
    {
        $filename = $request->input('filename');
        if (!empty($filename) && file_exists(public_path('/language/'.$filename.'.zip'))) {
            return response()->json(['status' => 'success', 'language_file' => url('public/language/' . $filename.'.zip')]);
        }

        return response()->json(['status' => 'error', 'msg' => 'File downloaded failed.']);
    }

    public function get_country_detail(){
        return Country::all();
    }

    public function get_main_language_detail(){

        $countryLanguages = Country::with('main_language')->get();
        $langObj = new Language;
        $universal_lang = $langObj->universal()->first();

		foreach($countryLanguages as &$country){

			if(!$country->main_language){
				$country->main_language = $universal_lang ;
			}
		}

        return $countryLanguages;
    }

    public function get_language_detail(){
        return Language::all();
    }

    public function client_information_api(Request $request)
    {
        $client_info = $request->input('client_info');
        // if(!in_array($request->input(['192.168.29.219','192.168.29.206'],'client_info.user_ip'))){
            return DownloadHistory::create($client_info);
        // }
        return true;
    }

	public function api_modules(Request $request)
	{
		$resultQuery = W3app::select('title', 'slug', 'author_email', 'preview_image', 'screenshots', 'package_zip', 'demo_link', 'documentation_link', 'description', 'launching_date', 'feature_tags', 'downloads', 'updated_at')->where('status', 'L')->where('type', $request->input('type') ? $request->input('type') : 'P')->with('author');
        if($request->input('search_apps') && $request->input('search_apps') != 'all_theme')
		{
        	$resultQuery->where(function ($query) use($request) {
        		$query->orWhere('title', 'like', "%{$request->input('search_apps')}%");
                $query->orWhere('keywords', 'like', "%{$request->input('search_apps')}%");
                $query->orWhere('feature_tags', 'like', "%{$request->input('search_apps')}%");
           	});
		}
		$w3apps = $resultQuery->get();

		if($w3apps)
		{
			$modules = array();
		    foreach($w3apps as $key => $value)
		    {
		    	$value['preview_image'] = $value->preview_image ? asset('storage/w3apps-files/'.$value->slug.'/'.$value->preview_image) : asset('images/noimage.jpg');
		        $screenshots = explode(',', $value->screenshots);
		        $feature_tags = explode(',', $value->feature_tags);
		        sort($screenshots);
		        if($screenshots)
		        {
		            foreach($screenshots as $key => $screenshot)
		            {
		                $screenshots[$key] = asset('storage/w3apps-files/'.$value->slug.'/'.$screenshot);
		            }
		        }
		        $value['screenshots'] = $screenshots;
		        $value['tags'] = $feature_tags;
		        $value['package'] = asset('storage/w3apps-files/'.$value->slug.'/'.$value->package_zip);
		        $modules[] = $value;
		    }
			return response()->json( array('success' => true, 'modules' => $w3apps, 'modules_count' => count($w3apps)) );
		}
		return response()->json( array('success' => false, 'modules' => $w3apps, 'modules_count' => 0) );
	}
	
	/**
	 * Full detail for one store item - used by install confirm / view details popup.
	 * GET api/api/app_detail?slug={slug}&type=P|T   (type defaults to P, same as api_modules)
	 * Returns {success, module:{...}} or {success:false, message}
	 */
	public function app_detail(Request $request)
	{
		$slug = $request->input('slug');

		if (!$slug) {
			return response()->json(['success' => false, 'module' => null, 'message' => 'Missing slug parameter.']);
		}

		$w3app = W3app::with('author')
			->where('status', 'L')
			->where('type', $request->input('type') ? $request->input('type') : 'P')
			->where('slug', $slug)
			->first();

		if (!$w3app) {
			return response()->json(['success' => false, 'module' => null, 'message' => 'Module not found.']);
		}

		$w3app['preview_image'] = $w3app->preview_image ? asset('storage/w3apps-files/' . $w3app->slug . '/' . $w3app->preview_image) : asset('images/noimage.jpg');

		$screenshots = array_filter(explode(',', (string) $w3app->screenshots));
		sort($screenshots);
		foreach ($screenshots as $key => $screenshot) {
			$screenshots[$key] = asset('storage/w3apps-files/' . $w3app->slug . '/' . trim($screenshot));
		}
		$w3app['screenshots'] = array_values($screenshots);

		$w3app['tags'] = array_values(array_filter(array_map('trim', explode(',', (string) $w3app->feature_tags))));
		$w3app['package'] = asset('storage/w3apps-files/' . $w3app->slug . '/' . $w3app->package_zip);

		return response()->json(['success' => true, 'module' => $w3app]);
	}

	/**
	 * Store API: package module.json versions for requested slugs.
	 * Body: { slugs: ["samplemodule", ...] } -> { success, versions: { slug: "1.0.0" | "" } }
	 * Version is read from the module.json inside each package zip (no version column needed).
	 */
	public function api_module_versions(Request $request)
	{
		$slugs = array_filter(array_map('trim', (array) $request->input('slugs', [])));
		$versions = array();
		foreach ($slugs as $slug) {
			$versions[$slug] = Cache::remember('w3app_package_version.' . $slug, now()->addMinutes(10), function () use ($slug) {
				return $this->readPackageVersion($slug);
			});
		}
		return response()->json(['success' => true, 'versions' => $versions]);
	}

	/**
	 * Read the "version" field from a store package zip's root module.json.
	 * Returns '' when the app, zip or version is unavailable (cacheable miss).
	 */
	private function readPackageVersion(string $slug): string
	{
		$w3app = W3app::where('slug', $slug)->first();
		if (!$w3app || !$w3app->package_zip) {
			return '';
		}

		$path = storage_path('app/public/w3apps-files/' . $slug . '/' . $w3app->package_zip);
		if (!is_file($path)) {
			$path = public_path('storage/w3apps-files/' . $slug . '/' . $w3app->package_zip);
		}
		if (!is_file($path)) {
			return '';
		}

		$zip = new ZipArchive;
		if ($zip->open($path) !== true) {
			return '';
		}

		$version = '';
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$entry = str_replace('\\', '/', (string) $zip->getNameIndex($i));
			if (substr_count($entry, '/') === 1 && str_ends_with($entry, '/module.json')) {
				$json = json_decode((string) $zip->getFromIndex($i), true);
				if (is_array($json) && !empty($json['version'])) {
					$version = (string) $json['version'];
				}
				break;
			}
		}
		$zip->close();
		return $version;
	}

	/**
	 * Store API: count one installation (client pings after a successful store install).
	 * Body: { slug } -> { success }
	 */
	public function api_install_report(Request $request)
	{
		$slug = (string) $request->input('slug');
		$w3app = $slug !== '' ? W3app::where('slug', $slug)->first() : null;
		if (!$w3app) {
			return response()->json(['success' => false, 'message' => 'Module not found.']);
		}
		$w3app->increment('downloads');
		return response()->json(['success' => true]);
	}
}
