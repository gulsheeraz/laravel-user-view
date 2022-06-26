<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use DataTables;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users.index');
    }

    /**
    * Show the users list
    */
    public function data(Request $request)
    {
        if ($request->ajax()) {

            $data = User::latest()->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('department_id', function($row){
                    return optional($row->department)->name ?? '';
                })
                ->addColumn('roles', function($row){
                    return $row->getRoles();
                })
                ->addColumn('action', function($row){
                    return view('users.actions', compact('row'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
    * Show the user detail 
    */
    public function show(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        $user = User::findOrFail($data['id']);

        return view('users.detail', compact('user'))->render();
    }
}
