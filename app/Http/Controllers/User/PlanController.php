<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\UserPlans;
use Illuminate\Http\Request;
use Session;
use Stripe;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('user.plans.index', compact('plans'));
    }

    public function subscribe(Request $request, Plan $plan)
    {
        $stripeCustomerId = $request->user()->stripe_customer_id;

        if (empty($stripeCustomerId)) {
            return redirect()->back()->with('error', 'Stripe customer ID is missing.');
        }

        $stripe = new \Stripe\StripeClient("sk_test_51MrovhK74lFSh15wPCGvLl5aNeNN16z8rNXs8b8v2Au6YKiLihrzMKKX4ilj4gPaTkGCS3jLAorfEhlESaYLi3Ml00137FXzSt");

        $stripeSubscription = $stripe->subscriptions->create([
            'customer' => $stripeCustomerId,
            'items' => [['price' => $plan->stripe_product_id]],
        ]);

        $request->user()->plans()->attach($plan->id, [
            'stripe_subscription_id' => $stripeSubscription->id,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Plan subscribed successfully.');
    }

    public function stripe($id)
    {
        $plan = Plan::where("id", $id)->first();
        return view('user.plans.stripe', compact('plan'));
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey("sk_test_51MrovhK74lFSh15wPCGvLl5aNeNN16z8rNXs8b8v2Au6YKiLihrzMKKX4ilj4gPaTkGCS3jLAorfEhlESaYLi3Ml00137FXzSt");

        Stripe\Charge::create([
            "amount" => 100 * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Test payment from itsolutionstuff.com."
        ]);

        Session::flash('success', 'Payment successful!');

        return back();
    }
}
