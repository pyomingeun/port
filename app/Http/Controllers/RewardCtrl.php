<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward;

class RewardCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {               
        //
        $query = Reward::where('status', '=', 'active')->where('user_id', '=', auth()->user()->id);
        $query->select(['*']);
       
        $query->orderBy('reward_history.id','desc');
        // dd($query);
        $rewards =   $query->get();
        return view('customer.reward_history')->with(['rewards'=>$rewards]);
    }


}
