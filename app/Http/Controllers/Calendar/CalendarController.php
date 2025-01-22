<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feed = Calendar::all()->toArray();
        return view('calendar.index', compact('feed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $feed = Calendar::create($request->all());
        return redirect()->back()->with('toast', [
            'icon' => 'success',
            'mensaje' => 'Feed añadido correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $feed = Calendar::findOrFail($id);
        if(!isset($feed)){
            return response()->json(['ok' => false ]);
        }
        $feed->delete();
        return response()->json(['ok' => true]);
    }
}
