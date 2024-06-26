<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\OrderedMedicine;
use App\Models\Pharmacy;
use App\Models\PharmacyOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ChMessage;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $userId = Auth::id();
          // Find the pharmacy associated with the logged-in user
    $pharmacy = Pharmacy::where('user_id', $userId)->first();

    if ($pharmacy) {

          $order = PharmacyOrder::where('pharmacy_id', $pharmacy->id)->withTrashed()->get();

        $orderedMedicine = OrderedMedicine::with('orders')->get();

        return view('layout.order', compact('order','orderedMedicine'));
    }

    }

    public function completeOrder(){
        $userId = Auth::id();
  $pharmacy = Pharmacy::where('user_id', $userId)->first();
        $trashedOrder = PharmacyOrder::where('pharmacy_id', $pharmacy->id)->onlyTrashed()->get();
        $orderedMedicine = OrderedMedicine::with('orders')->get();

        return view('layout.complete_order',compact('trashedOrder','orderedMedicine'));
    }

    public function pendingOrder(){
        $userId = Auth::id();
        $pharmacy = Pharmacy::where('user_id', $userId)->first();
        $pendingOrder = PharmacyOrder::where('pharmacy_id', $pharmacy->id)->get();
        $orderedMedicine = OrderedMedicine::with('orders')->get();

        return view('layout.pending_order',compact('pendingOrder','orderedMedicine'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //it should be from the app side of the patient
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // the same for the create ,should be from the app
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $timestamp)
    {

        $orderedMedicine = PharmacyOrder::where('created_at', '=', Carbon::createFromTimestamp($timestamp))->get();

        $order = PharmacyOrder::findOrFail($id);
        $totalPrice = $orderedMedicine->sum('medicinePrice');

        return view('layout.order_details', compact('order','orderedMedicine','totalPrice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
  

    public function completeOrderAndSendMessage(Request $request, string $id, $timestamp)
{


    // Validate the request data
    $request->validate([
        'message' => 'required|string',
        'from_id' => 'required|integer',
        'to_id' => 'required|integer',
    ]);

    // Create and save the chat message
    $chat = new ChMessage();
    $chat->body = $request->input('message');
    $chat->from_id = $request->input('from_id');
    $chat->to_id = $request->input('to_id');
    $chat->seen = false;
    $chat->created_at = now();
    $chat->save();

    // Process the order
    // $orders = OrderedMedicine::all();
    $orders =  OrderedMedicine::where('created_at', '=', Carbon::createFromTimestamp($timestamp))->where('id',$id)->get();

        foreach ($orders as $ordered) {
            $medicineName = $ordered->medicineName;

            $stock = Medicine::where('medicine_name', $medicineName)->first();

            if (!$stock) {
                return redirect()->back()->with('error', "Stock for medicine $medicineName is not found");
            }

            // Decrease the stock quantity by one
            $stock->quantity -= 1;
            $stock->save();
        }

        $order = PharmacyOrder::findOrFail($id);

           // Get the user ID from the order and futa ile list of order
        $userId = $order->user_id;
         DB::table('ordered_medicines')->where('pharmacy_order_id', $userId)->where('created_at', '=', Carbon::createFromTimestamp($timestamp))->delete();


        // $order->delete();
        PharmacyOrder::where('user_id', $userId)->where('created_at', '=', Carbon::createFromTimestamp($timestamp))->delete();

        return redirect()->route('order.index')->with('success',"Order completed successfully");
}
}
