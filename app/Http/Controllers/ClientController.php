<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;


use App\Client;

class ClientController extends Controller
{
    public function createClient (Request $request)
    {
        $validate = Validator::make($request->all(), [
            'firstname' => 'required|string|min:1|max:255',
            'lastname' => 'required|string|min:1|max:255',
            'email'=>'required|string|email|unique:clients',
            'password' => 'required|string|min:1|max:255',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());
        }

        $client = Client::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $id = Client::where([
            'updated_at' => $client->updated_at, 'deleted' => 0,
          ])->pluck('id')->first();

        return response()->json(['id' => $id]);
    }

    public function getClient (Request $request)
    {
        $id = preg_replace('#[^0-9]#', '', $request->id);

        $client = Client::where('id', '=', $id)->where('deleted', '!=', 1)->get();

        return response()->json($client);
    }

    public function getClients ()
    {
        $clients = Client::where('deleted', '!=', 1)->get();
        // $clients = Client::all();

        return response()->json($clients);
    }

    public function removeClient (Request $request)
    {
        $id = preg_replace('#[^0-9]#', '', $request->id);

        $client = Client::find($id);

        if ($client === null) {
            return response()->json(['status' => 'not_found']);
        }

        Client::where(['id' => $id])->update(['deleted' => 1]);

        return response()->json(['status' => 'done']);
    }
}
