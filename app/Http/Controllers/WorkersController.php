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
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = Worker::all();
        $locale = $this->getUserLocale();
        return view('workers/index', compact('workers', 'locale')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
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

        $locale = $this->getUserLocale();

        Worker::create($request->all());

        if($locale == 'en') return redirect()->route('workers.index')->with('status', 'Successfully added new worker.');
        if($locale == 'lt') return redirect()->route('workers.index')->with('status', 'Sėkmingai pridėtas naujas darbuotojas.');

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
        $locale = $this->getUserLocale();

        if($worker) {

            $worker->update($request->all());

        } else { return redirect()->back(); }

        if($locale == 'en') return redirect()->back()->with('status', 'Successfully updated worker information.');
        if($locale == 'lt') return redirect()->back()->with('status', 'Sėkmingai atnaujinta darbuotojo informacija.');

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

    // get user local language
    public function getUserLocale() {

        $locale = Session::get('locale');
        return $locale;

    }

}
