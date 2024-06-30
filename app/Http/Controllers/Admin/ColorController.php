<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Color\StoreRequest;
use App\Http\Requests\Color\UpdateRequest;
use App\Models\Color;
use App\ViewModels\ColorViewModel;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    
    public function index(Request $request){
        $colors = Color::filter($request->all())->paginate();
        return view('pages.colors.index' , compact('colors'));
    }


    public function create(){
        return view('pages.colors.form' , new ColorViewModel());
    }


    public function store(StoreRequest $request){
        Color::create($request->validated());
        alert()->success('تم الأضافة بنجاح');
        return redirect()->route('colors.create');
    }
    

    public function edit(Color $color){
        return view('pages.colors.form' , new ColorViewModel($color));
    }
    

    public function update(UpdateRequest $request , Color $color){
        $color->update($request->validated());
        alert()->success('تم النعديل بنجاح');
        return redirect()->route('colors.index');
    }


    public function destroy(Color $color){
        $color->delete();
        alert()->success('تم المسح بنجاح');
        return redirect()->route('colors.index');
    }

}
