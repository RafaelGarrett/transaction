<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\Transaction;
use App\Models\User;
use App\Helpers\Helper;

class TransactionController extends Controller
{
    private $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required',
            'payer' => 'required',
            'payee' => 'required',
        ]);
        
        $user = User::findOrFail($request->payer);
        if($user->type_id == 2){
            return response()->json([
                'status' => 'error',
                'message' => 'User is a shopkeeper.'
            ], 401);
        }

        $accountPayer = $user->relAccount;
        if($accountPayer->balance < $request->value){
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient funds.'
            ], 418);
        }
        
        $res = Helper::requestAPI($_ENV['URL_MOCK_AUTHORIZED_SERVICE']);
        $statusCode = $res->getStatusCode();
        if($statusCode != 200){
            return response()->json([
                'status' => 'error',
                'message' => 'Authorized service unavailable.'
            ], $statusCode);
        }
        $body = json_decode($res->getBody());
        if($body->message != 'Autorizado'){
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized.'
            ], 401);
        }

        $userPayee = User::findOrFail($request->payee);

        $transaction = $this->transaction->create([
            'amount'=>$request->value,
            'origin_user'=>$request->payer,
            'destination_user'=>$request->payee,
            'status_id'=>4,
        ]);
        if(!$transaction){
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction fail.'
            ], 500);
        }

        $accountPayee = $userPayee->relAccount;
        $accountPayer->update([
            'balance'=>$accountPayer->balance - $request->value
        ]);
        $accountPayee->update([
            'balance'=>$accountPayee->balance + $request->value
        ]);

        $res = Helper::requestAPI($_ENV['URL_MOCK_EMAIL_SERVICE']);
        $statusCode = $res->getStatusCode();
        if($statusCode != 200){
            return response()->json([
                'status' => 'error',
                'message' => 'E-mail service unavailable.'
            ], $statusCode);
        }
        $body = json_decode($res->getBody());
        if(!$body->message){
            return response()->json([
                'status' => 'warning',
                'message' => 'Notification cannot be sent.'
            ], 418);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Transaction Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
