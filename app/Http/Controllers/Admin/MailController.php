<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MailsDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\MarketingMailJob;
use App\Models\Mail;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MailsDataTable $mailsDataTable
     * @return Application|Factory|View
     */
    public function index(MailsDataTable $mailsDataTable)
    {
        return $mailsDataTable->render('admin.components.mail.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $mail = new Mail();
//        $Allcategories = Category::all();
        $categories = [
            null,
            1 => 'distributor',
            2 => 'contractor'
        ];
//        $categories[0] = null;
//        foreach ($Allcategories as $cat)
//            $categories[$cat->id] = $cat->name;

        $users = User::all();
        $emails = [];
        $emails[0] = null;
        foreach ($users as $user)
            $emails[$user->id] = $user->email;
        return view('admin.components.mail.create', compact('mail', 'categories', 'emails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        if($inputs['datetime'] == null){
            $inputs['sent_time'] = Carbon::now();
            $inputs['scheduled'] = 0;
        }
        else{
            $inputs['sent_time'] = Carbon::parse($inputs['datetime']);;
            $inputs['scheduled'] = 1;
        }
        $emails = $inputs['receivers'];
        $inputs['receivers'] = json_encode($inputs['receivers']);
        $validator = Validator::make($inputs, Mail::$cast);
        if ($validator->fails()) {
            return redirect()->route('mails.create')->withErrors($validator)->withInput();
        }

        Mail::create($inputs);

        $details = [
            'body_en' => $inputs['body_en'],
            'body_ar' => $inputs['body_ar'],
            'subject' => $inputs['subject'],
            'receivers' => $emails
        ];

        if ($inputs['scheduled'] == 0) {
            $job = (new MarketingMailJob($details))->delay(0);
        } else {
            $date = strtotime($inputs['datetime']);
            $job = (new MarketingMailJob($details))->delay(Carbon::parse($date));
        }
        dispatch($job);
        return redirect()->route('mails.index')->with(['success' => 'Mail ' . __("messages.add")]);    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mail  $mail
     */
    public function show(Mail $mail)
    {
        return view('admin.components.mail.show', compact('mail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(Mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mail $mail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mail $mail)
    {
        //
    }
    public function fetch_emails(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['token']);
        return User::query()->whereHas("roles", function($q) use ($inputs) { $q->where("name", $inputs['name'] ); })->pluck('email')->toArray() ;
    }
}
