<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Worker;
use App\Http\Requests\WorkersRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class WorkersController extends Controller
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
        return view('workers/index');
    }

    public function getWorkers(Request $request){
   
        $columnNameArray    = $request->get('columns');
        $orderArray         = $request->get('order');
        $searchValue        = $request->search['value'];
   
        $columnIndex        = $orderArray[0]['column']; // column index
        $columnName         = $columnNameArray[$columnIndex]['data']; // column name
        $columnSortOrder    = $orderArray[0]['dir']; // asc or desc
   
        // total records
        $totalRecords         = Worker::select('count(*) as allcount')->count();
        $totalFilteredRecords = Worker::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();
   
        // fetch records
        $workers = Worker::orderBy($columnName, $columnSortOrder)
            ->where('workers.name', 'like', '%' . $searchValue . '%')
            ->select('workers.*')
            ->skip($request->start)
            ->take($request->length)
            ->get();
   
        $dataArray = [];
        
        foreach($workers as $w) {

           $id      = $w->id;
           $name    = $w->name;
           $email   = $w->email;
           $phone   = $w->phone;
           $company = $w->company->title;
           $rrdate  = \Carbon\Carbon::parse($w->created_at)->format('d/m/Y');
   
           $dataArray[] = array(
                "id"        => $id,
                "name"      => $name,
                "email"     => $email,
                "phone"     => $phone,
                "company"   => $company,
                "date"      => $rrdate,
           );
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
        $companies = Company::orderBy('name')->pluck('name', 'id');
        return view('workers/create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkersRequest $request)
    {

        Worker::create($request->all());
        return redirect()->route('workers.index')->with('status', 'Successfully added new worker.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $worker = Worker::find($id);

        if($worker) {
            return view('workers/view', compact('worker'));
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

        $companies = Company::all();
        $worker = Worker::find($id);

        if($worker) {
            return view('workers/edit', compact('worker', 'companies'));
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
    public function update(WorkersRequest $request, $id)
    {

        $worker = Worker::find($id);

        if($worker) {

            $worker->update($request->all());

        } else { return redirect()->back(); }

        return redirect()->back()->with('status', 'Successfully updated worker information.');

    }

    // confirm if you'd like to delete this worker
    public function delete($id) {

        $worker = Worker::find($id);

        if($worker) {
            return view('workers/delete', compact('worker'));
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
        
        $worker = Worker::find($id);

        if($worker) {
            $worker->delete();
        } else {
            return redirect()->back();
        }

    }

}
