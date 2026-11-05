<?php

namespace App\Http\Controllers\Admin;

use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use File;
use ZipArchive;

class ModulesController extends Controller
{
	/**
	 * Modules that cannot be disabled / deleted.
	 * (Core modules list - to be discussed later)
	 */
	protected $protectedModules = ['CustomField'];

	/**
	 * Last modules API error message (set by getApiModules).
	 */
	protected $apiError = null;

	/**
	 * List all installed modules (nwidart), ordered by module.json "priority".
	 * Supports filters (search/type/status/update) on normal GET and via AJAX JSON.
	 */
	public function index(Request $request)
	{
		$page_title       = __('Modules');
		$all              = collect(Module::all());
		$protectedModules = $this->protectedModules;

		$search = trim((string) $request->get('search'));
		$type   = (string) $request->get('type');
		$status = (string) $request->get('status');
		$update = (string) $request->get('update');

		// Runs on every Installed Modules screen open (5-min cache; null = store unreachable).
		$versions = $this->liveVersions();

		$modules = $all->filter(function ($module) use ($search, $type, $status, $update, $versions) {
			if ($search !== '') {
				$haystack = mb_strtolower($module->getName() . ' ' . $module->getDescription());
				if (mb_strpos($haystack, mb_strtolower($search)) === false) {
					return false;
				}
			}
			if ($type !== '') {
				$moduleType = in_array($module->getName(), $this->protectedModules) ? 'core' : 'standard';
				if ($type !== $moduleType) {
					return false;
				}
			}
			if ($status !== '' && ($status === 'active') !== $module->isEnabled()) {
				return false;
			}
			if ($update === 'available' || $update === 'current') {
				return $this->updateState($module, $versions) === $update;
			}
			return true;
		})->values();

		$activeCount = $all->filter(function ($module) {
			return $module->isEnabled();
		})->count();
		$stats = [
			'total'    => count($all),
			'active'   => $activeCount,
			'inactive' => count($all) - $activeCount,
		];
		$stats['updates'] = $versions === null ? null : $all->filter(function ($module) use ($versions) {
			return $this->updateState($module, $versions) === 'available';
		})->count();

		$updateStates = [];
		foreach ($all as $module) {
			$updateStates[$module->getName()] = $this->updateState($module, $versions);
		}
		$count = count($modules);

		if ($request->ajax()) {
			return response()->json([
				'table_html' => view('admin.modules.list_view', [
					'modules'          => $modules,
					'protectedModules' => $protectedModules,
					'updateStates'     => $updateStates,
				])->render(),
				'count_text' => $count . ($count === 1 ? __(' module found') : __(' modules found')),
				'stats'      => $stats,
				'empty'      => $count === 0,
			]);
		}

		return view('admin.modules.index', [
			'page_title'       => $page_title,
			'modules'          => $modules,
			'protectedModules' => $protectedModules,
			'updateStates'     => $updateStates,
			'stats'            => $stats,
			'count'            => $count,
			'filters'          => [
				'search' => $search,
				'type'   => $type,
				'status' => $status,
				'update' => $update,
			],
		]);
	}

	/**
	 * Enable a module: admin/modules/enable?module=Name
	 */
	public function enable(Request $request)
	{
		$name = $request->get('module');

		if ($name && Module::find($name)) {
			Module::enable($name);
			if ($request->ajax()) {
				return response()->json(['success' => true, 'message' => __('Module enabled successfully.')]);
			}
			return redirect()->back()->with('success', __('Module enabled successfully.'));
		}

		if ($request->ajax()) {
			return response()->json(['success' => false, 'message' => __('Module not found.')]);
		}
		return redirect()->back()->with('error', __('Module not found.'));
	}

	/**
	 * Disable a module: admin/modules/disable?module=Name
	 */
	public function disable(Request $request)
	{
		$name = $request->get('module');

		if ($name && in_array($name, $this->protectedModules)) {
			if ($request->ajax()) {
				return response()->json(['success' => false, 'message' => __('This module cannot be disabled.')]);
			}
			return redirect()->back()->with('error', __('This module cannot be disabled.'));
		}

		if ($name && Module::find($name)) {
			Module::disable($name);
			if ($request->ajax()) {
				return response()->json(['success' => true, 'message' => __('Module disabled successfully.')]);
			}
			return redirect()->back()->with('success', __('Module disabled successfully.'));
		}

		if ($request->ajax()) {
			return response()->json(['success' => false, 'message' => __('Module not found.')]);
		}
		return redirect()->back()->with('error', __('Module not found.'));
	}

	/**
	 * Delete a module: admin/modules/delete?module=Name
	 * Protected modules and enabled modules are blocked.
	 */
	public function delete(Request $request)
	{
		$name = $request->get('module');

		if ($name && in_array($name, $this->protectedModules)) {
			if ($request->ajax()) {
				return response()->json(['success' => false, 'message' => __('This module cannot be deleted.')]);
			}
			return redirect()->back()->with('error', __('This module cannot be deleted.'));
		}

		if ($name && Module::find($name)) {
			if (Module::isEnabled($name)) {
				if ($request->ajax()) {
					return response()->json(['success' => false, 'message' => __('Please disable the module before deleting it.')]);
				}
				return redirect()->back()->with('error', __('Please disable the module before deleting it.'));
			}

			Module::delete($name);
			if ($request->ajax()) {
				return response()->json(['success' => true, 'message' => __('Module deleted successfully.')]);
			}
			return redirect()->back()->with('success', __('Module deleted successfully.'));
		}

		if ($request->ajax()) {
			return response()->json(['success' => false, 'message' => __('Something went wrong with deleting module.')]);
		}
		return redirect()->back()->with('error', __('Something went wrong with deleting module.'));
	}

