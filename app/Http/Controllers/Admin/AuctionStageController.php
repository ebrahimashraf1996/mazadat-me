<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuctionStage\StoreRequest;
use App\Http\Requests\AuctionStage\UpdateRequest;
use App\Models\AuctionStage;
use App\Models\Color;
use App\Models\Note;
use App\ViewModels\AuctionStageViewModel;
use App\ViewModels\ColorViewModel;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;

class AuctionStageController extends Controller
{

    public function index(Request $request)
    {
        $auctionStages = AuctionStage::where('auction_id' , auth('auction')->user()->id)->filter($request->all())->orderBy('id', 'desc')->paginate($request->limit ?? '10');
        return view('pages.auction_stage.index' , get_defined_vars());
    }

    public function create()
    {
        return view('pages.auction_stage.form' , new AuctionStageViewModel());
    }

    public function store(StoreRequest $request){
        AuctionStage::create($request->validated());
        alert()->success('تم الأضافة بنجاح');
        return redirect()->back();
    }

    public function edit(AuctionStage $auctionStage){
        return view('pages.auction_stage.form' , new AuctionStageViewModel($auctionStage));
    }

    public function update(UpdateRequest $request , AuctionStage $auctionStage){
        $auctionStage->update($request->validated());
        alert()->success('تم النعديل بنجاح');
        return redirect()->route('auctionStages.index');
    }

    public function destroy(AuctionStage $auctionStage){
        $auctionStage->delete();
        alert()->success('تم المسح بنجاح');
        return redirect()->route('auctionStages.index');
    }

    public function expireStage(AuctionStage $auctionStage){
        if($auctionStage->end_time == null){
            $auctionStage->update(['end_time' => now()]);
        }
        alert()->success('تم الانتهاء بنجاح');
        return redirect()->route('auctionStages.index');
    }

    public function addNote(Request $request)
    {
//        return $request;
        if ($request->has('notes') && $request->notes  != null) {
            $data['content'] = json_encode($request->notes);
            $data['stage_id'] = $request->stage_id;
            Note::create($data);
            alert()->success('تم اضافة الملاحظات بنجاح');
            return redirect()->back();
        } else {
            alert()->error('يرجي اضافة بعض الملاحظات');
            return redirect()->back();
        }
    }
}
