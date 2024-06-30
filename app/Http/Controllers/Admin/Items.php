<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Validator;
use Auth;

class Items extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
        $check_item =  Item::where('created_by', auth()->user()->id)->where('deleted_at', null)->count();
        if($check_item  > 0){
            $items =  Item::where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
        }else{
            if($user_check){
                $items =  Item::where('deleted_at', null)->get();
            }else{
                  alert()->error('الصلاحية للمشرفين و الموظفين فقط');
                  return back();
            }
        }
        return view('pages.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.items.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try{

        $validator = Validator::make($request->all(), [
          'name'          => 'required|string|unique:items,name',
          'avg_price'     => 'sometimes|nullable',
        ],[
          'required'      => 'هذا الحقل مطلوب',
          'name.unique'   => 'تم أضافة هذا المنتج من قبل'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }


        Item::create([
          'name'        => $request->name,
          'avg_price'   => $request->avg_price,
          'created_by'  => auth()->user()->id
        ]);

        alert()->success('تم الأضافة بنجاح');
          return redirect()->route('items.index');
      }catch(\Exception $ex){
        return $ex;
        alert()->error('عفوا هناك خطأ تقني');
        return back();
      }
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
      $item = Item::where('id', $id)->first();
      return view('pages.items.edit', compact('item'));
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
      try{

        $validator = Validator::make($request->all(), [
          'name'          => 'required|string|unique:items,name,',$id,
          'avg_price'     => 'sometimes|nullable',
        ],[
          'required'      => 'هذا الحقل مطلوب',
          'name.unique'   => 'تم أضافة هذا المنتج من قبل'
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }


        Item::where('id', $id)->update([
          'name'        => $request->name,
          'avg_price'   => $request->avg_price,
          'updated_by'  => auth()->user()->id
        ]);

        alert()->success('تم التحديث بنجاح');
        return back();
      }catch(\Exception $ex){
        alert()->error('عفوا هناك خطأ تقني');
        return back();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $item = Item::where('id', $id)->first();
      $item->delete();
      alert()->success('تم الحذف مؤقتا');
      return back();
    }


    public function softDelete()
    {
        $items = Item::onlyTrashed()->get();
        return view('pages.items.soft_delete', compact('items'));
    }

    public function untrash(Request $request, $id)
    {
        Item::where('id', $id)->restore();
        alert()->success('تم الغاء الحذف المؤقت');
        return back();
    }

    public function forceDelete(Request $request, $id)
    {
        Item::where('id', $id)->forceDelete();
        alert()->success('تم الحذف نهائيا');
        return back();
    }
}
