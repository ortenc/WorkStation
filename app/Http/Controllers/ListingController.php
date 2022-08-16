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

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message','Listing created');
    }

    // Show edit form
    public function edit(Listing $listing) {

        return view('listings.edit', ['listing' => $listing]);
    }

    // Update edit form
    public function update(Request $request,Listing $listing) {

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized action');
        }

        $formFields = $request->validate([
            'title' => ['required'],
            'company' => ['required'],
            'location' => ['required'],
            'email' => ['required', 'email'],
            'website' => ['required'],
            'tags' => ['required'],
            'description' => ['required'],
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $listing->update($formFields);

        return back()->with('message','Listing updated');
    }

    public function destroy(Listing $listing){

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized action');
        }

        $listing->delete();
        return redirect('/')->with('message','Deleted');
    }

    // manage listing
    public function manage(){
        return view('listings.manage',['listings' => auth()->user()->listings()->get()]);
    }
}
