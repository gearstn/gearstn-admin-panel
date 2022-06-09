<?php

namespace Modules\Mail\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Modules\Machine\Entities\Machine;
use Modules\Mail\Emails\ContactBuyerMail;
use Modules\Mail\Emails\ContactSellerMail;
use Modules\Mail\Emails\OpenConversationMail;
use Modules\Mail\Emails\StoreMachineMail;
use Modules\Mail\Emails\StoreSparePartMail;
use Modules\Mail\Entities\Mail as EntitiesMail;
use Modules\Mail\Http\Requests\ContactSellerRequest;
use Modules\Mail\Http\Requests\OpenConversationMailRequest;
use Modules\Mail\Http\Requests\StoreMachineMailRequest;
use Modules\Mail\Http\Resources\MailResource;
use Modules\SparePart\Entities\SparePart;

class MailController extends Controller
{

    public function index()
    {
        $mails = Mail::all();
        return MailResource::collection($mails)->additional(['status' => 200, 'message' => 'Categories fetched successfully']);
    }


    public function store(Request $request)
    {
        $inputs = $request->all();
        if ($inputs['datetime'] == null) {
            $inputs['sent_time'] = Carbon::now();
            $inputs['scheduled'] = 0;
        } else {
            $inputs['sent_time'] = Carbon::parse($inputs['datetime']);;
            $inputs['scheduled'] = 1;
        }

        isset($inputs['file']) ? $import_emails = $this->import(['file' => $inputs['file']]) : $import_emails = [];

        $emails = isset($inputs['receivers']) ? array_merge($inputs['receivers'], $import_emails) : $import_emails;
        $inputs['receivers'] = $emails;

        $validator = Validator::make($inputs, EntitiesMail::$cast);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $inputs['receivers'] = json_encode($emails);

        $mail = Mail::create($inputs);

        $this->sendingEmail($inputs, $emails);

        return response()->json(new MailResource($mail), 200);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $mail = Mail::findOrFail($id);
        return response()->json(new MailResource($mail),200);
    }

    //     /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(UpdateMachineModelRequest $request, $id)
    // {
    //     $inputs = $request->validated();
    //     $model = MachineModel::find($id);
    //     $model->update($inputs);
    //     return response()->json(new MachineModelResource($model), 200)->additional(['status' => 200, 'message' => 'Machine Model updated successfully']);
    // }


        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mail = Mail::findOrFail($id);
        $mail->delete();
        return response()->json(new MailResource($mail), 200);
    }

    public function contact_seller(ContactSellerRequest $request)
    {
        $inputs = $request->validated();
        $machine = Machine::find($inputs['machine_id']);
        $seller = User::find($machine->seller_id);

        $seller_details = [
            'title' => 'Request price for ' . $machine->slug,
            'machine' => $machine,
            'body' => $inputs['message'],
            'seller' => $seller,
            'buyer' => auth()->user()
        ];

        $buyer_details = [
            'title' => 'You have requested price for ' . $machine->slug,
            'seller' => $seller,
            'buyer' => auth()->user()
        ];

        Mail::to($seller->email)->send(new ContactSellerMail($seller_details));
        Mail::to(auth()->user()->email)->send(new ContactBuyerMail($buyer_details));
        views($machine)->record();
        return response('Email sent Successfully', 200);
    }


    public function store_machine(Request $request)
    {

        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'machine_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $machine = Machine::find($inputs['machine_id']);
        $seller = User::find($machine->seller_id);

        $details = [
            'title' => 'You have stored machine ' . $machine->slug,
            'seller' => $seller,
        ];

        Mail::to($seller->email)->send(new StoreMachineMail($details));
        return response('Email sent Successfully', 200);
    }


    public function open_conversation_with_seller(OpenConversationMailRequest $request)
    {
        $inputs = $request->validated();

        if ($inputs['model_type'] == 'machine') {
            $model = Machine::find($inputs['model_id']);
        } else {
            $model = SparePart::find($inputs['model_id']);
        }

        $owner = User::find($inputs['owner_id']);
        $acquire = User::find($inputs['acquire_id']);

        $details = [
            'subject' => $acquire->first_name . ' ' . $acquire->last_name . ' ' . ' opened a conversation ',
            'acquire' => $acquire,
            'owner' => $owner,
            'model' => $model,
        ];

        Mail::to($owner->email)->send(new OpenConversationMail($details));
    }


    public function store_spare_part(Request $request)
    {

        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'spare_part_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $spare_part = SparePart::find($inputs['spare_part_id']);
        $seller = User::find($spare_part->seller_id);

        $details = [
            'title' => 'You have stored spare part ' . $spare_part->slug,
            'seller' => $seller,
        ];

        Mail::to($seller->email)->send(new StoreSparePartMail($details));
        return response('Email sent Successfully', 200);
    }


    // public function import($inputs)
    // {

    //     $validator = Validator::make($inputs, [
    //         'file' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return false;
    //     }
    //     $temp = Excel::toArray(new EmailsImport, $inputs['file']);
    //     $rows = $temp[0];
    //     $emails = [];
    //     foreach ($rows as $row) {
    //         $emails[] = $row['emails'];
    //     }
    //     return $emails;
    // }


    // public function fetch_emails(Request $request)
    // {
    //     $inputs = $request->all();
    //     unset($inputs['token']);
    //     return User::query()->whereHas("roles", function($q) use ($inputs) { $q->where("name", $inputs['name'] ); })->pluck('email')->toArray() ;
    // }

    // /**
    //  * @param array $inputs
    //  * @param array $emails
    //  * @return void
    //  */
    // public function sendingEmail(array $inputs, array $emails): void
    // {
    //     $details = [
    //         'body_en' => $inputs['body_en'],
    //         'body_ar' => $inputs['body_ar'],
    //         'subject' => $inputs['subject'],
    //         'receivers' => $emails
    //     ];

    //     if ($inputs['scheduled'] == 0) {
    //         $job = (new MarketingMailJob($details))->delay(0);
    //     } else {
    //         $date = strtotime($inputs['datetime']);
    //         $job = (new MarketingMailJob($details))->delay(Carbon::parse($date));
    //     }
    //     dispatch($job);
    // }


}
