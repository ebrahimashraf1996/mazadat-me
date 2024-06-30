<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Validator;
use Auth;

class IncomeReservations extends Controller
{

    public function income_day()
    {
        $rows = Reservation::whereMonth('date', Carbon::now()->month)->where('deleted_at', null)->get();
        return view('pages.income_reservations.income_day', compact('rows'));
    }


    public function search_income_reservations(Request $request){
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        //======================================================================
        if($date_from != null && $date_to != null){
            $rows = Reservation::whereBetween('date', [$date_from, $date_to])->where('deleted_at', null)->get();
        }elseif($date_from != null && $date_to == null){
            $rows = Reservation::whereDate('date', '>=', $date_from)->where('deleted_at', null)->get();
        }elseif($date_from == null && $date_to != null){
            $rows = Reservation::whereDate('date', '<=', $date_to)->where('deleted_at', null)->get();
        }else{
            $rows = Reservation::where('deleted_at', null)->get();
        }

        $html = view('pages.income_reservations.ajax_income_reservation', compact('rows'))->render();
        return response()->json(['status' => true, 'income_reservation' => $html]);
    }


}
