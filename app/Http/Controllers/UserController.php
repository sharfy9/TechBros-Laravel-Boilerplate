<?php

namespace App\Http\Controllers;

use Auth;
use Session;

use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Contracts\Activity;
use PragmaRX\Google2FALaravel\SupportAuthenticator;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(Auth::user()->cannot("user.view.list"))
            abort(403);

        // if(Auth::user()->hasRole(['Super Admin']))
        //     $data = User::get();
        // else
        //     $data = User::where('vendor_id', Auth::user()->vendor_id)->get();
        $admins = Role::findByName('Super Admin')->users->pluck('id')->toArray();
        $data = User::whereNotIn('id', $admins)->get();

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('sn', function ($data) {
                    return "";
                })
                ->addColumn('active', function ($data) {
                    $html = '<div class="custom-control custom-switch ml-1"><input type="checkbox" ';
                    $html .= $data->active ? 'checked' : '';
                    $html .= ' class="custom-control-input" id="activeSwitch" onchange="return activeStatus('.$data->id.',\''.$data->active.'\',\'/user/active\');" /><label  class="custom-control-label" for="activeSwitch"></label></div>';

                    return ($data->id == Auth::user()->id) ? "&nbsp;" : $html;
                })
                ->addColumn('name', function ($data) {
                    $html = "<a href='";
                    $html .= url("user/" . $data->id);
                    $html .= "'>{$data->name}</a>";
                    if($data->vendor_id && $data->id == $data->vendor->owner_id)
                    $html .= " <span class='text-info'>Owner</span>";
                    return $html;
                })
                ->addColumn('vendor', function ($data) {
                    if($data->vendor_id)
                    {
                        $html = "<a href='";
                        $html .= url("vendor/" . $data->vendor_id);
                        $html .= "'>{$data->vendor->name}</a>";
                        return $html;
                    }
                    else
                    return "";
                })
                ->addColumn('permissions', function ($data) {
                    return $data->getAllPermissions()->count() . "/" . Permission::all()->count();
                })
                ->addColumn('action', function ($data) {
                    $button = '';
                    //blueprint
                    if($data->id != Auth::user()->id)
                    {
                        if((Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Super Admin')))
                        {
                            if(!$data->google2fa_secret)
                                $button .= '<a type="button" href="2fa/disable/'.$data->id.'" class="btn btn-warning btn-icon btn-sm "><i class="fas fa-unlock-alt"></i></a>&nbsp;';
                            $button .= '<a type="button" href="user/loginas/'.$data->id.'" class="btn btn-primary btn-icon btn-sm "><i class="fas fa-sign-in-alt"></i></a>&nbsp;';
                        }
                        if (Auth::user()->can("user.edit"))
                            $button .= '<a type="button" href="/user/' . $data->id . '/edit" class="btn btn-success btn-icon btn-sm "><i class="fas fa-edit"></i></a>&nbsp;';
                        if (Auth::user()->can("user.delete"))
                            $button .= '<form action="' . route('user.destroy', $data) . '" method="post" style="display:inline-block;" class="delete-form"> <input type="hidden" name="_token" value="' . csrf_token() . '"> <input type="hidden" name="_method" value="delete"> <button type="button" class="btn btn-danger btn-icon btn-sm delete-button" onclick="confirm(\'' . __('Are you sure you want to delete this record?') . '\') ? this.parentElement.submit() : \'\'"><i class="fas fa-trash-alt"></i></button></form>';
                    }
                    else
                        $button .= '<a type="button" href="'.route('profile.edit').'" class="btn btn-success btn-icon btn-sm " ><i class="fas fa-user"></i></a>';
                    return $button;
                })
                ->rawColumns(['name','active','action'])
                ->make(true);
        }
        else
            return view('users.index');
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if(Auth::user()->cannot("user.add"))
        abort(403);
        // $vendor = Vendor::get();
        return view('users.create')->with([
            // 'vendor' => $vendor,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        if(Auth::user()->cannot("user.add"))
            abort(403);
        // if((!Auth::user()->vendor_id || Auth::user()->vendor->users->count() >= Auth::user()->vendor->allowed_users) && !Auth::user()->hasRole('Super Admin') )
        //     return redirect()->back()->withErrors('You have reached your user creation limit. Please contact administrator to increase limit.')->withInput();
        // if(isset($request->vendor_id))
        //     $vendor_id = ($request->vendor_id > 0) ? $request->vendor_id : null;
        // else
        //     $vendor_id = Auth::user()->vendor_id;

        $request->validate([
            'permissions' => 'nullable|array|exists:permissions,id',
            'phone' => 'required|numeric|digits:11|unique:users',
            'balance' => 'required|numeric',
        ]);

        $id = $model->create($request->merge([
            'password' => Hash::make($request->get('password')),
            // 'vendor_id' => $vendor_id,
        ])->toArray())->id;
        User::find($id)->permissions()->sync($request->permissions);

        // return redirect()->route('user.edit', $id)->with(['successMsg' => __('Record successfully created.')]);
        return redirect()->back()->with(['successMsg' => __('Record successfully created.')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // if(Auth::user()->cannot("user.view"))
        // abort(403);

        $data = User::find($id);
        // if($data->vendor_id != Auth::user()->vendor_id && !Auth::user()->hasRole('Super Admin'))
        // abort(403);

        return view('users.show')->with([
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if(Auth::user()->cannot("user.edit"))
        abort(403);

        if(Auth::user()->id == $id && !Auth::user()->hasRole('Super Admin'))
        abort(403);

        $data = User::find($id);
        if(!Auth::user()->hasRole('Super Admin') && $data->hasRole('Super Admin'))
        abort(403);

        // if($data->vendor_id != Auth::user()->vendor_id && !Auth::user()->hasRole('Super Admin'))
        //     abort(403);
        // $vendor = Vendor::get();
        return view('users.edit')->with([
            'data' => $data,
            'permissions' => Permission::all(),
            // 'vendor' => $vendor
        ]);
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        if(Auth::user()->cannot("user.edit"))
        abort(403);

        if(Auth::user()->id == $user->id && !Auth::user()->hasRole('Super Admin'))
        abort(403);

        $request->validate([
            'permissions' => 'nullable|array|exists:permissions,id',
            'phone' => 'required|numeric|digits:11|unique:users,id,'.$user->id.',phone',
            'phone' => 'required|numeric',
            'active' => 'nullable',
        ]);
        // dd($request->all());
        // if($user->vendor_id != Auth::user()->vendor_id && !Auth::user()->hasRole('Super Admin'))
        // abort(403);

        // if(isset($request->vendor_id) && Auth::user()->hasRole('Super Admin'))
        //     $user->update([
        //         'vendor_id' => $request->vendor_id
        //     ]);
        $user->permissions()->sync($request->permissions);
        $hasPassword = $request->get('password');
        $user->update(
            $request->merge([
                'password' => Hash::make($request->get('password')),
                'active' => (isset($request->active) && $request->active) ? 1 : 0,
                ])->except([$hasPassword ? '' : 'password'])
            );

        return redirect()->route('user.edit', $user)->with(['successMsg' => __('Record successfully updated.')]);
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        // if(Auth::user()->cannot("user.delete"))
        // abort(403);
        // if($user->vendor_id != Auth::user()->vendor_id && !Auth::user()->hasRole('Super Admin'))
        // abort(403);

        // // if($user->vendor->owner_id == $user->id)
        // // return redirect()->back()->withErrors(["Can't delete owner account. Change vendor owner or delete vendor."]);
        // if($user->hasRole('Super Admin'))
        //     return redirect()->back()->withErrors(["Can't delete Administrator account."]);

        $user->syncPermissions([]);
        $user->syncRoles([]);
        $user->delete();

        return redirect()->route('user.index')->with(['warningMsg' => __('Record successfully deleted.')]);
    }

    public function active(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:users,id',
            'status' => 'required|boolean'
        ]);
        $data = User::find($request->id);
        $data->active = !$request->status;
        if($data->save())
        return json_encode(['type' => 'success', 'icon' => 'fas fa-check-circle', 'msg' => 'Active status changed successfully.']);
        else
        return json_encode(['type' => 'danger', 'icon' => 'fas fa-exclamation-circle', 'msg' => 'Could not change active status.']);

    }
    public function loginAs(Request $request, $id = null)
    {

        if (Session::get('hasClonedUser')) {
            Auth::loginUsingId(Session::remove('hasClonedUser'));
            Session::remove('hasClonedUser');
            return redirect()->back();
        }

        if (Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Super Admin')) {
            $user = User::find($id);
            if($user->hasRole('Super Admin'))
            {
                activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->log(Auth::user()->name." tried to login as Administrator");

                return redirect()->back()->withErrors(["Can't login as Administrator"])->withInput();
            }
            activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->log(Auth::user()->name . ' Logged in as: '.$user->name);

            Session::put('hasClonedUser', Auth::id());
            $authenticator = app(Authenticator::class)->boot($request);
            Auth::loginUsingId($id);
            $authenticator->login();

            return redirect("/dashboard")->with(['warningMsg' => __('Logged in as: '.Auth::user()->name)]);;
        }
        else
            return redirect()->back()->withErrors("You do not have permission to for this action.");

    }

}
