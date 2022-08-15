<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use MongoDB\Driver\Session;

class ListingController extends Controller
{
    //show all listings
    public function index() {
        return view('listings.index',[
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(10)
        ]);
    }

    // show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show create form
    public function create() {
        return view('listings.create');
    }

    // Store listing data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => ['required'],
            'company' => ['required', Rule::unique('listings','company')],
            'location' => ['required'],
            'email' => ['required', 'email'],
            'website' => ['required'],
            'tags' => ['required'],
            'description' => ['required'],
        ]);

        Listing::create($formFields);

        return redirect('/')->with('message','Listing created');
    }
}
