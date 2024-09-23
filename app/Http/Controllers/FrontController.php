<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Models\Category;
use App\Models\Donatur;
use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $fundraisings = Fundraising::with(['category', 'fundraiser'])
        ->where('is_active', 1)
        ->orderByDesc('id')
        ->get();

        return view('fronts.views.index', compact('categories', 'fundraisings'));
    }

    public function category(Category $category)
    {
        return view('fronts.views.category', compact('category'));
    }

    public function details(Fundraising $fundraising)
    {
        return view('fronts.views.details', compact('fundraising'));
    }

    public function support(Fundraising $fundraising)
    {
        return view('fronts.views.donation', compact('fundraising'));
    }

    public function checkout(Fundraising $fundraising, $totalAmountDonation)
    {
        return view('fronts.views.checkout', compact('fundraising', 'totalAmountDonation'));
    }

    public function store(StoreDonationRequest $request, Fundraising $fundraising, $totalAmountDonation){
        
        DB::transaction(function() use ($request, $fundraising, $totalAmountDonation)
        {
            $validated = $request->validated();

            if($request->hasFile('proof')){
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] =$proofPath;
            }

            $validated['fundraising_id'] =$fundraising->id;
            $validated['total_amount'] = $totalAmountDonation;
            $validated['is_paid'] = false;

            $donatur = Donatur::create($validated);
        });
        return redirect()->route('front.details', $fundraising->slug);
    }
}
