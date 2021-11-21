<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\NotificationsRepo;
use App\Http\Requests\NotificationsRequest;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    protected $repo;

    public function __construct(NotificationsRepo $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $data = $this->repo->getAll();
        $users = User::where('type', '!=', 'admin')->get();
        return view('admin.Notifications.index', compact('data','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationsRequest $request)
    {
        try {
            $data = $request->all();
           $this->repo->create($data);
            session()->flash('Add', __('admin/app.success_message'));
            return redirect($this->modelName);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('app.some_thing_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
