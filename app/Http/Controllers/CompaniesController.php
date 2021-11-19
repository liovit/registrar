<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\CompaniesRequest;
use Illuminate\Support\Facades\Session;
use File;
use Illuminate\Support\Facades\DB;

class CompaniesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        $locale = $this->getUserLocale();
        return view('companies/index', compact('companies', 'locale'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompaniesRequest $request)
    {

        $locale = $this->getUserLocale();

        if($request->file('logo')) {

            $imagePath = $this->handleImageUpload($request->logo);

            Company::create([
                'title' => $request->title,
                'email' => $request->email,
                'web_url' => $request->web_url,
                'logo' => $imagePath
            ]);

        } else {
            Company::create($request->all());
        }

        // $details = ['company' => $request->title];
        // \Mail::to($request->email)->send(new \App\Mail\RegisteredCompanyMail($details));

        if($locale == 'en') return redirect()->route('companies.index')->with('status', 'Successfully created new company.');
        if($locale == 'lt') return redirect()->route('companies.index')->with('status', 'Sėkmingai sukurta nauja įmonė.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        if($company) {
            return view('companies/view', compact('company'));
        } else {
            return redirect()->back();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $company = Company::find($id);

        if($company) {
            return view('companies/edit', compact('company'));
        } else {
            return redirect()->back();
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompaniesRequest $request, $id)
    {

        $company = Company::find($id);
        $locale = $this->getUserLocale();

        if($company) {

            if($request->file('logo')) {

                $this->deleteFile($company->logo);
                $imagePath = $this->handleImageUpload($request->logo);
    
                $company->update([
                    'title' => $request->title,
                    'email' => $request->email,
                    'web_url' => $request->web_url,
                    'logo' => $imagePath
                ]);
    
            } else {
                $company->update($request->all());
            }

        } else { return redirect()->back(); }

        if($locale == 'en') return redirect()->back()->with('status', 'Successfully updated company.');
        if($locale == 'lt') return redirect()->back()->with('status', 'Sėkmingai atnaujinta įmonė.');

    }

    // confirm if you'd like to delete this company
    public function delete($id) {

        $company = Company::find($id);

        if($company) {
            return view('companies/delete', compact('company'));
        } else {
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $locale = $this->getUserLocale();
        $company = Company::find($id);

        if($company) {

            $workers = DB::table('workers')->where('company_id', '=', $company->id)->get();

            if(count($workers) <= 0) {

                if($company->logo) {
                    $this->deleteFile($company->logo);
                }
    
                $company->delete();

                if($locale == 'en') return redirect()->route('companies.index')->with('status', 'The company was successfully deleted.');
                if($locale == 'lt') return redirect()->route('companies.index')->with('status', 'Įmonė buvo sėkmingai ištrinta.');

            } else {

                if($locale == 'en') return redirect('/companies')->with('status', 'This company still has workers, un-assign them in order to delete the company.');
                if($locale == 'lt') return redirect('/companies')->with('status', 'Ši įmonė vis dar turi darbuotojų, prašome pašalinti juos jei norite ištrinti įmonę.');

            }

        } else { return redirect()->back(); }

    }

    // function to handle image upload
    public function handleImageUpload($image) {

        $imageName = time().'-'.$image->getClientOriginalName();
        $path = $image->storeAs('logos', $imageName, 'public');
        $imgPath = '/storage/' . $path;

        return $imgPath;

    }

    // get user local language
    public function getUserLocale() {

        $locale = Session::get('locale');
        return $locale;

    }

    // delete file function
    public function deleteFile($path) {

        File::delete(public_path($path));

    }

}
