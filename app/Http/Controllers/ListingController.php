<?php

namespace App\Http\Controllers;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class ListingController extends Controller
{
   public function index()
   {
    $listings = Listing::latest()->filter(request(["tag","search"]))->paginate(5);
    return view('home', compact('listings'));
   }
   public function show($id)
   {

    $listing = Listing::findOrFail($id);

    return view('show', compact('listing'));
   }
  public function create()
  {

    return view('create');
  }
  public function store(Request $request)
  {

    $formFields = $request->validate([
        'title'=> 'required',
        'company'=> ['required', Rule::unique('listings', 'company')],
        'location'=> 'required',
        'website'=> 'required',
        'email'=> ['required', 'email'],
        'tags'=> 'required',
        'description'=>'required',
    ]);
    if($request->hasFile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }
    $formFields['user_id'] = Auth::user()->id;
    $listing = Listing::create($formFields);
    return redirect()->route('home.index')->with('success','Gig created successfully');


  }
  public function edit($id){

    $listing = Listing::findOrFail($id);
    return view('edit', compact('listing'));
  }

  public function update(Request $request, Listing $listing)
  {
    //make sure logged user is the owner

    if($listing->user_id != Auth::user()->id){
        Abort(403, 'Unauthorized Action');
    }

    $formFields = $request->validate([
        'title'=> 'required',
        'company'=> ['required', Rule::unique('listings', 'company')],
        'location'=> 'required',
        'website'=> 'required',
        'email'=> ['required', 'email'],
        'tags'=> 'required',
        'description'=>'required',
    ]);
    if($request->hasFile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }
    $formFields['user_id'] = Auth::user()->id;
    $listing ->update($formFields);
    return back()->with('success','Listing Updated Successfully');


  }
  public function destroy($listing)
  {
    //make sure logged user is the owner

    if($listing->user_id != Auth::user()->id){
        Abort(403, 'Unauthorized Action');
    }

    $listing = Listing::findOrFail($listing->id);

    $listing->delete();
    return redirect()->route('home.index')->with('success','Gig deleted successfully');
  }

  public function manage()
  {
    $listings = Listing::where('user_id', Auth::user()->id)->get();
   //return json_decode($listing, true);
    return view('manage', compact('listings'));
  }
//   listing'=>Auth::user()->listing()()
}
