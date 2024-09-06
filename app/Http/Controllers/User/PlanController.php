<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\UserPlans;
use Stripe\Charge;
use Stripe\Exception\CardException;
use Stripe\Stripe as StripeStripe;
use Illuminate\Http\Request;
use Session;
use Stripe;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;


class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('user.plans.index', compact('plans'));
    }

    public function subscribe(Request $request)
    {
        $user = $request->user();
        $plan = Plan::find($request->plan_id);

        if (is_null($user)) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }

        $stripe = new \Stripe\StripeClient("sk_test_51MrovhK74lFSh15wPCGvLl5aNeNN16z8rNXs8b8v2Au6YKiLihrzMKKX4ilj4gPaTkGCS3jLAorfEhlESaYLi3Ml00137FXzSt");

        try {
            // Create a Stripe customer if one doesn't exist
            if (empty($user->stripe_customer_id)) {
                $customer = $stripe->customers->create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
                $user->stripe_customer_id = $customer->id;
                $user->save();

                // Update stripeCustomerId to use the new customer ID
                $stripeCustomerId = $customer->id;
            } else {
                // Use the existing Stripe customer ID
                $stripeCustomerId = $user->stripe_customer_id;
            }

            // Create the subscription
            $stripeSubscription = $stripe->subscriptions->create([
                'customer' => $stripeCustomerId, 
                'items' => [
                    [
                        'price' => $plan->price
                    ],
                ],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Save the subscription in the user plans table
            $user->plans()->attach($plan->id, [
                'stripe_subscription_id' => $stripeSubscription->id,
                'status' => 'active',
            ]);

            // Return success response
            return redirect()->back()->with('success', 'Plan subscribed successfully.');
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle Stripe API errors
            return redirect()->back()->with('error', 'Subscription failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle other errors
            return redirect()->back()->with('error', 'Subscription failed: ' . $e->getMessage());
        }
    }


    public function stripe($id)
    {
        $plan = Plan::where("id", $id)->first();
        return view('user.plans.stripe', compact('plan'));
    }

    public function stripePost(Request $request)
    {
        StripeClient::setApiKey("sk_test_51MrovhK74lFSh15wPCGvLl5aNeNN16z8rNXs8b8v2Au6YKiLihrzMKKX4ilj4gPaTkGCS3jLAorfEhlESaYLi3Ml00137FXzSt");

        try {
            // Validate if stripeToken exists in the request
            if (!$request->has('stripeToken')) {
                return redirect()->back()->with('error', 'Payment failed: Token not provided.');
            }

            // Create a charge
            $charge = Charge::create([
                'amount' => 100 * 100, // Amount in cents (e.g., $100.00)
                'currency' => 'usd',
                'source' => $request->stripeToken, // Token from Stripe.js
                'description' => 'Test payment from your app.',
            ]);

            // Payment was successful
            Session::flash('success', 'Payment successful!');
            return redirect()->back();
        } catch (CardException $e) {
            // Handle card exception errors
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}