	/**
	 * Confirm popup fragments: server-rendered views loaded via AJAX
	 * into the layout's #AjaxModalBoxXl modal (target ajax pattern).
	 */
	public function confirm_enable(Request $request)
	{
		return $this->moduleConfirmView($request, 'admin.modules.modal_enable');
	}

	public function confirm_disable(Request $request)
	{
		$name   = $request->get('module');
		$module = $name ? Module::find($name) : null;

		if (!$module) {
			return view('admin.modules.modal_error', ['name' => $name ?: '']);
		}

		$dependents = [];
		foreach (Module::all() as $other) {
			if ($other->getName() === $module->getName()) {
				continue;
			}
			if (trim((string) $other->get('parent')) === $module->getName()) {
				$dependents[] = $other->getName();
			}
		}

		return view('admin.modules.modal_disable', [
			'module'           => $module,
			'protectedModules' => $this->protectedModules,
			'dependents'       => $dependents,
		]);
	}

	public function confirm_delete(Request $request)
	{
		return $this->moduleConfirmView($request, 'admin.modules.modal_delete');
	}

	public function confirm_update(Request $request)
	{
		$name   = $request->get('module');
		$module = $name ? Module::find($name) : null;

		if (!$module) {
			return view('admin.modules.modal_error', ['name' => $name ?: '']);
		}

		$versions   = $this->liveVersions();
		$alias      = trim((string) $module->get('alias'));
		$liveVersion = $versions !== null && $alias !== '' ? trim((string) ($versions[$alias] ?? '')) : '';
		$liveVersion = $liveVersion !== '' ? $liveVersion : null;

		return view('admin.modules.modal_update', [
			'module'           => $module,
			'protectedModules' => $this->protectedModules,
			'liveVersion'      => $liveVersion,
		]);
	}

	/**
	 * Server-rendered details drawer body for a module row.
	 */
	public function row_details(Request $request)
	{
		$name    = $request->get('module');
		$module  = $name ? Module::find($name) : null;

		return view('admin.modules.row_details', [
			'module'           => $module,
			'protectedModules' => $this->protectedModules,
			'updateState'      => $module ? $this->updateState($module, $this->liveVersions()) : 'unknown',
		]);
	}

	/**
	 * Bulk action handler (activate/deactivate/delete) — AJAX JSON only.
	 * Protected modules are skipped; deleting an enabled module is skipped.
	 */
	public function bulk_action(Request $request)
	{
		$action = (string) $request->post('action');
		$names  = array_filter(array_map('trim', (array) $request->post('modules', [])));

		if (!$names) {
			return response()->json(['success' => false, 'message' => __('Select at least one module.')]);
		}

		if (!in_array($action, ['activate', 'deactivate', 'delete', 'update'], true)) {
			return response()->json(['success' => false, 'message' => __('Unknown bulk action.')]);
		}

		if ($action === 'update') {
			return response()->json(['success' => false, 'message' => __('Module updates are not available yet.')]);
		}

		$enabled = $disabled = $deleted = $skipped = 0;

		foreach ($names as $name) {
			$module = Module::find($name);

			if (!$module || in_array($name, $this->protectedModules)) {
				$skipped++;
				continue;
			}

			if ($action === 'activate') {
				if ($module->isEnabled()) {
					$skipped++;
					continue;
				}
				Module::enable($name);
				$enabled++;
			} elseif ($action === 'deactivate') {
				if (!$module->isEnabled()) {
					$skipped++;
					continue;
				}
				Module::disable($name);
				$disabled++;
			} else { // delete
				if ($module->isEnabled()) {
					$skipped++;
					continue;
				}
				Module::delete($name);
				$deleted++;
			}
		}

		$parts = [];
		if ($enabled)  $parts[] = $enabled . __(' enabled');
		if ($disabled) $parts[] = $disabled . __(' deactivated');
		if ($deleted)  $parts[] = $deleted . __(' deleted');
		if ($skipped)  $parts[] = $skipped . __(' skipped');

		$changed = $enabled + $disabled + $deleted;
		$message = $parts
			? implode(', ', $parts) . '.'
			: __('No modules were changed.');

		return response()->json(['success' => $changed > 0, 'message' => $message]);
	}

	/**
	 * Persist the per-module auto-update preference into module.json.
	 * POST admin/modules/auto_update  {module, auto: 0|1}
	 * Returns JSON {success, message}
	 */
	public function auto_update(Request $request)
	{
		$name = trim((string) $request->post('module'));
		$auto = (string) $request->post('auto');

		if ($name === '' || !in_array($auto, ['0', '1'], true)) {
			return response()->json(['success' => false, 'message' => __('Invalid auto update request.')]);
		}

		$module = Module::find($name);
		if (!$module) {
			return response()->json(['success' => false, 'message' => __('Module not found.')]);
		}

		$file = $module->getPath() . '/module.json';
		$json = json_decode((string) file_get_contents($file), true);
		if (!is_array($json)) {
			return response()->json(['success' => false, 'message' => __('Invalid module package: invalid module.json.')]);
		}

		$json['auto_update'] = $auto === '1';
		$encoded = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		if ($encoded === false || file_put_contents($file, $encoded) === false) {
			return response()->json(['success' => false, 'message' => __('Could not save the auto update preference.')]);
		}

		return response()->json([
			'success' => true,
			'message' => $auto === '1'
				? __('Auto update enabled for :module.', ['module' => $name])
				: __('Auto update disabled for :module.', ['module' => $name]),
		]);
	}

