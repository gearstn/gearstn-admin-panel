<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubscriptionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SubscriptionsDataTable $subscriptionsDataTable
     * @return Application|Factory|View
     */
    public function index(SubscriptionsDataTable $subscriptionsDataTable)
    {
        return $subscriptionsDataTable->render('admin.components.subscription.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subscription = new Subscription();
        $subscription->details = [];
        $roles = Role::all()->pluck('name','id');
        return view('admin.components.subscription.create', compact('subscription','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $details_result = [];
        foreach ($inputs['details'] as $details) {
            $details_result[$details['key']] = $details['value'] ;
        }
        $inputs['details'] = json_encode($details_result);
        $validator = Validator::make($inputs, Subscription::$cast);
        if ($validator->fails()) {
            return redirect()->route('subscriptions.create')->withErrors($validator)->withInput();
        }
        $subscription = Subscription::create($inputs);

        return redirect()->route('subscriptions.index')->with(['success' => 'Subscription ' . __("messages.add")]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('admin.components.subscription.show', compact('subscription'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->details = json_decode($subscription->details, true);
        $roles = Role::all()->pluck('name','id');
        return view('admin.components.subscription.edit', compact('subscription','roles'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        foreach ($inputs['details'] as $details) {
            $details_result[$details['key']] = $details['value'] ;
        }
        $inputs['details'] = json_encode($details_result);
        
        $subscription = Subscription::find($id);
        $subscription->update($inputs);
        return redirect()->route('subscriptions.index')->with(['success' => 'Subscription ' . __("messages.update")]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();
        return redirect()->back()->with(['success' => 'Subscription ' . __("messages.delete")]);
    }
}
