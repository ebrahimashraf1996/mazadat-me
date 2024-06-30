<?php

/** Mazadat */

use App\Http\Controllers\Admin\Areas;
use App\Http\Controllers\Admin\AuctionProducts;
use App\Http\Controllers\Admin\Auctions;
use App\Http\Controllers\Admin\AuctionStageController;
use App\Http\Controllers\Admin\Cities;
use App\Http\Controllers\Admin\Clients;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\Countries;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Deliveries;
use App\Http\Controllers\Admin\Employees;
//=============================================
use App\Http\Controllers\Admin\Invoices;
use App\Http\Controllers\Admin\Mangers;
use App\Http\Controllers\Admin\Permissions;
use App\Http\Controllers\Admin\Products;
//use App\Http\Controllers\Admin\Expenses;
use App\Http\Controllers\Admin\Roles;
use App\Http\Controllers\Admin\Settings;
use App\Http\Controllers\Auth\Login;
use App\Models\AuctionProduct;
use App\Models\AuctionStage;
use App\Models\Client;
use App\Models\Delivery;
/* Auth Routes **/

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('fix_products', function () {
    $products = DB::table('auction_products')
//        ->whereDate('created_at', '>=', \Carbon\Carbon::parse('2024-05-05')->format('Y-m-d 00:00:00'))
        ->where('product_id', '>', 1000000)
        ->orderBy('id', 'asc')->get();
    $ids = [];
    $test = 0;
    foreach ($products as $product) {

        $check = \App\Models\Product::find($product->product_id);

        if (!$check) {
            $test++;
            $ids[] = $product->product_id;
            DB::table('auction_products')->where('id', $product->id)->update(['product_id' => $product->product_id -1000000 ]);
        }

//        $products = DB::table('products')->find($product->id)->update(['id' => $product->id-100000]);
    }
    $ids = array_unique($ids);
    return [$test, $ids ];

});

Route::get('update_data', function () {
//    $last_stage = DB::table('auction_stages')->orderBy('id', 'desc')->first();
    $stages = DB::connection('secondary')->table('auction_stages')
        ->whereDate('created_at', '>', \Carbon\Carbon::parse("2024-05-12 04:16:34")->format('Y-m-d 00:00:00'))
//       ->whereTime('created_at', '>',  \Carbon\Carbon::parse($last_stage->created_at)->format('h:i:s'))
        ->get();

    foreach ($stages as $stage) {

        $auction_stage = DB::table('auction_stages')->insert([
            'id' => $stage->id + 1000000,
            'auction_id' => $stage->auction_id,
            'name' => $stage->name,
            'start_time' => $stage->start_time,
            'end_time' => $stage->end_time,
            'created_at' => $stage->created_at,
            'updated_at' => $stage->updated_at,
            'notes' => $stage->notes,
        ]);
    }

});

Route::get('upd_clients', function () {
//    $last_stage = DB::table('clients')->orderBy('id', 'desc')->first();

    $clients = DB::connection('secondary')->table('clients')
        ->whereDate('updated_at', '>', \Carbon\Carbon::parse("2024-05-12 04:16:34")->format('Y-m-d 00:00:00'))
        ->orderBy('id', 'asc')->get();


    foreach ($clients as $client) {
        DB::table('clients')->insert([
            'id' => $client->id + 1000000,
            'name' => $client->name,
            'username' => $client->username,
            'phone1' => $client->phone1,
            'phone2' => $client->phone2,
            'address' => $client->address,
            'area_id' => $client->area_id,
            'auction_id' => $client->auction_id,
            'piece' => $client->piece,
            'street' => $client->street,
            'avenue' => $client->avenue,
            'house_number' => $client->house_number,
            'note' => $client->note,
            'creaded_by' => $client->creaded_by,
            'updated_by' => $client->updated_by,
            'created_at' => $client->created_at,
            'updated_at' => $client->updated_at,
        ]);
    }
});

