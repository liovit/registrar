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
        $this->middleware('locale');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $totalRecords = Company::count();
        return view('companies/index');
    }

    // ajax
    public function getCompanies(Request $request){
   
        // get values
        $columnNameArray    = $request->get('columns');
        $orderArray         = $request->get('order');
        $searchValue        = $request->search['value'];
   
        $columnIndex        = $orderArray[0]['column']; // column index
        $columnName         = $columnNameArray[$columnIndex]['data']; // column name
        $columnSortOrder    = $orderArray[0]['dir']; // asc or desc
   
        // total records
        $totalRecords         = Company::select('count(*) as allcount')->count();
        $totalFilteredRecords = Company::select('count(*) as allcount')->where('title', 'like', '%' . $searchValue . '%')->count();
   
        // fetch records
        $companies = Company::orderBy($columnName, $columnSortOrder)
            ->where('companies.title', 'like', '%' . $searchValue . '%')
            ->select('companies.*')
            ->skip($request->start)
            ->take($request->length)
            ->get();
   
        $dataArray = [];
        
        foreach($companies as $w) {

           $id      = $w->id;
           $title   = $w->title;
           $email   = $w->email;
           $webUrl  = $w->web_url;
           $rrdate  = \Carbon\Carbon::parse($w->created_at)->format('d/m/Y');
   
           $dataArray[] = [
                "id"        => $id,
                "title"     => $title,
                "email"     => $email,
                "web_url"   => $webUrl,
                "date"      => $rrdate,
           ];
        }
   
        $response = array(
           "draw" => intval($request->draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalFilteredRecords,
           "aaData" => $dataArray
        );
   
        return json_encode($response);

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

        return redirect()->route('companies.index')->with('status', 'Successfully created new company.');

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

        return redirect()->back()->with('status', 'Successfully updated company.');

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
        
        $company = Company::find($id);

        if($company) {

            $workers = DB::table('workers')->where('company_id', '=', $company->id)->get();

            if(count($workers) <= 0) {

                if($company->logo) {
                    $this->deleteFile($company->logo);
                }
    
                $company->delete();

                return redirect()->route('companies.index')->with('status', 'The company was successfully deleted.');

            } else {

                return redirect()->route('companies.index')->with('status', 'This company still has workers, un-assign them in order to delete the company.');

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

    // delete file function
    public function deleteFile($path) {

        File::delete(public_path($path));

    }

}
