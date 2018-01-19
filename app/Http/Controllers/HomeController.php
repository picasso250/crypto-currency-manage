<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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
        $invests = Invest::orderBy('value_real', "DESC")->get();
        return view('home', [
          'invests' => $invests
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
      $json_raw = '
[
    {
        "id": "bitcoin", 
        "name": "Bitcoin", 
        "symbol": "BTC", 
        "rank": "1", 
        "price_usd": "11709.0", 
        "price_btc": "1.0", 
        "24h_volume_usd": "14017300000.0", 
        "market_cap_usd": "196851122550", 
        "available_supply": "16811950.0", 
        "total_supply": "16811950.0", 
        "max_supply": "21000000.0", 
        "percent_change_1h": "-0.74", 
        "percent_change_24h": "2.95", 
        "percent_change_7d": "-16.03", 
        "last_updated": "1516356864"
    }
]';
      $json_raw = file_get_contents('https://api.coinmarketcap.com/v1/ticker/');
      $json = json_decode($json_raw);
      $map = [];
      foreach ($json as $key => $value) {
        $map[$value->symbol] = $value;
      }
      // print_r($map);exit;
      
      $invests = Invest::orderBy('value_real', "DESC")->get();
      foreach ($invests as $key => $invest) {
        $type = $invest->type;
        // echo $type,PHP_EOL;
        // var_dump(isset($map[$type]));
        if (isset($map[$type])) {
          $value_real = $invest->value * $map[$type]->price_usd;
          // var_dump($value_real);exit;
          $invest->value_real = $value_real;
          $invest->save();
        }
      }
    
      return redirect('/home');
    }
}