	/**
	 * Resolve a module by ?module=Name and render a confirm popup fragment;
	 * missing modules render the shared not-found fragment instead.
	 */
	private function moduleConfirmView(Request $request, string $view)
	{
		$name   = $request->get('module');
		$module = $name ? Module::find($name) : null;

		if (!$module) {
			return view('admin.modules.modal_error', ['name' => $name ?: '']);
		}

		return view($view, [
			'module'           => $module,
			'protectedModules' => $this->protectedModules,
		]);
	}

	/**
	 * Module store page + search AJAX + zip upload install.
	 */
	public function add_module(Request $request)
	{
		$page_title      = __('Add Module');
		$modules         = $this->getApiModules();
		$installed_module = null;
		$install_error    = null;
		$api_error        = $this->apiError;

		if ($request->isMethod('post')) {
			if ($request->has('search_apps') || $request->has('keyword') || $request->has('filter')) {
				$search = (string) $request->input('search_apps');
				$keyword = $request->input('keyword');
				$filter  = $request->input('filter');

				$query = [
					'search_apps' => $search,
					'keyword'     => $keyword,
					'filter'      => $filter,
				];

				// API only searches title/keywords/tags - author search is refined locally.
				if ($keyword === 'author') {
					$query['search_apps'] = null;
				}

				$modules    = $this->getApiModules($query);
				$modules    = $this->refineApiModules($modules, $search, $keyword, $filter);
				$api_error  = $this->apiError;

				return view('admin.modules.ajax_module', compact('modules', 'api_error'));
			}
		}

		return view('admin.modules.add_module', compact('page_title', 'modules', 'installed_module', 'install_error', 'api_error'));
	}

	/**
	 * Upload module page (placeholder - real upload UI + validation comes later).
	 */
	public function upload_module(Request $request)
	{
		$page_title = __('Upload Module');

		return view('admin.modules.upload_module', compact('page_title'));
	}

	/**
	 * AJAX install from store (download zip by package URL).
	 * Returns JSON {success, message, view_url}
	 */
	/**
	 * AJAX install from the store. With stage/token it advances the install
	 * one real step per request; without them it runs the whole pipeline (legacy).
	 * Returns JSON {success, stage, token, message, view_url?}
	 */
	public function install_module(Request $request)
	{
		$request->validate([
			'package'     => 'required|url',
			'module_name' => 'required|string',
			'stage'       => 'nullable|integer|min:1|max:8',
			'token'       => 'nullable|string|max:64',
		]);

		$staged = $request->has('stage');
		$token  = trim((string) $request->input('token'));
		$state  = null;

		try {
			if (!$staged) {
				// Legacy single request: run all 8 stages in one go.
				$state = $this->stageDownload($request);
				for ($stage = 2; $stage <= 8; $stage++) {
					$state = $this->advanceInstall($state, $stage);
				}
				$this->stateForget($state, $state['token'], true);
				return response()->json([
					'success'  => true,
					'message'  => $state['lastMessage'],
					'view_url' => route('modules.admin.index'),
				]);
			}

			$stage = (int) $request->input('stage');

			if ($stage === 1 && $token === '') {
				$state = $this->stageDownload($request);
				return response()->json([
					'success' => true,
					'stage'   => 1,
					'token'   => $state['token'],
					'message' => $state['lastMessage'],
				]);
			}

			$state = $this->stateLoad($token);
			if ($state === null) {
				throw new \Exception(__('Installation session expired. Please start again.'));
			}
			if ($stage !== ((int) $state['stageDone']) + 1) {
				throw new \Exception(__('Unexpected installation step.'));
			}

			$state   = $this->advanceInstall($state, $stage);
			$payload = [
				'success' => true,
				'stage'   => $stage,
				'token'   => $state['token'],
				'message' => $state['lastMessage'],
			];
			if ($stage === 8) {
				$payload['view_url'] = route('modules.admin.index');
				$this->stateForget($state, $state['token'], true);
			}
			return response()->json($payload);
		} catch (\Throwable $e) {
			$this->stateForget($state, $state['token'] ?? $token, true);
			return response()->json([
				'success' => false,
				'message' => $e->getMessage(),
				'stage'   => $staged ? (int) $request->input('stage') : 0,
			]);
		}
	}

	/**
	 * Count the installation on the store (best-effort, never affects the install result).
	 */
	private function reportInstall(string $slug): void
	{
		if ($slug === '') {
			return;
		}
		try {
			$url = preg_replace('/\/modules$/', '/install_report', config('constants.modules_api'));
			Http::withHeaders([
				'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0',
			])->timeout(3)->post($url, ['slug' => $slug]);
		} catch (\Throwable $e) {
			Log::warning('Modules install report failed.', ['slug' => $slug, 'error' => $e->getMessage()]);
		}
	}