Route::get('upd_main_products', function () {
//    $last_stage = DB::table('products')->orderBy('id', 'desc')->first();

    $products = DB::connection('secondary')->table('products')
        ->whereDate('created_at', '>', \Carbon\Carbon::parse("2024-05-12 04:16:34")->format('Y-m-d 00:00:00'))
        ->orderBy('id', 'asc')->get();


    foreach ($products as $product) {
//        return$product;
        DB::table('products')->insert([
            'id' => $product->id + 1000000,
            'name' => $product->name,
            'qty' => $product->qty,
            'price' => $product->price,
            'image' => $product->image,
            'notes' => $product->notes,
            'auction_id' => $product->auction_id,
            'status' => $product->status,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);
    }
});

Route::get('upd_products', function () {
//    $last_stage = DB::table('auction_products')->orderBy('id', 'desc')->first();

    $products = DB::connection('secondary')->table('auction_products')
        ->whereDate('created_at', '>', \Carbon\Carbon::parse("2024-05-12 04:16:34")->format('Y-m-d 00:00:00'))
        ->orderBy('id', 'asc')->get();


    foreach ($products as $product) {

        $check = Client::find($product->client_id + 1000000);
        if ($check) {
//            'client_id' => $check->id

            $check_auc_pro = DB::table('auction_products')->find($product->id + 1000000);
            if (!$check_auc_pro) {
                DB::table('auction_products')->updateOrInsert([
                    'id' => $product->id + 1000000,
                    'code' => $product->code,
                    'auction_id' => $product->auction_id,
                    'auction_date' => $product->auction_date,
                    'client_id' => $check->id,
                    'product_id' => $product->product_id + 1000000,
                    'purchase_type' => $product->purchase_type,
                    'count_pieces' => $product->count_pieces,
                    'price' => $product->price,
                    'notes' => $product->notes,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'invoice_id' => $product->invoice_id + 1000000,
                    'auction_stage_id' => $product->auction_stage_id + 1000000,
                    'is_return' => $product->is_return,
                ]);
            }



        } else {
            $check_auc_pro = DB::table('auction_products')->find($product->id + 1000000);
            if(!$check_auc_pro) {
                DB::table('auction_products')->updateOrInsert([
                    'id' => $product->id + 1000000,
                    'code' => $product->code,
                    'auction_id' => $product->auction_id,
                    'auction_date' => $product->auction_date,
                    'client_id' => $product->client_id,
                    'product_id' => $product->product_id + 1000000,
                    'purchase_type' => $product->purchase_type,
                    'count_pieces' => $product->count_pieces,
                    'price' => $product->price,
                    'notes' => $product->notes,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                    'invoice_id' => $product->invoice_id + 1000000,
                    'auction_stage_id' => $product->auction_stage_id + 1000000,
                    'is_return' => $product->is_return,
                ]);
            }


        }



    }
});

Route::get('upd_invoices', function () {
//    $last_stage = DB::table('invoices')->orderBy('id', 'desc')->first();

    $invoices = DB::connection('secondary')->table('invoices')
        ->whereDate('created_at', '>=', \Carbon\Carbon::parse("2024-05-12 04:04:48")->format('Y-m-d 00:00:00'))
        ->orderBy('id', 'asc')->get();


    foreach ($invoices as $invoice) {
//        return $invoice;
        $check = Client::find($invoice->client_id + 1000000);
        if ($check) {
//            'client_id' => $check->id
            DB::table('invoices')->insert([
                'id' => $invoice->id + 1000000,
                'invoice_number' => $invoice->invoice_number + 100000,
                'auction_id' => $invoice->auction_id,
                'delivery_id' => $invoice->delivery_id,
                'delivery_date' => $invoice->delivery_date,
                'delivery_price' => $invoice->delivery_price,
                'order_date' => $invoice->order_date,
                'payment' => $invoice->payment,
                'client_id' => $check->id,
                'status' => $invoice->status,
                'invoice_date' => $invoice->invoice_date,
                'total_invoice' => $invoice->total_invoice,
                'created_at' => $invoice->created_at,
                'updated_at' => $invoice->updated_at,
                'status_invoice' => $invoice->status_invoice,
                'notes' => $invoice->notes,
                'auction_stage_id' => $invoice->auction_stage_id + 1000000,
                'serial_number' => $invoice->serial_number + 1000000,
            ]);


        } else {
            DB::table('invoices')->insert([
                'id' => $invoice->id + 1000000,
                'invoice_number' => $invoice->invoice_number + 100000,
                'auction_id' => $invoice->auction_id,
                'delivery_id' => $invoice->delivery_id,
                'delivery_date' => $invoice->delivery_date,
                'delivery_price' => $invoice->delivery_price,
                'order_date' => $invoice->order_date,
                'payment' => $invoice->payment,
                'client_id' => $invoice->client_id,
                'status' => $invoice->status,
                'invoice_date' => $invoice->invoice_date,
                'total_invoice' => $invoice->total_invoice,
                'created_at' => $invoice->created_at,
                'updated_at' => $invoice->updated_at,
                'status_invoice' => $invoice->status_invoice,
                'notes' => $invoice->notes,
                'auction_stage_id' => $invoice->auction_stage_id + 1000000,
                'serial_number' => $invoice->serial_number + 1000000,
            ]);
        }


    }
});


/* Dashboard */
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/', [Dashboard::class, 'dashboard'])->name('admin.dashboard');
    Route::get('profile', [Dashboard::class, 'profile'])->name('admin.profile');
    Route::put('profile/edit/{id}', [Dashboard::class, 'profile_edit'])->name('profile.edit');
    Route::get('edit/password', [Dashboard::class, 'edit_password'])->name('edit.password');
    Route::put('edit/password/{id}', [Dashboard::class, 'change_password'])->name('change.password');

    Route::get('take-back-up', [Dashboard::class, 'takeBackUp'])->name('take_back_up');
    /* Permissions */
    Route::resource('permissions', Permissions::class);
    Route::post('permissions/{id}', [Permissions::class, 'users_permissions'])->name('users.permissions');

    /* Roles */
    Route::resource('roles', Roles::class);

    /* Countries & Cities */
    Route::resource('countries', Countries::class);
    Route::resource('cities', Cities::class);
    Route::resource('areas', Areas::class);

    /* Products */
    Route::resource('products', Products::class);
    Route::get('search/products', [Products::class, 'search_products'])->name('search.products');

    /* Deliveries */
    Route::resource('deliveries', Deliveries::class);
    Route::get('get-delivery-invoices', [Deliveries::class, 'getDeliveryInvoices'])
        ->name('get-delivery-invoices');
    Route::post('get-invoice-note', [Deliveries::class, 'updateInvoiceNote'])
        ->name('get-invoice-note');

    /* Auctions */
    Route::resource('{auctionStage}/auction-products', AuctionProducts::class);
    Route::get('auction/products/general', [AuctionProducts::class, 'generalSearchProduct'])->name('get.general-search-product');
    Route::get('auction/products/returns', [AuctionProducts::class, 'generalReturnProducts'])->name('get.return-products');
    Route::any('ajax-auction-products/{auctionStage}', [AuctionProducts::class, 'getProductAuction'])->name('get.product.auction');
    Route::post('return-product/{id}', [AuctionProducts::class, 'returnProduct'])->name('return.product');
    Route::get('{auctionStage}/updateReturn/{id}/edit', [AuctionProducts::class, 'returnEdit'])->name('returnEdit');
    Route::put('{auctionStage}/updateReturn/{id}', [AuctionProducts::class, 'returnUpdate'])->name('returnUpdate');
    // Auction Stage
    Route::resource('auctionStages', AuctionStageController::class);
    Route::get('auctionStages/expired/{auctionStage}', [AuctionStageController::class, 'expireStage'])->name('auctionStage.expired.stage');
    Route::post('add-note', [AuctionStageController::class, 'addNote'])->name('add.note');
    /* Auctions */
    Route::resource('auctions', Auctions::class);
    Route::get('auction/invoices/{id}', [Auctions::class, 'auctionInvoices'])->name('auction.invoices');
    Route::get('auction/clients/{id}', [Auctions::class, 'auctionClients'])->name('auction.clients');
    Route::post('check-product', [AuctionProducts::class, 'addProduct'])->name('check-product');
    Route::post('buy-product/{auctionStage}', [AuctionProducts::class, 'buyProduct'])->name('buy-product');
    Route::post('new-buy-product/{auctionStage}', [AuctionProducts::class, 'newBuyProduct'])->name('newBuyProduct');
    Route::post('check-client', [AuctionProducts::class, 'checkClient'])->name('check-client');
    Route::post('client-many-products/{auctionStage}', [AuctionProducts::class, 'clientManyProducts'])->name('client-many-products');
    Route::get('get-notes/{id}', [Auctions::class, 'getNotes'])->name('getNotes.stage');
    Route::post('update-notes/{id}', [Auctions::class, 'updateNotes'])->name('updateNotes.stage');
    Route::post('renew-sell', [AuctionProducts::class, 'renewSell'])->name('renewSell');
    Route::get('burn_clients_session', [Auctions::class, 'burn_clients_session'])->name('burn_clients_session');
    /** Colors */
    Route::resource('colors', ColorController::class);

    /* Clients */
    Route::resource('clients', Clients::class);
    Route::get('soft/delete/clients', [Clients::class, 'softDelete'])->name('clients.soft.delete');
    Route::any('untrash/clients/{id}', [Clients::class, 'untrash'])->name('clients.untrash');
    Route::delete('force/delete/clients/{id}', [Clients::class, 'forceDelete'])->name('clients.force.delete');
    Route::get('ajax/name/clients', [Clients::class, 'ajax_name_clients'])->name('ajax.name.clients');
    Route::get('ajax/date/clients', [Clients::class, 'ajax_date_clients'])->name('ajax.date.clients');
    Route::get('search/clients', [Clients::class, 'search_clients'])->name('search.clients');
    Route::get('search/clients/auction', [Clients::class, 'search_clients_auctions'])->name('search.clients.auctions');
    Route::get('search/products/auction', [Clients::class, 'search_products_auctions'])->name('search.products.auctions');
    Route::get('new-search/clients/auction', [Clients::class, 'new_search_clients_auctions'])->name('new.search.clients.auctions');

    /* Invoices **/
    Route::resource('invoices', Invoices::class);
    Route::get('track_invoices', [Invoices::class, 'trackInvoice'])->name('track_invoice');
    Route::any('detailes/invoices/{invoice_id}/{client_id}', [Invoices::class, 'detailsInvoices'])->name('detailes.invoices');
    Route::get('edit/products/invoices/{invoice_id}/{client_id}', [Invoices::class, 'editProducts'])->name('edit.products.invoices');
    Route::post('update/products/invoices/{invoice_id}', [Invoices::class, 'updateProducts'])->name('update.products.invoices');
    Route::delete('delete-all', [Invoices::class, 'deleteAll'])->name('delete.all.invoices');
    Route::get('print/invoices/{id}', [Invoices::class, 'printInvoices'])->name('print.invoices');
    Route::get('report/invoices', [Invoices::class, 'reportInvoices'])->name('report.invoices');
    Route::any('report/ajax/invoices', [Invoices::class, 'reportAjaxInvoices'])->name('report.ajax.invoices');
    Route::any('print-invoices', [Invoices::class, 'printInvoice'])->name('print.invoices');
    /* @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@2 */

    /* Mangers */
    //Route::resource('mangers', Mangers::class);
    /* Employees */
    Route::resource('employees', Employees::class);
    Route::get('shift/morning/employees', [Employees::class, 'shift_morning'])->name('shift.morning');
    Route::get('shift/evening/employees', [Employees::class, 'shift_evening'])->name('shift.evening');
    Route::get('mangers', [Employees::class, 'usersMangers'])->name('admin.mangers');
    Route::get('soft/delete/employees', [Employees::class, 'softDelete'])->name('employees.soft.delete');
    Route::any('untrash/employees/{id}', [Employees::class, 'untrash'])->name('employees.untrash');
    Route::delete('force/delete/employees/{id}', [Employees::class, 'forceDelete'])->name('employees.force.delete');
    Route::any('update/shift/employees/{id}', [Employees::class, 'updateSheift'])->name('update.shift');

    /* Settings */
    Route::resource('settings', Settings::class);

    /* Logout **/
    Route::get('logout', [Login::class, 'logout'])->name('logout');
    Route::get('logout-auction', [Login::class, 'logoutAuction'])->name('logout.auction');
    Route::get('logout-delivery', [Login::class, 'logoutDelivery'])->name('logout.delivery');


    Route::get('get-clients-data', [Clients::class, 'getClientsData'])->name('getClientsData');
    Route::get('get-products-data', [Clients::class, 'getProductsData'])->name('getProductsData');

});

Route::group(['middleware' => 'guest:admin,auction,delivery'], function () {

    /* Auth Routes **/
    Route::get('/', [Login::class, 'selection'])->name('selection');
    Route::get('/auth/{type}', [Login::class, 'login'])->name('login');
    Route::post('login/auth', [Login::class, 'login_auth'])->name('login.auth');
    Route::get('regsiter/client', [Clients::class, 'checkClient'])->name('check.client');

});

Route::post('regsiter/client/store', [Clients::class, 'storeCheckClient'])->name('store.check.client');
Route::get('show/area/clients', [Clients::class, 'show_area_clients'])->name('show.area.clients');

Route::get('test', function () {
    return view('pages.invoices.print_track_invoices');
});


Route::get('/migrate', function () {
    Artisan::call('migrate');
    return 'true';
});
