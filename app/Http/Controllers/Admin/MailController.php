<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MailsDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\MarketingMailJob;
use App\Models\Mail;
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
        return view('admin.components.mail.create', compact('mail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if($input['datetime'] == null){
            $input['sent_time'] = Carbon::now();
            $input['scheduled'] = 0;
        }
        else{
            $input['sent_time'] = Carbon::parse($input['datetime']);;
            $input['scheduled'] = 1;
        }
        $validator = Validator::make($input, Mail::$cast);
        if ($validator->fails()) {
            return redirect()->route('mails.create')->withErrors($validator)->withInput();
        }

        $input['emails'] = json_encode($input['emails']);
        Mail::create($input);

        $details = [
            'body_en' => $input['body_en'],
            'body_ar' => $input['body_ar'],
            'subject' => $input['subject'],
            'receiver' => json_decode($input['emails'], true)
        ];

        if ($input['scheduled'] == 0) {
            $job = (new MarketingMailJob($details))->delay(0);
        } else {
            $date = strtotime($input['datetime']);
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
}
