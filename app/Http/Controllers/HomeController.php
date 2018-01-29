<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Invest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invests = Invest::where('user_id', '=', Auth::id())
          ->orderBy('value_real', "DESC")->get();
        $total = $invests->sum('value_real');
        return view('home', [
          'invests' => $invests,
          'total' => $total,
        ]);
    }
    
    /**
     * Add Invest
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request  $request)
    {
      return view('invest.add');
    }
    
    /**
     * Add Invest
     *
     * @return \Illuminate\Http\Response
     */
    public function add_do(Request  $request)
    {
      $validator = Validator::make($request->all(), [
          'type' => 'required|max:255',
      ]);

      if ($validator->fails()) {
          return redirect('/task/add')
              ->withInput()
              ->withErrors($validator);
      }

      // Create The Task...
      $inv = new Invest;
      $inv->user_id = Auth::id();
      $inv->type = $request->type;
      $inv->value = $request->value;
      $inv->value_real = 0;
      $inv->site = $request->site;
      $inv->save();

      return redirect('/home');
    }
    
    /**
     * Delete Invest
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request  $request)
    {
      Invest::findOrFail($request->id)->delete();
    
      return redirect('/home');
    }
    
    /**
     * Refresh Invest
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh_value_real(Request  $request)
    {
      
      $key = 'key_coinmarketcap_ticker';
      $minutes = 10;
      $json_raw = Cache::remember($key, $minutes, function () {
          $json_raw = file_get_contents('https://api.coinmarketcap.com/v1/ticker/');
          return $json_raw;
      });
      $json = json_decode($json_raw);
      $map = [];
      foreach ($json as $key => $value) {
        $map[$value->symbol] = $value;
      }
      
      $invests = Invest::orderBy('value_real', "DESC")->get();
      foreach ($invests as $key => $invest) {
        $type = $invest->type;
        if (isset($map[$type])) {
          $value_real = $invest->value * $map[$type]->price_usd;
          $invest->value_real = $value_real;
          $invest->save();
        }
      }
    
      return redirect('/home');
    }
}