	/**
	 * Live store package versions for every local module, cached 5 minutes.
	 * Returns [slug => version] or null when the store is unreachable.
	 */
	private function liveVersions(): ?array
	{
		$slugs = [];
		foreach (Module::all() as $module) {
			$alias = trim((string) $module->get('alias'));
			if ($alias !== '') {
				$slugs[$alias] = $alias;
			}
		}
		$slugs = array_values($slugs);
		if (!$slugs) {
			return [];
		}

		try {
			return Cache::remember('modules.live_versions', now()->addMinutes(5), function () use ($slugs) {
				$url = preg_replace('/\/modules$/', '/module_versions', config('constants.modules_api'));
				$response = Http::withHeaders([
					'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0',
				])->timeout(5)->post($url, ['slugs' => $slugs]);

				if ($response->failed()) {
					throw new \Exception('HTTP ' . $response->status());
				}
				$data = $response->json();
				if (!is_array($data) || empty($data['success']) || !is_array($data['versions'] ?? null)) {
					throw new \Exception(is_array($data) ? ($data['message'] ?? 'Invalid response payload.') : 'Invalid response payload.');
				}
				return array_map('strval', $data['versions']);
			});
		} catch (\Throwable $e) {
			Log::warning('Modules live versions request failed.', ['error' => $e->getMessage()]);
			return null;
		}
	}

	/**
	 * Update state for one module: available | current | unknown.
	 * available = store package version is newer than the local module.json version.
	 */
	private function updateState($module, ?array $versions): string
	{
		if ($versions === null) {
			return 'unknown';
		}
		$alias = trim((string) $module->get('alias'));
		$local = trim((string) $module->get('version'));
		$live  = $alias !== '' ? trim((string) ($versions[$alias] ?? '')) : '';
		if ($local === '' || $live === '') {
			return 'unknown';
		}
		return version_compare($live, $local, '>') ? 'available' : 'current';
	}

	/**
	 * AJAX install from an uploaded zip.
	 * Legacy mode (no `stage`): single request, runs stages 2-8 inline.
	 * Staged mode (`stage` + `token`): one real step per request, mirrors
	 * install_module so the Upload Module page can inspect (2-4) before install (5-8).
	 * Returns JSON {success, stage, token, message, package?, deps?, view_url?}
	 */
	public function install_upload_module(Request $request)
	{
		$staged = $request->has('stage');

		if ($staged) {
			$request->validate([
				'stage' => 'required|integer|min:1|max:8',
				'token' => 'nullable|string|max:64',
			]);
		}
		if (!$staged || (int) $request->input('stage') === 1) {
			$request->validate([
				'module_zip' => 'required|file|mimes:zip|max:204800',
			]);
		}

		$token = trim((string) $request->input('token'));
		$state = null;

		try {
			$dir = storage_path('app/modules');
			if (!File::isDirectory($dir)) {
				File::makeDirectory($dir, 0755, true);
			}

			if (!$staged) {
				// Legacy single request: upload + run all 8 stages in one go.
				$token   = (string) Str::uuid();
				$zipPath = $dir . '/' . $token . '.zip';
				$request->file('module_zip')->move($dir, $token . '.zip');

				$this->assertZipMagic($zipPath, true);

				$state = [
					'token'       => $token,
					'slug'        => '',
					'package'     => '',
					'zipPath'     => $zipPath,
					'moduleName'  => '',
					'json'        => [],
					'fresh'       => false,
					'stageDone'   => 1,
					'createdAt'   => time(),
					'lastMessage' => __('Package received.'),
				];

				for ($stage = 2; $stage <= 8; $stage++) {
					$state = $this->advanceInstall($state, $stage);
				}
				$this->stateForget($state, $token, true);

				return response()->json([
					'success'  => true,
					'message'  => $state['lastMessage'],
					'view_url' => route('modules.admin.index'),
				]);
			}

			$stage = (int) $request->input('stage');

			if ($stage === 1 && $token === '') {
				$this->sweepStaging($dir);
				$token   = (string) Str::uuid();
				$zipPath = $dir . '/' . $token . '.zip';
				$request->file('module_zip')->move($dir, $token . '.zip');

				$this->assertZipMagic($zipPath, true);

				$state = [
					'token'       => $token,
					'slug'        => '',
					'package'     => '',
					'zipPath'     => $zipPath,
					'moduleName'  => '',
					'json'        => [],
					'fresh'       => false,
					'stageDone'   => 1,
					'createdAt'   => time(),
					'lastMessage' => __('Package received.'),
				];
				$this->stateSave($state);

				return response()->json([
					'success' => true,
					'stage'   => 1,
					'token'   => $token,
					'message' => $state['lastMessage'],
				]);
			}

			$state = $this->stateLoad($token);
			if ($state === null) {
				throw new \Exception(__('Installation session expired. Please start again.'));
			}
			if ($stage !== ((int) $state['stageDone']) + 1) {
				throw new \Exception(__('Unexpected installation step.'));
			}

			$state   = $this->advanceInstall($state, $stage);
			$payload = [
				'success' => true,
				'stage'   => $stage,
				'token'   => $state['token'],
				'message' => $state['lastMessage'],
			];
			if ($stage === 2) {
				$payload['package'] = [
					'name'       => $state['moduleName'],
					'json'       => $state['json'],
					'rawJson'    => (string) ($state['rawJson'] ?? ''),
					'entries'    => (array) ($state['entries'] ?? []),
					'entryCount' => (int) ($state['entryCount'] ?? 0),
					'size'       => is_file($state['zipPath']) ? (int) filesize($state['zipPath']) : 0,
				];
			}
			if ($stage === 4) {
				$payload['deps'] = $this->installedRequires($state['json']['requires'] ?? []);
			}
			if ($stage === 8) {
				$payload['view_url'] = route('modules.admin.index');
				$this->stateForget($state, $state['token'], true);
			}
			return response()->json($payload);
		} catch (\Throwable $e) {
			$this->stateForget($state, $state['token'] ?? $token, true);
			return response()->json([
				'success' => false,
				'message' => $e->getMessage(),
				'stage'   => $staged ? (int) $request->input('stage') : 0,
			]);
		}
	}

