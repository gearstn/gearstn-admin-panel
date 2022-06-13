<?php

namespace Modules\Transaction\Http\Controllers;

use App\Classes\POST_Caller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subscription\Http\Controllers\SubscriptionController;
use Modules\Transaction\Entities\OrderStatus;
use Modules\Transaction\Entities\Transaction;
use Modules\Transaction\Http\Requests\StoreTransactionRequest;
use Modules\Transaction\Http\Resources\TransactionResource;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Modules\Transaction\Jobs\DelayedExtraSubsctiptionJob;
use Modules\Transaction\Jobs\DelayedSubsctiptionJob;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::paginate(number_in_page());
        return TransactionResource::collection($transactions)->additional(['status' => 200, 'message' => 'Transactions fetched successfully']);
    }

    /**
     * Store a newly created resource in storage.
     * @return Renderable
     */
    public function store(StoreTransactionRequest $request)
    {
        $validation_cast = [
            "type" => 'required|string' ,
            "referenceNumber" => 'required|string|unique:fawry_transactions,referenceNumber',
            "merchantRefNumber" => 'required|string|unique:fawry_transactions,merchantRefNumber' ,
            "orderAmount" => 'required' ,
            "paymentAmount" => 'required' ,
            "fawryFees" => 'required' ,
            "orderStatus" => 'required|string' ,
            "paymentMethod" => 'required|string' ,
            "paymentTime" => 'required' ,
            "customerName" => 'required|string' ,
            "customerMobile" => 'required|string' ,
            "customerMail" => 'required|string' ,
            "customerProfileId" => 'required|string' ,
            "taxes" => 'required' ,
            "statusCode" => 'required' ,
            "statusDescription" => 'required|string' ,
            "basketPayment" => 'required',
            'subscription_id' => 'integer',
            'number_of_listing' => 'integer',
            'number_of_months' => 'integer'
        ];
        $inputs = $request->all();
        // $input_string = $request->transaction_data;
        // $inputs = json_decode($input_string,true);
        $validator = Validator::make($inputs, $validation_cast);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        // if (isset($request->validator) && $request->validator->fails()) {
        //     return response([
        //         'error_code' => 'VALIDATION_ERROR',
        //         'message'   => 'The given data was invalid.',
        //         'errors'    => $request->validator->errors()
        //     ], 400);
        // }

        // $inputs = $request->validated();

        $subscription_data = [
            'subscription_id' => $inputs['subscription_id'],
        ];

        // $merchantCode = "siYxylRjSPx+Mv6El3ZP+Q=="; //dev
        $merchantCode = "siYxylRjSPx005KQxu3Wfg=="; //prod

        // $secrure_key = '44adc425-0a2b-4936-921a-b705102d56b8';//dev
        $secrure_key = 'af294790-db73-48fe-a744-0d2edc10b9c3';//prod


        $merchantRefNumber = $inputs['merchantRefNumber'];
        $signature = hash('sha256', $merchantCode . $merchantRefNumber . $secrure_key);

        //dev
        // $response = Http::withBasicAuth('keys', 'secret')
        //     ->get('https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/status/v2?merchantCode=siYxylRjSPx+Mv6El3ZP+Q==&merchantRefNumber=' . $merchantRefNumber . '&signature=' . $signature);

        //prod
        $response = Http::withBasicAuth('keys', 'secret')
        ->get('https://www.atfawry.com/atfawry/plugin/assets/payments/js/fawrypay-payments.js?merchantCode=siYxylRjSPx005KQxu3Wfg==&merchantRefNumber=' . $merchantRefNumber . '&signature=' . $signature);


        if ($response->successful()) {
            $inputs['fawry_order_status_id'] = OrderStatus::where('name_en', $inputs['orderStatus'])->first()->id;
            $inputs['user_id'] = User::find($inputs['customerProfileId'])->id;
            unset($inputs['orderStatus'], $inputs['customerProfileId'], $inputs['subscription_id']);

            if ($inputs['fawry_order_status_id'] == 1) {
                $post = new POST_Caller(SubscriptionController::class, 'subscribe', Request::class, $subscription_data);
                $response = $post->call();
                if ($response->status() != 200) {
                    return $response;
                }

                Transaction::create($inputs);

                return response()->json([
                    'message_en' => 'Transaction Created Succesfully',
                    'message_ar' => 'لقد تم تسجيل العملية بنجاح',
                ], 200);
            } else if ($inputs['fawry_order_status_id'] == 2) {
                DelayedSubsctiptionJob::dispatch($inputs, $subscription_data)->delay(Carbon::now()->addDays(1));
                return response()->json([
                    'message_en' => 'Waiting to pay for your subscription',
                    'message_ar' => 'فى انتظار الدفع',
                ], 200);
            }
        } elseif ($response->failed()) {

            $response = json_decode($response->getBody()->getContents(), true);
            return response([
                'message' => 'Transaction already exists in fawry',
                'data' => $response
            ], 420);
        }
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json(new TransactionResource($transaction), 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json(new TransactionResource($transaction), 200);
    }


    /**
     * Store a newly created resource in storage.
     * @return Renderable
     */
    public function extra_plan_store(StoreTransactionRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response([
                'error_code' => 'VALIDATION_ERROR',
                'message'   => 'The given data was invalid.',
                'errors'    => $request->validator->errors()
            ], 400);
        }


        $inputs = $request->validated();
        $subscription_data = [
            'number_of_listing' => $inputs['number_of_listing'],
            'number_of_months' => $inputs['number_of_months']
        ];

        $merchantCode = "siYxylRjSPx+Mv6El3ZP+Q==";
        $secrure_key = '44adc425-0a2b-4936-921a-b705102d56b8';
        $merchantRefNumber = $inputs['merchantRefNumber'];
        $signature = hash('sha256', $merchantCode . $merchantRefNumber . $secrure_key);
        $response = Http::withBasicAuth('keys', 'secret')
            ->get('https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/status/v2?merchantCode=siYxylRjSPx+Mv6El3ZP+Q==&merchantRefNumber=' . $merchantRefNumber . '&signature=' . $signature);

        if ($response->successful()) {
            $inputs['fawry_order_status_id'] = OrderStatus::where('name_en', $inputs['orderStatus'])->first()->id;
            $inputs['user_id'] = User::find($inputs['customerProfileId'])->id;
            unset($inputs['orderStatus'], $inputs['customerProfileId'], $inputs['number_of_listing'], $inputs['number_of_months']);
            $subscription_data['user_id'] = $inputs['user_id'];

            if ($inputs['fawry_order_status_id'] == 1) {
                $post = new POST_Caller(SubscriptionController::class, 'extra_plan_subscribe', Request::class, $subscription_data);
                $response = $post->call();
                if ($response->status() != 200) {
                    return $response;
                }

                Transaction::create($inputs);

                return response()->json([
                    'message_en' => 'Transaction Created Succesfully',
                    'message_ar' => 'لقد تم تسجيل العملية بنجاح',
                ], 200);
            } else if ($inputs['fawry_order_status_id'] == 2) {
                DelayedExtraSubsctiptionJob::dispatch($inputs, $subscription_data)->delay(Carbon::now()->addDays(1));
                return response()->json([
                    'message_en' => 'Waiting to pay for your subscription',
                    'message_ar' => 'فى انتظار الدفع',
                ], 200);
            }
        } elseif ($response->failed()) {

            $response = json_decode($response->getBody()->getContents(), true);
            return response([
                'message' => 'Transaction already exists in fawry',
                'data' => $response
            ], 420);
        }
    }

    public function user_transactions()
    {
        $user = User::find(auth()->user()->id);
        $transactions = Transaction::where('user_id', $user->id)->get();
        return TransactionResource::collection($transactions)->additional(['status' => 200, 'message' => 'Transactions fetched successfully']);
    }
}
