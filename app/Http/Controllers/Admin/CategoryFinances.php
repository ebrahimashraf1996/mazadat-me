<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\TraitHelper;
use App\Models\CategoryFinance;
use App\Models\User;
use Validator;
use File;

class CategoryFinances extends Controller
{

    use TraitHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_check = User::where([['id', auth()->user()->id], ['is_admin', 'yes']])->first();
        $check_categories = CategoryFinance::where('created_by', auth()->user()->id)->where('deleted_at', null)->count();
        if($check_categories  > 0){
            $categories = CategoryFinance::where('created_by', auth()->user()->id)->where('deleted_at', null)->get();
        }else{
            if($user_check){
                $categories = CategoryFinance::where('deleted_at', null)->get();
            }else{
                  alert()->error('الصلاحية للمشرفين و الموظفين فقط');
                  return back();
            }
        }
        return view('pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.categories.add');
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
          'name'          => 'required|string',
          'icon'          => 'sometimes|nullable|image|mimes:jpg,png,svg,jpeg',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $icon_path = "";
        if($request->has("icon"))
        {
          $icon_path = $this->uploadImage('categories', $request->icon);
        }

      CategoryFinance::create([
          'name'        => $request->name,
          'icon'        => $icon_path,
          'created_by'  => auth()->user()->id
        ]);

        alert()->success('تم الأضافة بنجاح');
        return back();
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
      $category = CategoryFinance::where('id', $id)->first();
      return view('pages.categories.edit', compact('category'));
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
          'name'          => 'required|string',
          'icon'          => 'sometimes|nullable|image|mimes:jpg,png,svg,jpeg',
        ],[
          'required'      => 'هذا الحقل مطلوب',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $check_category =  CategoryFinance::where('id', $id)->first();
        $icon_path = "";
        if($request->has("icon"))
        {

          if(file_exists(public_path($check_category->icon)))
          {
              File::delete(public_path($check_category->icon));
          }
          $icon_path = $this->uploadImage('categories', $request->icon);
        }else{
            $icon_path = $check_category->icon;
        }

        CategoryFinance::where('id', $id)->update([
            'name'        => $request->name,
            'icon'        => $icon_path,
            'updated_by'  => auth()->user()->id
          ]);

          alert()->success('تم التحديث بنجاح');
          return back();
      }catch(\Exception $ex){
        return $ex;
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
      $category = CategoryFinance::find($id);
      $category->delete();
      alert()->success('تم الحذف مؤقتا');
      return back();
    }


    public function softDelete()
    {
        $categories = CategoryFinance::onlyTrashed()->get();
        return view('pages.categories.soft_delete', compact('categories'));
    }

    public function untrash(Request $request, $id)
    {
        CategoryFinance::where('id', $id)->restore();
        alert()->success('تم الغاء الحذف المؤقت');
        return back();
    }

    public function forceDelete(Request $request, $id)
    {
        CategoryFinance::where('id', $id)->forceDelete();
        alert()->success('تم الحذف نهائيا');
        return back();
    }
}
