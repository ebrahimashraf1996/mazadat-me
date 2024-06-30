<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ManageInvoice;
use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\AuctionStage;
use App\Models\City;
use App\Models\Client;
use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Product;
use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\Pdf;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class Invoices extends Controller
{
    use ManageInvoice;

    public function index(Request $request)
    {
        $invoices = Invoice::filter($request->all())->with('auctionProducts', 'client')
            ->addSelect(['client_name' => Client::select('username')->whereColumn('id', 'invoices.client_id')->take(1)])
            ->addSelect(['client_phone' => Client::select('phone1')->whereColumn('id', 'invoices.client_id')->take(1)])
            ->orderBy('invoice_number', 'ASC');

        $clients = Client::select('id', 'name')->pluck('name', 'id')->toArray();
        return view('pages.invoices.index', [
            'invoices' => $invoices->paginate(),
            'clients' => $clients,
            'printData' => $invoices->get()
        ]);
    }

    public function create()
    {
        $cities = City::get();
        return view('pages.auctions.add', compact('cities'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'sometimes|nullable|email',
                'date' => 'sometimes|nullable',
                'link' => 'sometimes|nullable',
            ], [
                'required' => 'هذا الحقل مطلوب',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            Auction::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'date' => $request->date,
                'city_id' => $request->city_id,
                'details' => $request->details,
                'link' => $request->link,
            ]);

            alert()->success('تم الأضافة بنجاح');
            return redirect()->route('auctions.index');
        } catch (\Exception $ex) {
            return back()->withErrors($ex->getMessage())->withInput();
            alert()->error('عفوا هناك خطأ تقني');
            return redirect()->route('auctions.index');
        }
    }

    public function update(Request $request, $id)
    {
//        return $request;
        try {

            $validator = Validator::make($request->all(), [
                'delivery_id' => 'sometimes|nullable',
                'delivery_date' => 'sometimes|nullable',
                'delivery_price' => 'sometimes|nullable',
                'payment' => 'sometimes|nullable',
                'status_invoice' => 'required',
                'order_date' => 'required_if:status_invoice,==,delared'
            ], [
                'order_date.required_if' => 'هذا الحقل مطلوب',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $invoice = Invoice::with('auctionProducts')->where('id', $id)->first();
//            $invoice->update([
//                'delivery_id' => $request->has('delivery_id') === true
//                    ? $request->delivery_id
//                    : $invoice->delivery_id,
//                'delivery_date' => $request->delivery_date,
//                'delivery_price' => $request->delivery_price,
//                'payment' => $request->payment,
//                'status_invoice' => $request->status_invoice,
//                'order_date' => $request->has('order_date') == true && $request->order_date != null
//                    ? $request->order_date
//                    : $invoice->order_date,
////                'auction_stage_id' => $request->auction_stage_id
//            ]);
            if ($request->auction_stage_id != $invoice->auction_stage_id) {
                $old = $invoice->auction_stage_id;
                $new = $request->auction_stage_id;
                $stage = AuctionStage::find($new);
//                return $stage->invoices->max('invoice_number');
                $invoice->invoice_number = $stage->invoices->max('invoice_number') + 1;
                $invoice->auction_stage_id = $new;
                $invoice->save();
                foreach ($invoice->auctionProducts as $product_old) {
                    $product_old->auction_stage_id = $new;
                    $product_old->save();
                }
//                return $invoice;
            }


            $data = $request['row'];
            foreach($data as $key => $row){
                $product = $this->checkProduct($row['product']);
                AuctionProduct::where('id',$key)->update([ 'count_pieces' => $row['count_pieces'] , 'price' => $row['price'] , 'product_id' => $product ]);
            }


            alert()->success('تم التحديث بنجاح');
            return back();

        } catch (\Exception $ex) {
            alert()->error('عفوا هناك خطأ تقني');
            return back();
        }
    }

    public function destroy($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        AuctionProduct::where('auction_id', $invoice->auction_id)->where('client_id', $invoice->client_id)->where('auction_date', $invoice->auction_date)->delete();
        $invoice->delete();
        alert()->success('تم الحذف بنجاح');

        return back();
    }

    public function deleteAll(Request $request)
    {
        $ids = json_decode($request->selected, true);
        AuctionProduct::whereIn('invoice_id', $ids)->delete();
        Invoice::whereIn('id', $ids)->delete();
        alert()->success('تم المسح بنجاح');
        return back();
    }

    public function reportInvoices()
    {
        $invoices = Invoice::get();
        return view('pages.reports.invoices', compact('invoices'));
    }

    public function reportAjaxInvoices(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $code_auction = $request->code_auction;
        $invoice_number = $request->invoice_number;
        $auction_id = $request->auction_id;
        $client = $request->client;

        if (Auth::guard('admin')->check()) {
            if ($auction_id != null) {
                $invoices = Invoice::when($request->filled('date_from'), function ($query) use ($date_from) {
                    $query->whereDate('auction_date', '>=', $date_from);
                })
                    ->when($request->filled('date_to'), function ($query) use ($date_to) {
                        $query->whereDate('auction_date', '<=', $date_to);
                    })
                    ->when($request->filled('invoice_number'), function ($query) use ($invoice_number) {
                        $query->where('invoice_number', $invoice_number);
                    })
                    ->when($request->filled('code_auction'), function ($query) use ($code_auction) {
                        $query->whereHas('auction', function ($q) use ($code_auction) {
                            $q->where('code', $code_auction);
                        });
                    })
                    ->when($request->filled('client'), function ($query) use ($client) {
                        $query->whereHas('client', function ($q) use ($client) {
                            $q->where('id', $client);
                        });
                    })
                    ->where('auction_id', $auction_id)
                    ->get();

            } else {
                $invoices = Invoice::when($request->filled('date_from'), function ($query) use ($date_from) {
                    $query->whereDate('auction_date', '>=', $date_from);
                })
                    ->when($request->filled('date_to'), function ($query) use ($date_to) {
                        $query->whereDate('auction_date', '<=', $date_to);
                    })
                    ->when($request->filled('invoice_number'), function ($query) use ($invoice_number) {
                        $query->where('invoice_number', $invoice_number);
                    })
                    ->when($request->filled('code_auction'), function ($query) use ($code_auction) {
                        $query->whereHas('auction', function ($q) use ($code_auction) {
                            $q->where('code', $code_auction);
                        });
                    })
                    ->when($request->filled('client'), function ($query) use ($client) {
                        $query->whereHas('client', function ($q) use ($client) {
                            $q->where('id', $client);
                        });
                    })
                    ->get();
            }
        } else {
            $invoices = Invoice::where('auction_id', Auth::guard('auction')->user()->id)
                ->when($request->filled('date_from'), function ($query) use ($date_from) {
                    $query->whereDate('auction_date', '>=', $date_from);
                })
                ->when($request->filled('date_to'), function ($query) use ($date_to) {
                    $query->whereDate('auction_date', '<=', $date_to);
                })
                ->when($request->filled('invoice_number'), function ($query) use ($invoice_number) {
                    $query->where('invoice_number', $invoice_number);
                })
                ->when($request->filled('code_auction'), function ($query) use ($code_auction) {
                    $query->whereHas('auction', function ($q) use ($code_auction) {
                        $q->where('code', $code_auction);
                    });
                })->get();
        }

        $invoices_id = [];
        foreach ($invoices as $invoice) {
            $invoices_id[] = $invoice->id;
        }

        $html = view('pages.reports.ajax_invoices', compact('invoices'))->render();
        return response()->json(['status' => true, 'result' => $html]);
    }

    /** Print Invoice */
    public function printInvoice(Request $request)
    {
        if (file_exists(base_path('public/invoice.pdf'))) {
            File::delete(base_path('public/invoice.pdf'));
        }
        $data = [
            'invoices' => Invoice::whereIn('id', $request->invoices_id)->with(['auctionProducts' => function ($q) {
                $q->where('is_return', 0);
            }])->get(),
        ];
        // $pdf = Pdf::loadView('pages.invoices.print_invoice2', $data);
        $reportHtml = view('pages.invoices.print_invoice3', $data)->render();
        $arabic = new Arabic();
        $p = $arabic->arIdentify($reportHtml);
        for ($i = count($p) - 1; $i >= 0; $i -= 2) {
            $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i - 1], $p[$i] - $p[$i - 1]));
            $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i - 1], $p[$i] - $p[$i - 1]);
        }
        $pdf = PDF::loadHtml($reportHtml);

        $pdf->save(base_path('public/invoice.pdf'));
        return redirect(asset('invoice.pdf'));
    }

}
