<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\InvoiceBranch;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class InvoiceBranchs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = InvoiceBranch::get();
        return view('pages.invoice_branchs.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branchs = Branch::get();
        return view('pages.invoice_branchs.add', compact('branchs'));
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

        $check_branch = InvoiceBranch::where('branch_id', $request->branch_id)->first();
        if($check_branch){
            alert()->error('عفوا هناك أعدادات لهذا الفرع بالفعل');
            return back();
        }else{

            $validator = Validator::make($request->all(), [
              'branch_id'         => 'required',
              'prefix'            => 'required',
              'number'            => 'sometimes|nullable',
            ],[
              'required'            => 'هذا الحقل مطلوب',
              'branch_id.exists'    => 'تم أضافة هذا الفرع من قبل'
            ]);

            if($validator->fails())
            {
                return back()->withErrors($validator)->withInput();
            }

            if($request->number == null){
              $number = 0;
            }elseif($request->number == 1){
              $number = 0;
            }else{
              $number = $request->number;
            }
            InvoiceBranch::create([
              'branch_id'       => $request->branch_id,
              'prefix'          => $request->prefix,
              'number'          => $number,
              'created_by'      => auth()->user()->id
            ]);

            alert()->success('تم الأضافة بنجاح');
            return back();
        }
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $branchs = Branch::get();
      $row = InvoiceBranch::where('id', $id)->first();
      return view('pages.invoice_branchs.edit', compact('row', 'branchs'));
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
              'branch_id'         => 'required|unique:invoice_branchs,branch_id,'.$id,
              'prefix'            => 'required',
              'number'            => 'sometimes|nullable',
            ],[
              'required'            => 'هذا الحقل مطلوب',
              'branch_id.unique'    => 'تم أضافة هذا الفرع من قبل'
            ]);

            if($validator->fails())
            {
                return back()->withErrors($validator)->withInput();
            }

            if($request->number == null){
              $number = 0;
            }elseif($request->number == 1){
              $number = 0;
            }else{
              $number = $request->number;
            }
            InvoiceBranch::where('id', $id)->update([
              'branch_id'       => $request->branch_id,
              'prefix'          => $request->prefix,
              'number'          => $number,
              'created_by'      => auth()->user()->id
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
      $row = InvoiceBranch::where('id', $id)->first();
      $row->delete();
      alert()->success('تم الحذف مؤقتا');
      return back();
    }


    public function softDelete()
    {
        $branchs = Branch::onlyTrashed()->get();
        return view('pages.branchs.soft_delete', compact('branchs'));
    }

}
