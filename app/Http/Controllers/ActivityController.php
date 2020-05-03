<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index($mode = 'my')
    {
        if (Auth::user()->can("activity.view.own") && $mode == 'my')
        {
            $data = Auth::user()->actions;
        }
        elseif(Auth::user()->can("activity.view.user") && User::find($mode))
        {
            $data = User::find($mode)->actions;
        }
        elseif (Auth::user()->can("activity.view.all") && $mode == 'all')
        {
            $users = (Auth::user()->vendor_id) ? Auth::user()->vendor->users->pluck('id')->toArray() : [Auth::user()->id];
            $data = (Auth::user()->hasRole("Super Admin")) ? Activity::all() : Activity::whereIn('causer_id', $users)->get();
        }
        else
            abort(403);

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('sn', function ($data) {
                    return "";
                })
                ->addColumn('time', function ($data) {
                    return $data->created_at->format('d/m/y h:i:sA');
                })
                ->addColumn('id', function ($data) {
                    return "#$data->id";
                })
                ->addColumn('subject', function ($data) {
                    return "{$data->subject_type} : {$data->subject_id}";
                })
                ->addColumn('causer', function ($data) {
                    if($data->causer)
                    {
                        $html = "<a href='";
                        $html .= url("user/" . $data->causer_id);
                        $html .= "'>{$data->causer->name}</a>";
                        return $html;
                    }
                    else
                    return "Deleted User";
                })
                ->rawColumns(['causer'])
                ->make(true);
        } else
            return view('activity', ['mode' => $mode]);
    }}
