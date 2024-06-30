<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\DeliveryAuction;
use App\Models\Invoice;
use App\Models\Product;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Validator;
use ZipArchive;


class Dashboard extends Controller
{
  
  public function dashboard()
  {
    
      if(Auth::guard('admin')->check()){
        $clients = Client::count();
        $auctions = Auction::count();
        $deliveries = Delivery::count();
        $products = Product::count();
        return view('dashboard_admin', compact('clients', 'auctions', 'deliveries', 'products'));
      }

      if(Auth::guard('auction')->check()){
        $clients = AuctionProduct::where('auction_id', Auth::guard('auction')->user()->id)->select('client_id')->groupBy('client_id')->get();
        // $total_clients = $clients->count();
        $total_clients = Client::where('auction_id', Auth::guard('auction')->user()->id)->count();
        $total_invoices = Invoice::where('auction_id', Auth::guard('auction')->user()->id)->count();
        $total_products = AuctionProduct::where('auction_id', Auth::guard('auction')->user()->id)->count();
        $total_deliveries = Delivery::where('auction_id', Auth::guard('auction')->user()->id)->count();
        return view('dashboard_auction', compact('total_clients', 'total_invoices', 'total_products', 'total_deliveries'));
      }
      
      if(Auth::guard('delivery')->check()){
        $total_invoices = Invoice::where('delivery_id', Auth::guard('delivery')->user()->id)->count();
        return view('dashboard_delivery', compact('total_invoices'));
      }
      
  }

  public function profile()
  {
      $user = User::where('id', auth()->user()->id)->first();
      return view('pages.employees.profile', compact('user'));
  }

  public function profile_edit(Request $request, $id)
  {
    
    try{
      
      $validator = Validator::make($request->all(), [
        'name'          => 'required|string',
        'email'         => 'required|email|unique:users,email,'.$id,
        'phone1'        => 'required',
        'phone2'        => 'sometimes|nullable',
      ],[
        'required'      => 'هذا الحقل مطلوب',
      ]);

      if($validator->fails())
      {
          return back()->withErrors($validator)->withInput();
      }

      User::where('id', $id)->update([
        'name'        => $request->name,
        'email'       => $request->email,
        'phone1'      => $request->phone1,
        'phone2'      => $request->phone2,
        'updated_by'  => auth()->user()->id
      ]);

      alert()->success('تم تحديث البيانات بنجاح');
      return back();
      
    }
    catch(\Exception $ex){
      alert()->error('عفوا هناك خطأ تقني');
      return back();
    }
    
  }

  public function edit_password()
  {
    $user = User::where('id', auth()->user()->id)->first();
    return view('pages.employees.change_password', compact('user'));
  }

  public function change_password(Request $request, $id)
  {
    try{

      $validator = Validator::make($request->all(), [
        'old_password'     => 'required',
        'new_password'     => 'required',
      ],[
        'required'      => 'هذا الحقل مطلوب',
      ]);

      if($validator->fails())
      {
          return back()->withErrors($validator)->withInput();
      }

      $old_password = $request->old_password;
      $new_password = $request->new_password;
      $user = User::find($id);

      if(Hash::check($old_password, $user->password)){
        User::where('id', $id)->update([
          'password'    => Hash::make($new_password),
          'updated_by'  => auth()->user()->id
        ]);
        alert()->success('تم تحديث كلمة السر بنجاح');
      }else{
        alert()->error('كلمة السر القديمة ليست صحيحة');
        return back();
      }
      return back();
      
    }catch(\Exception $ex){
        alert()->error('عفوا هناك خطأ تقني');
        return back();
    }
    
  }

  public function takeBackUp(){
      Artisan::call('db:backup');
      if (File::exists(public_path('backup.zip'))) {
          File::chmod(public_path('backup.zip'),0777);
          File::delete(public_path('backup.zip'));
      }
      $this->downloadZip('backup.zip');
      return response()->download(public_path('backup.zip'));
  }

  public function downloadZip($fileName)
  {
      $zip = new ZipArchive;

      if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
      {
          $files = File::files(public_path('backup'));

          foreach ($files as $key => $value) {
              $relativeNameInZipFile = basename($value);
              $zip->addFile($value, $relativeNameInZipFile);
          }

          $zip->close();
      }
  }

}
