<?php

namespace App\Http\Controllers\API;

use App\DiscountList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Customer;
use App\Http\Resources\Customer as CustomerResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::get();
        return CustomerResource::collection($customer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $existingUser = $this->checkExistinUser($request);

            if ($existingUser) {
                return new CustomerResource($existingUser);
            }

            $discount_list = DiscountList::where('discount_count', '>', 0)->orderBy('discount_count', 'desc')->first();

            if (!$discount_list) {
                $errorObj = new \stdClass();
                $errorObj->error = "Sorry No More Discount Available.";
                return new CustomerResource($errorObj);
            }

            $customer = new Customer();
            $customer->name = $request->input('name');
            $customer->email = $request->input('email');
            $customer->phone = $request->input('phone');
            $customer->discount = $discount_list->discount_value;

            if ($customer->save()) {
                $discount_list->discount_count -= 1;
                $discount_list->save();
                return new CustomerResource($customer);
            }

        }
    }

    /**
     * Validate existing user;
     * @param $request
     * @return \stdClass
     */
    public function checkExistinUser($request)
    {
        $is_existing = Customer::where('email', $request->input('email'))
            ->where('phone', $request->input('phone'))->get();

        if (count($is_existing) > 0) {
            $errorObj = new \stdClass();
            $errorObj->error = "User Already exists with the email and Phone number";
            return $errorObj;
        }

        $is_email_existing = Customer::where('email', $request->input('email'))->get();
        if (count($is_email_existing) > 0) {
            $errorObj = new \stdClass();
            $errorObj->error = "User Already exists with the email";
            return $errorObj;
        }

        $is_phone_existing = Customer::where('phone', $request->input('phone'))->get();
        if (count($is_phone_existing) > 0) {
            $errorObj = new \stdClass();
            $errorObj->error = "User Already exists with the Phone number";
            return $errorObj;
        }
        return [];
    }
}
