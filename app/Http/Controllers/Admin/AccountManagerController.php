<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AccountManagerRequestsDataTable;
use App\Http\Controllers\Controller;
use App\Models\AccountManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountManagerController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param AccountManagerRequestsDataTable $auctionDataTable
     * @return Application|Factory|View
     */
    public function index(AccountManagerRequestsDataTable $accountManagerRequestsDataTable)
    {
        return $accountManagerRequestsDataTable->render('admin.components.account-manager.datatable');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $account_manager = new AccountManager();
        
        $account_managers = User::where('is_admin' , 1)->pluck("email", "id")->toArray();
        $account_managers[0] = 'Choose Seller';
        ksort($account_managers);

        return view('admin.components.account-manager.create', compact('account_manager','account_managers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, AccountManager::$cast);
        if ($validator->fails()) {
            return redirect()->route('account-managers.create')->withErrors($validator)->withInput();
        }
        AccountManager::create($inputs);
        return redirect()->route('account-managers.index')->with(['success' => 'Account Manager Request ' . __("messages.add")]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account_manager = AccountManager::findOrFail($id);
        return view('admin.components.account-manager.show', compact('account_manager'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account_manager = AccountManager::findOrFail($id);

        $account_managers = User::where('is_admin' , 1)->pluck("email", "id")->toArray();
        $account_managers[0] = 'Choose Seller';
        ksort($account_managers);

        return view('admin.components.account-manager.edit', compact('account_manager','account_managers'));
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
        $inputs = $request->all();
        $auction = AccountManager::find($id);
        $auction->update($inputs);
        return redirect()->route('account-managers.index')->with(['success' => 'Account Manager Request ' . __("messages.update")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account_manager = AccountManager::findOrFail($id);
        $account_manager->delete();
        return redirect()->back()->with(['success' => 'Account Manager Request ' . __("messages.delete")]);
    }
}
