<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisposalStatus;

class DisposalStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = DisposalStatus::all(); // Fetch all statuses
        return view('disposal-statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('disposal-statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:disposal_statuses,name|max:255',
        ]);
    
        DisposalStatus::create($request->only('name'));
    
        return redirect()->route('disposal-statuses.index')->with('success', 'Disposal status created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DisposalStatus $disposalStatus)
    {
        return view('disposal-statuses.edit', compact('disposalStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,DisposalStatus $disposalStatus)
    {
        $request->validate([
            'name' => 'required|string|unique:disposal_statuses,name,' . $disposalStatus->id . '|max:255',
        ]);
    
        $disposalStatus->update($request->only('name'));
    
        return redirect()->route('disposal-statuses.index')->with('success', 'Disposal status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DisposalStatus $disposalStatus)
    {
        if ($disposalStatus->history()->exists()) {
            return redirect()->route('disposal-statuses.index')->with('error', 'Cannot delete status linked to histories.');
        }
    
        $disposalStatus->delete();
    
        return redirect()->route('disposal-statuses.index')->with('success', 'Disposal status deleted successfully.');
    }
}
