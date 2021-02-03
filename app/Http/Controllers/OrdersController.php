<?php

namespace App\Http\Controllers;

use App\CompanyInfo;
use App\Countries;
use App\Order;
use App\OrderDetail;
use App\Suppliers;
use App\Traits\Translatable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use OwenIt\Auditing\Models\Audit;
use domPDF;


class OrdersController extends Controller
{
    use Translatable;

    protected $dictionary = [
        'company_info_id' => ['Firma', 'App\CompanyInfo', 'name'],
        'supplier_id' => ['Furnizor', 'App\Suppliers', 'name'],
        'order_id' => ['Comanda', 'App\Order', 'order'],
    ];

    /**
     * Return a listing of the orders for the selected mill
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $suppliers = Suppliers::all();

        if ($request->ajax()) {
            $company = request()->session()->get('company_was_selected');
            $main = DB::table('orders')
            ->where('company_info_id', $company)
                ->leftJoin('suppliers', 'orders.supplier_id', '=', 'suppliers.id')
                ->select([
                    'orders.id as id',
                    'orders.company_info_id as company_id',
                    'suppliers.name as supplier',
                    'orders.order as order',
                    'orders.order_date as order_date',
                    'orders.destination as destination',
                    'orders.delivery_term as delivery_term',
                    'orders.incoterms as incoterms',
                ])->orderBy('orders.created_at', 'DESC')
                ->get();

            $main->map(function($item, $index) {
                $item->ordered_volume = DB::table('order_details')->where('order_id', $item->id)->sum('ordered_volume');
                $item->confirmed_volume = DB::table('order_details')->where('order_id', $item->id)->sum('confirmed_volume');
                $item->delivered_volume = DB::table('order_details')->where('order_id', $item->id)->sum('delivered_volume');
            });

            return DataTables::of($main)
                ->editColumn('order_date', function ($main) {
                    return $main->order_date ? with(new Carbon($main->order_date))->format('d.m.Y') : '';
                })
                ->addColumn('action', function ($main) {
                        $edit = '<a href="#" class="edit" id="' . $main->id . '" data-toggle="modal" data-target="#editOrdersForm"><i class="fa fa-edit"></i></a>';
                        $view = '<a href="/orders/' . $main->id . '/show" class="view" target="_blank"> <i class="fa fa-eye"></i></a>';
                        return $edit . ' ' . $view;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('orders.index', ['suppliers' => $suppliers]);
    }

    /**
     * Fetch a order entry
     *
     * @param Request $request
     * @return App\Order
     */
    public function fetch(Request $request)
    {
        return Order::find($request->id);
    }

    /**
     * Fetch a order position
     *
     * @param Request $request
     * @return App\OrderDetail
     */
    public function fetchDetail(Request $request)
    {
        return OrderDetail::find($request->id);
    }

    /**
     * Show the order page
     *
     * @param int $id
     * @return view()
     */
    public function show($id)
    {
        $order = Order::find($id);
        $company = CompanyInfo::find($order->company_info_id);
        $supplier = Suppliers::find($order->supplier_id);
        $order_details = OrderDetail::where('order_id', $order->id)->get();
        $order_details->map(function($item, $index) {
            $item->value = $item->ordered_volume * $item->price;
        });
        $total_ordered = DB::table('order_details')->where('order_id', $order->id)->sum('ordered_volume');
        $total_confirmed = DB::table('order_details')->where('order_id', $order->id)->sum('confirmed_volume');
        $total_delivered = DB::table('order_details')->where('order_id', $order->id)->sum('delivered_volume');
        $total_value = $order_details->sum('value');

        // get the audits
        $audit_order = $this->displayHistoryOrder($order->id);
        $audit_order_details = $this->displayHistoryOrderDetails($order->id, $order->created_at);

        return view('orders.show', [
            'order' => $order,
            'company' => $company,
            'supplier' => $supplier,
            'order_details' => $order_details,
            'total_ordered' => $total_ordered,
            'total_confirmed' => $total_confirmed,
            'total_delivered' => $total_delivered,
            'total_value' => $total_value,
            'audit_order' => $audit_order,
            'audit_order_details' => $audit_order_details,
            ]);
    }

    /**
     * Store the order inside the DB
     *
     * @param Order $order
     * @param Request $request
     * @return redirect
     */
    public function store(Order $order, Request $request)
    {
        $company_id = request()->session()->get('company_was_selected');
        $company = CompanyInfo::find($company_id);
        $now = Carbon::now()->toDate();
        $year = Carbon::now()->year;

        $order->company_info_id = $company->id;
        $order->order = $this->getNumber($company);
        $order->order_year = $year;
        $order->order_date = $now;
        $order->supplier_id = $request->supplier_id;
        $order->destination = $request->destination;
        $order->delivery_term = $request->delivery_term;
        $order->incoterms = $request->incoterms;
        $order->save();

        if ($request->position[0] != null && $request->price != null && $request->currency != null) {
            for ($i=0; $i < count($request->position); $i++) {
                $detail = new OrderDetail();
                $detail->order_id = $order->id;
                $detail->position = $request->position[$i];
                $detail->dimensions = $request->dimensions[$i];
                $detail->ordered_volume = $request->ordered_volume[$i];
                $detail->price = $request->price[$i];
                $detail->currency = $request->currency[$i];
                $detail->confirmed_volume = 0;
                $detail->delivered_volume = 0;
                $detail->save();
            }
        };

        return back();
    }