	/**
	 * Installed state for every module.json requires[] entry (staged upload stage 4 payload).
	 */
	private function installedRequires($requires): array
	{
		$deps = [];
		if (is_array($requires)) {
			foreach ($requires as $key => $value) {
				$name = is_string($key) ? trim($key) : (is_string($value) ? trim($value) : '');
				$need = is_string($key) ? trim((string) $value) : '';
				if ($name === '') {
					continue;
				}
				$local = Module::find($name);
				$deps[] = [
					'name'              => $name,
					'need'              => $need,
					'installed'         => (bool) $local,
					'installed_version' => $local ? trim((string) $local->get('version')) : '',
				];
			}
		}
		return $deps;
	}

	/**
	 * Drop abandoned staged uploads (state + zip) older than one hour.
	 */
	private function sweepStaging(string $dir): void
	{
		foreach (['*.zip', '*.json'] as $pattern) {
			foreach (File::glob($dir . '/' . $pattern) as $file) {
				if (@filemtime($file) < time() - 3600) {
					@unlink($file);
				}
			}
		}
	}

	/**
	 * Run one install stage (2-8) and persist the new progress.
	 * Stages throw on failure; state stays at the last completed step.
	 */
	private function advanceInstall(array $state, int $stage): array
	{
		switch ($stage) {
			case 2: $state = $this->stageValidate($state); break;
			case 3: $state = $this->stageCompatibility($state); break;
			case 4: $state = $this->stageDependencies($state); break;
			case 5: $state = $this->stageExtract($state); break;
			case 6: $state = $this->stageRegister($state); break;
			case 7: $state = $this->stageRefreshCache($state); break;
			case 8: $state = $this->stageFinalize($state); break;
			default: throw new \Exception(__('Unexpected installation step.'));
		}
		$state['stageDone'] = $stage;
		$this->stateSave($state);
		return $state;
	}

	private function statePath(string $token): string
	{
		return storage_path('app/modules/' . $token . '.json');
	}

