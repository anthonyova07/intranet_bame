<?php

namespace Bame\Http\Controllers\Customer;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;
use Bame\Models\Customer\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customer = null;

        $ibs = true;

        if ($request->identification) {
            $identification = remove_dashes($request->identification);

            $customer = Customer::where('cusln3', $identification)
                ->orWhere('cusidn', $identification)
                ->first();

            if (!$customer) {
                $customer_census = DB::connection('ibs')
                    ->table('bagrplib.cedpad')
                    ->select('*')
                    ->where('cedidn', $identification)
                    ->first();

                if ($customer_census) {
                    $customer = new Customer();
                    $customer->setCustomerFromCensus($customer_census);
                    $ibs = false;
                }
            }
        }

        if ($customer) {
            copy(Customer::getPhoto($customer->getDocument()), public_path('images\temporal.jpg'));

            $customer->photo = route('home') . '/images/temporal.jpg';
        }

        return view('customer.index')
            ->with('customer', $customer)
            ->with('ibs', $ibs);
    }
}