    /**
     * Returns the number of order
     *
     * @param [type] $label
     * @return void
     */
    public function getNumber($company)
    {
        $current_year = Carbon::now()->year;
        $index = Order::where('company_info_id', $company->id)->where('order_year', $current_year)->get();
        $number = $company->label . '-' . ($index->count() + 1);

        return $number;
    }

    /**
     * Save the details for the order
     *
     * @param int $id
     * @param Request $request
     * @return redirect
     */
    public function storeDetails($id, Request $request)
    {
        $details = OrderDetail::create([
            'order_id' => $request->order_id,
            'position' => $request->position,
            'dimensions' => $request->dimensions,
            'ordered_volume' => $request->ordered_volume,
            'price' => $request->price,
            'currency' => $request->currency,
            'confirmed_volume' => $request->confirmed_volume,
            'delivered_volume' => 0
        ]);

        return back();
    }

    /**
     * Update the resource
     *
     * @param int $id
     * @param Request $request
     * @return redirect
     */
    public function update($id, Request $request)
    {
        $order = Order::find($id);
        $order->update([
            'supplier_id' => $request->supplier_id,
            'destination' => $request->destination,
            'delivery_term' => $request->delivery_term,
            'incoterms' => $request->incoterms,
        ]);

        return back();
    }

    /**
     * Update one detail
     *
     * @param Request $request
     * @return redirect
     */
    public function updateDetail(Request $request)
    {
        $details = OrderDetail::find($request->id);
        $details->update([
            'order_id' => $request->order_id,
            'position' => $request->position,
            'dimensions' => $request->dimensions,
            'ordered_volume' => $request->ordered_volume,
            'price' => $request->price,
            'currency' => $request->currency,
            'confirmed_volume' => $request->confirmed_volume,
        ]);

        return back();
    }

    /**
     * Add delivery to order position
     *
     * @param Request $request
     * @return redirect
     */
    public function addDelivery(Request $request)
    {
        $detail = OrderDetail::find($request->delivery_id);
        $detail->delivered_volume = $request->delivered_volume;
        $detail->save();

        return back();
    }

    /**
     * Delete a position from the order
     *
     * @param Request $request
     * @return redirect
     */
    public function destroy(Request $request)
    {
        $detail = OrderDetail::find($request->delete_id);
        $detail->delete();

        return back();
    }

    public function print(Order $order, $language)
    {
        $company = CompanyInfo::find($order->company_info_id);
        $supplier = Suppliers::find($order->supplier_id);
        $country = Countries::find($supplier->country_id);
        $details = OrderDetail::where('order_id', $order->id)->get();
        $total_volume = $details->sum('ordered_volume');

        $data = [
            'company' => $company,
            'supplier' => $supplier,
            'country' => $country,
            'order' => $order,
            'details' => $details,
            'total_volume' => $total_volume,
        ];

        $pdf = domPDF::loadView('orders.print_' . $language, $data);
        return $pdf->stream();
    }

    /**
     * Display the auditable data for the order
     *
     * @param $order
     * @return array
     */
    protected function displayHistoryOrder(int $order)
    {
        $collection = Audit::where('auditable_type', 'App\Order')->where('auditable_id', $order)->get();
        $history = [];

        foreach ($collection as $data) {
            $old = [];
            foreach ($data->old_values as $old_key => $old_value) {
                $translated = $this->translate($old_key);
                if ($translated == null) {
                    $old[$old_key] = $old_value;
                } else {
                    $valoare = $translated[1]::where('id', $old_value)->get()->pluck($translated[2]);
                    $old[$translated[0]] = $valoare[0];
                }
            }

            $new = [];
            foreach ($data->new_values as $new_key => $new_value) {
                $translated = $this->translate($new_key);
                if ($translated == null) {
                    $new[$new_key] = $new_value;
                } else {
                    $valoare = $translated[1]::where('id', $new_value)->get()->pluck($translated[2]);
                    $new[$translated[0]] = $valoare[0];
                }
            }

            array_push($history, [
                'user' => $data->user->name,
                'event' => $data->event,
                'old_values' => $old,
                'new_values' => $new,
                'created_at' => $data->created_at->toDateTimeString()
            ]);
        }

        return $history;
    }

    /**
     * Display the auditable data for the order details
     *
     * @param $orderDetails
     * @param $date
     * @return array
     */
    protected function displayHistoryOrderDetails(int $orderDetails, $date)
    {
        $collection = Audit::where('auditable_type', 'App\OrderDetail')->where('created_at', '>=', $date)->where('event', 'created')->get();
        $history = [];

        $details = [];
        foreach ($collection as $data) {
            if ($data->new_values['order_id'] == $orderDetails) {
                array_push($details, $data->auditable_id);
            }
        }

        $collection = Audit::where('auditable_type', 'App\OrderDetail')->whereIn('auditable_id', $details)->get();

        foreach ($collection as $data) {
            $old = [];
            foreach ($data->old_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $old[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $old[$translated[0]] = $valoare[0];
                }
            }

            $new = [];
            foreach ($data->new_values as $key => $value) {
                $translated = $this->translate($key);
                if ($translated == null) {
                    $new[$key] = $value;
                } else {
                    $valoare = $translated[1]::where('id', $value)->get()->pluck($translated[2]);
                    $new[$translated[0]] = $valoare[0];
                }
            }

            array_push($history, [
                'user' => $data->user->name,
                'event' => $data->event,
                'old_values' => $old,
                'new_values' => $new,
                'created_at' => $data->created_at->toDateTimeString()
            ]);
        }

        return $history;
    }
}
