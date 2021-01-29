<?php

namespace App\Http\Controllers;

use App\Suppliers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class OrdersController extends Controller
{
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
                        $edit = '<a href="#" class="update" id="' . $main->id . '" data-toggle="modal" data-target="#editOrder"><i class="fa fa-edit"></i></a>';
                        $view = '<a href="/orders/' . $main->id . '/show" class="view" target="_blank"> <i class="fa fa-eye"></i></a>';
                        return $edit . ' ' . $view;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('orders.index', ['suppliers' => $suppliers]);
    }
}