	private function stateSave(array $state): void
	{
		File::put($this->statePath($state['token']), json_encode($state, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
	}

	private function stateLoad(string $token): ?array
	{
		if (!preg_match('/^[A-Za-z0-9\-]{8,64}$/', $token)) {
			return null;
		}
		$path  = $this->statePath($token);
		$state = File::isFile($path) ? json_decode((string) File::get($path), true) : null;
		if (!is_array($state) || !isset($state['stageDone'], $state['zipPath'], $state['token'])) {
			@unlink($path);
			return null;
		}
		if (time() - (int) ($state['createdAt'] ?? 0) > 900) {   // 15 min expiry
			$this->stateForget($state, $token, true);
			return null;
		}
		return $state;
	}

	private function stateForget(?array $state, string $token = '', bool $deleteZip = false): void
	{
		$token = $state['token'] ?? $token;
		if ($token === '') {
			return;
		}
		if ($deleteZip && !empty($state['zipPath']) && is_file($state['zipPath'])) {
			@unlink($state['zipPath']);
		}
		@unlink($this->statePath($token));
	}

	/**
	 * Stage 1: hardened download -> staging zip + install state.
	 */
	private function stageDownload(Request $request): array
	{
		$package   = (string) $request->input('package');
		$slug      = trim((string) $request->input('module_name'));
		$parsed    = parse_url($package);
		$storeHost = strtolower((string) parse_url((string) config('constants.modules_api'), PHP_URL_HOST));
		$scheme    = strtolower($parsed['scheme'] ?? '');
		$host      = strtolower($parsed['host'] ?? '');

		if ($scheme !== 'https' || $host === '' || $host !== $storeHost) {
			throw new \Exception(__('Invalid package source: downloads are only allowed from :host.', ['host' => $storeHost]));
		}

		$dir = storage_path('app/modules');
		if (!File::isDirectory($dir)) {
			File::makeDirectory($dir, 0755, true);
		}

		$token   = (string) Str::uuid();
		$zipPath = $dir . '/' . $token . '.zip';

		try {
			$response = Http::connectTimeout(10)->timeout(60)->sink($zipPath)->get($package);
		} catch (\Throwable $e) {
			@unlink($zipPath);
			throw new \Exception(__('Could not download the package: :err', ['err' => $e->getMessage()]));
		}
		if ($response->failed()) {
			@unlink($zipPath);
			throw new \Exception(__('Package download failed (HTTP :code).', ['code' => $response->status()]));
		}
		if (!is_file($zipPath) || filesize($zipPath) === 0) {
			@unlink($zipPath);
			throw new \Exception(__('The downloaded package is empty.'));
		}
		if (filesize($zipPath) > 204800 * 1024) {
			@unlink($zipPath);
			throw new \Exception(__('The package exceeds the maximum allowed size.'));
		}
		$this->assertZipMagic($zipPath, true);

		$state = [
			'token'       => $token,
			'slug'        => $slug,
			'package'     => $package,
			'zipPath'     => $zipPath,
			'moduleName'  => '',
			'json'        => [],
			'fresh'       => false,
			'stageDone'   => 1,
			'createdAt'   => time(),
			'lastMessage' => __('Downloaded :size from :host.', [
				'size' => $this->humanSize((int) filesize($zipPath)),
				'host' => $host,
			]),
		];
		$this->stateSave($state);
		return $state;
	}

	/**
	 * Stage 2: ZIP structure + root manifest + already-installed guard.
	 */
	private function stageValidate(array $state): array
	{
		$zip = new ZipArchive;
		if ($zip->open($state['zipPath']) !== true) {
			throw new \Exception(__('Unable to open the module zip file.'));
		}

		try {
			if ($zip->numFiles === 0) {
				throw new \Exception(__('The package contains no files.'));
			}
			$entries = [];
			for ($i = 0; $i < $zip->numFiles; $i++) {
				$entry = str_replace('\\', '/', $zip->getNameIndex($i));
				if (str_contains($entry, '..') || str_starts_with($entry, '/')) {
					throw new \Exception(__('Invalid module zip file.'));
				}
				if (count($entries) < 400) {
					$entries[] = $entry;
				}
			}

			$moduleName = explode('/', trim((string) $zip->getNameIndex(0), '/'))[0];
			if ($moduleName === '' || !preg_match('/^[A-Za-z0-9_][A-Za-z0-9_.\-]*$/', $moduleName)) {
				throw new \Exception(__('Invalid module folder name in the package.'));
			}
			if (Module::find($moduleName)) {
				throw new \Exception(__('The module ":name" is already installed.', ['name' => $moduleName]));
			}

			$rawJson = $this->zipModuleJson($zip, $moduleName);
			if ($rawJson === null) {
				throw new \Exception(__('Invalid module package: module.json not found.'));
			}
			$json = json_decode((string) $rawJson, true);
			if (!is_array($json)) {
				throw new \Exception(__('Invalid module package: invalid module.json.'));
			}
			$count = $zip->numFiles;
		} finally {
			$zip->close();
		}

		$state['moduleName']  = $moduleName;
		$state['json']        = $json;
		$state['rawJson']     = (string) $rawJson;
		$state['entries']     = $entries;
		$state['entryCount']  = $count;
		$state['lastMessage'] = __('ZIP verified: :name (:count files), module.json is valid.', [
			'name'  => $moduleName,
			'count' => $count,
		]);
		return $state;
	}

	/**
	 * Stage 3: PHP / W3CMS requirements from the parsed manifest.
	 */
	private function stageCompatibility(array $state): array
	{
		$errors = $this->requirementErrors($state['json']);
		if ($errors) {
			throw new \Exception(implode(' ', $errors));
		}

		$php   = trim((string) ($state['json']['requires_php'] ?? ''));
		$w3    = trim((string) ($state['json']['required_w3cms_version'] ?? ''));
		$parts = [];
		if ($php !== '') {
			$parts[] = 'PHP ' . PHP_VERSION . ' >= ' . $php;
		}
		if ($w3 !== '') {
			$parts[] = 'W3CMS ' . config('constants.version') . ' >= ' . $w3;
		}
		$state['lastMessage'] = $parts
			? implode('; ', $parts) . '.'
			: __('No PHP or W3CMS constraints declared.');
		return $state;
	}

	/**
	 * Stage 4: module.json requires[] must be installed (and new enough) locally.
	 */
	private function stageDependencies(array $state): array
	{
		$requires = $state['json']['requires'] ?? [];
		if (!is_array($requires) || !$requires) {
			$state['lastMessage'] = __('No module dependencies declared.');
			return $state;
		}

		$missing = [];
		foreach ($requires as $key => $value) {
			$name = is_string($key) ? trim($key) : (is_string($value) ? trim($value) : '');
			$need = is_string($key) ? trim((string) $value) : '';
			if ($name === '') {
				continue;
			}
			$local = Module::find($name);
			if (!$local) {
				$missing[] = $name;
				continue;
			}
			$have = trim((string) $local->get('version'));
			if ($need !== '' && ($have === '' || version_compare($have, $need, '<'))) {
				$missing[] = $name . ' (' . ($have !== '' ? $have : '?') . ' < ' . $need . ')';
			}
		}
		if ($missing) {
			throw new \Exception(__('Missing or outdated required modules: :list', ['list' => implode(', ', $missing)]));
		}
		$state['lastMessage'] = __('All :count required module dependencies are satisfied.', ['count' => count($requires)]);
		return $state;
	}

	/**
	 * Stage 5: extract into Modules/ with rollback of brand-new folders.
	 */
	private function stageExtract(array $state): array
	{
		$extractPath  = base_path('Modules/');
		$freshInstall = !File::isDirectory($extractPath . $state['moduleName']);

		$zip = new ZipArchive;
		if ($zip->open($state['zipPath']) !== true) {
			throw new \Exception(__('Unable to open the module zip file.'));
		}
		$extracted = $zip->extractTo($extractPath);
		$count     = $zip->numFiles;
		$zip->close();

		if (!$extracted || !File::exists($extractPath . $state['moduleName'] . '/module.json')) {
			if ($freshInstall && File::isDirectory($extractPath . $state['moduleName'])) {
				File::deleteDirectory($extractPath . $state['moduleName']);
			}
			throw new \Exception(__('Could not extract the module package.'));
		}

		@unlink($state['zipPath']);
		$state['fresh']       = $freshInstall;
		$state['lastMessage'] = __('Extracted :count files to /Modules/:name.', [
			'count' => $count,
			'name'  => $state['moduleName'],
		]);
		return $state;
	}

	/**
	 * Stage 6: enable + migrate; failure rolls a fresh module back out.
	 */
	private function stageRegister(array $state): array
	{
		$moduleName = $state['moduleName'];
		if (!Module::find($moduleName)) {
			throw new \Exception(__('Invalid module package: module.json not found.'));
		}

		Module::enable($moduleName);

		$exit = Artisan::call('module:migrate', ['module' => $moduleName]);
		if ($exit !== 0) {
			$output = Str::limit(Artisan::output(), 400);
			Module::disable($moduleName);
			if ($state['fresh']) {
				File::deleteDirectory(base_path('Modules/' . $moduleName));
			}
			throw new \Exception(__('Migration failed: :out', ['out' => $output]));
		}

		$state['lastMessage'] = __('Module enabled and database migrated.');
		return $state;
	}

	/**
	 * Stage 7: real cache refresh (install state is file-based so it survives).
	 */
	private function stageRefreshCache(array $state): array
	{
		Artisan::call('config:clear');
		Artisan::call('route:clear');
		Artisan::call('cache:clear');
		$state['lastMessage'] = __('Configuration, route and application caches cleared.');
		return $state;
	}

	/**
	 * Stage 8: seed (fresh only) + store install report + final verification.
	 */
	private function stageFinalize(array $state): array
	{
		$moduleName = $state['moduleName'];
		$warnings   = [];

		if ($state['fresh']) {
			$seederPath = base_path('Modules/' . $moduleName . '/Database/Seeders/' . Str::studly($moduleName) . 'DatabaseSeeder.php');
			if (File::exists($seederPath)) {
				$exit = Artisan::call('module:seed', ['module' => $moduleName]);
				if ($exit !== 0) {
					$warnings[] = __('Seeder failed: :out', ['out' => Str::limit(Artisan::output(), 300)]);
				}
			}
		}

		$this->reportInstall($state['slug']);

		if (!Module::find($moduleName) || !Module::isEnabled($moduleName)) {
			throw new \Exception(__('The module could not be registered after installation.'));
		}

		$state['lastMessage'] = __('Module installed successfully.') . ($warnings ? ' ' . implode(' ', $warnings) : '');
		return $state;
	}

	/**
	 * Requirement violations for a parsed module.json (empty array = ok).
	 */
	private function requirementErrors(array $json): array
	{
		$errors = [];

		$requiresPhp = trim((string) ($json['requires_php'] ?? ''));
		if ($requiresPhp !== '' && version_compare(PHP_VERSION, $requiresPhp, '<')) {
			$errors[] = __('This module requires PHP :req or higher. Your server runs PHP :cur.', [
				'req' => $requiresPhp,
				'cur' => PHP_VERSION,
			]);
		}

		$requiresW3cms = trim((string) ($json['required_w3cms_version'] ?? ''));
		$currentW3cms   = (string) config('constants.version');
		if ($requiresW3cms !== '' && version_compare($currentW3cms, $requiresW3cms, '<')) {
			$errors[] = __('This module requires W3CMS :req or higher. Your website runs W3CMS :cur.', [
				'req' => $requiresW3cms,
				'cur' => $currentW3cms,
			]);
		}

		return $errors;
	}

	private function humanSize(int $bytes): string
	{
		$units = ['B', 'KB', 'MB', 'GB'];
		$i     = 0;
		$n     = (float) $bytes;
		while ($n >= 1024 && $i < 3) {
			$n /= 1024;
			$i++;
		}
		return round($n, $i ? 1 : 0) . ' ' . $units[$i];
	}

	/**
	 * ZIP local-header magic check ("PK").
	 * @throws \Exception
	 */
	private function assertZipMagic(string $path, bool $unlinkOnFail = false): void
	{
		if (!is_file($path) || (string) file_get_contents($path, false, null, 0, 2) !== 'PK') {
			if ($unlinkOnFail) {
				@unlink($path);
			}
			throw new \Exception(__('The file is not a valid ZIP package.'));
		}
	}

	/**
	 * Read the root module.json out of an open module zip.
	 * Returns null when the entry is missing.
	 */
	private function zipModuleJson(ZipArchive $zip, string $moduleName): ?string
	{
		$want = $moduleName . '/module.json';
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$entry = str_replace('\\', '/', (string) $zip->getNameIndex($i));
			if ($entry === $want) {
				return $zip->getFromIndex($i);
			}
		}
		return null;
	}

	/**
	 * Enforce module.json requirements before extraction (store + upload installs).
	 * Missing file / invalid JSON / unmet requires_php / required_w3cms_version
	 * abort the install; fields that are absent impose no requirement.
	 * @throws \Exception
	 */
	private function validateModuleRequirements(ZipArchive $zip, string $moduleName, string $zipPath): void
	{
		$abort = function (string $message) use ($zip, $zipPath) {
			$zip->close();
			@unlink($zipPath);
			throw new \Exception($message);
		};

		$rawJson = $this->zipModuleJson($zip, $moduleName);
		if ($rawJson === null) {
			$abort(__('Invalid module package: module.json not found.'));
		}

		$json = json_decode((string) $rawJson, true);
		if (!is_array($json)) {
			$abort(__('Invalid module package: invalid module.json.'));
		}

		$errors = $this->requirementErrors($json);
		if ($errors) {
			$abort($errors[0]);
		}
	}

	/**
	 * Fetch module list from remote API (same shape as themes API).
	 * Accepts an array of query params (search_apps, keyword, filter) or a search string.
	 */
	private function getApiModules($query = [])
	{
		$this->apiError = null;

		if (!is_array($query)) {
			$query = ['search_apps' => $query];
		}

		$query = array_filter($query, function ($value) {
			return $value !== null && trim((string) $value) !== '';
		});

		try {
			$response = Http::withHeaders([
				'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0',
			])->get(config('constants.modules_api'), $query);

			if ($response->failed()) {
				throw new \Exception('HTTP ' . $response->status());
			}

			$modules = optional($response->object())->modules;
			if (!is_array($modules)) {
				throw new \Exception('Invalid response payload.');
			}
		} catch (\Throwable $e) {
			$this->apiError = $e->getMessage();
			Log::warning('Modules API request failed.', ['query' => $query, 'error' => $e->getMessage()]);
			$modules = null;
		}

		return $this->checkInstalledModules($modules);
	}

	/**
	 * Local refinement until the store API honours keyword/filter params.
	 * keyword: all|name|author|tag (author is API-unsupported -> local LIKE)
	 * filter: featured|popular|recommended|newest|updated
	 */
	private function refineApiModules($modules, $search = '', $keyword = null, $filter = null)
	{
		if (!is_array($modules) || empty($modules)) {
			return $modules;
		}

		$search = trim((string) $search);

		if ($search !== '' && in_array($keyword, ['name', 'author', 'tag'], true)) {
			$needle = mb_strtolower($search);
			$modules = array_values(array_filter($modules, function ($module) use ($needle, $keyword) {
				if ($keyword === 'author') {
					$author   = $module->author ?? null;
					$author   = is_object($author) ? ($author->name ?? '') : (string) $author;
					$haystack = $author . ' ' . ($module->author_email ?? '');
				} elseif ($keyword === 'tag') {
					$haystack = implode(' ', (array) ($module->tags ?? []));
				} else {
					$haystack = (string) ($module->title ?? '');
				}

				return str_contains(mb_strtolower($haystack), $needle);
			}));
		}

		if ($filter === 'newest' || $filter === 'updated') {
			$key = $filter === 'newest' ? 'launching_date' : 'updated_at';
			usort($modules, function ($a, $b) use ($key) {
				return (strtotime((string) ($b->$key ?? '')) ?: 0) <=> (strtotime((string) ($a->$key ?? '')) ?: 0);
			});
		} elseif ($filter === 'popular') {
			// Sorted by the store's download counter (exposed as "downloads" in api_modules).
			usort($modules, function ($a, $b) {
				return ((int) ($b->downloads ?? 0)) <=> ((int) ($a->downloads ?? 0));
			});
		} elseif (in_array($filter, ['featured', 'recommended'], true)) {
			// Modules without tags pass through (they stay visible in every tag chip).
			$matched = array_values(array_filter($modules, function ($module) use ($filter) {
				$tags = array_values(array_filter(array_map('trim', (array) ($module->tags ?? []))));

				return empty($tags) || in_array($filter, $tags, true);
			}));

			// No module is curated for this chip yet -> keep the full list instead of an empty grid.
			$modules = empty($matched) ? $modules : $matched;
		}

		return $modules;
	}

	/**
	 * Fetch one module's full detail from the remote app_detail API.
	 * Returns enriched module array, or null + sets $this->apiError.
	 */
	private function fetchAppDetail(string $slug)
	{
		$this->apiError = null;

		try {
			$url = preg_replace('/\/modules$/', '/app_detail', config('constants.modules_api'));

			$response = Http::withHeaders([
				'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0',
			])->get($url, ['slug' => $slug, 'type' => 'P']);

			if ($response->failed()) {
				throw new \Exception('HTTP ' . $response->status());
			}

			$data = $response->json();
			if (!is_array($data) || empty($data['success']) || empty($data['module'])) {
				throw new \Exception($data['message'] ?? 'Invalid response payload.');
			}

			$module = $data['module'];
			$module['installed']        = (bool) Module::find($module['slug'] ?? $slug);
			$module['updated_at_human'] = !empty($module['updated_at'])
				? \Illuminate\Support\Carbon::parse($module['updated_at'])->diffForHumans()
				: '';

			return $module;
		} catch (\Throwable $e) {
			$this->apiError = $e->getMessage();
			Log::warning('Modules app_detail API request failed.', ['slug' => $slug, 'error' => $e->getMessage()]);
			return null;
		}
	}

	/**
	 * Install-confirm modal content (AJAX-loaded into #AjaxModalBoxXl).
	 */
	public function install_confirm(Request $request)
	{
		$module = $this->fetchAppDetail((string) $request->input('slug'));

		return view('admin.modules.install_confirm', [
			'module'    => $module,
			'api_error' => $this->apiError,
		]);
	}

	/**
	 * Module details offcanvas body (AJAX-loaded into #modDetails).
	 */
	public function module_details(Request $request)
	{
		$module = $this->fetchAppDetail((string) $request->input('slug'));

		return view('admin.modules.module_details', [
			'module'    => $module,
			'api_error' => $this->apiError,
		]);
	}

	/**
	 * Mark each API module as installed + enabled status.
	 */
	private function checkInstalledModules($modules)
	{
		if (!is_null($modules) && !empty($modules)) {
			foreach ($modules as $key => $value) {
				$local            = Module::find($value->slug);
				$value->installed = (bool) $local;
				$value->enabled   = $local ? $local->isEnabled() : false;
				$modules[$key]    = $value;
			}

			return $modules;
		}

		return array();
	}
}
