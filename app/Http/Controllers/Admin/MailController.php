<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MailsDataTable;
use App\Http\Controllers\Controller;
use App\Imports\EmailsImport;
use App\Jobs\MarketingMailJob;
use App\Models\Mail;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


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
        $categories = [
            null,
            1 => 'distributor',
            2 => 'contractor'
        ];
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
        $inputs = $this->data_preparation_store_import($request);

        $emails = $inputs['receivers'];
        $inputs['receivers'] = json_encode($inputs['receivers']);
        $validator = Validator::make($inputs, Mail::$cast);
        if ($validator->fails()) {
            return redirect()->route('mails.create')->withErrors($validator)->withInput();
        }

        $this->sendingEmail($inputs, $emails);
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

    public function importView(){
        $mail = new Mail();
        return view('admin.components.mail.import',  compact('mail'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function import(Request $request): RedirectResponse
    {
        $inputs = $this->data_preparation_store_import($request);

        $validator = Validator::make($inputs, [
            'file' => 'required',
            'subject' => 'required',
            'body_en' => 'required',
            'body_ar' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('mails.importView')->withErrors($validator)->withInput();
        }
        $temp = Excel::toArray(new EmailsImport, $inputs['file']);
        $rows = $temp[0];
        $emails = [];
        foreach ($rows as $row) {
            $emails[] = $row['email'];
        }
        $inputs['receivers'] = json_encode($emails);

        $this->sendingEmail($inputs, $emails);
        return redirect()->route('mails.index')->with(['success' => 'Email/s ' . __("messages.add")]);
    }


    public function fetch_emails(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['token']);
        return User::query()->whereHas("roles", function($q) use ($inputs) { $q->where("name", $inputs['name'] ); })->pluck('email')->toArray() ;
    }

    /**
     * @param array $inputs
     * @param array $emails
     * @return void
     */
    public function sendingEmail(array $inputs, array $emails): void
    {
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
    }

    /**
     * @param Request $request
     * @return array
     */
    public function data_preparation_store_import(Request $request): array
    {
        $inputs = $request->all();
        if ($inputs['datetime'] == null) {
            $inputs['sent_time'] = Carbon::now();
            $inputs['scheduled'] = 0;
        } else {
            $inputs['sent_time'] = Carbon::parse($inputs['datetime']);;
            $inputs['scheduled'] = 1;
        }
        return $inputs;
    }
}
