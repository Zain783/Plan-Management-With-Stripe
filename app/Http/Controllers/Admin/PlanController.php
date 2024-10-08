<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function create()
    {
        $plans = Plan::all();
        return view('admin.plans.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'features' => 'required',
        ]);

        $stripe = new \Stripe\StripeClient("sk_test_51MrovhK74lFSh15wPCGvLl5aNeNN16z8rNXs8b8v2Au6YKiLihrzMKKX4ilj4gPaTkGCS3jLAorfEhlESaYLi3Ml00137FXzSt");

        // Create Stripe Product
        $stripeProduct = $stripe->products->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        // Create Stripe Price for the Product
        $stripePrice = $stripe->prices->create([
            'product' => $stripeProduct->id,
            'unit_amount' => $validated['price'] * 100, // Stripe accepts amount in cents
            'currency' => 'usd',
        ]);

        // Save plan in the database
        Plan::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'features' => json_encode($validated['features']),
            'stripe_product_id' => $stripePrice->id, // Save Stripe Price ID
        ]);

        return redirect()->back()->with('success', 'Plan created successfully.');
    }
}
