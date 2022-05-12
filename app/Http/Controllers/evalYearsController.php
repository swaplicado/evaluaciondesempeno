<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Models\Year;

class evalYearsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = \DB::table('config_years as cy')
                    ->join('config_status as cs','cs.id_status','=','cy.status_id')
                    ->where('cy.is_deleted',0)
                    ->orderBy('cy.year')
                    ->get();
        return view('evalYears.index', ['years' => $years]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $year = Year::create([
                    'year' => $request->year,
                    'config' => 1,
                    'is_deleted' => 0,
                    'created_by' => Auth()->user()->id,
                    'updated_by' => Auth()->user()->id
                ]);
            });
            $msg = "Se guardó el registro con éxito";
            $icon = "success";
        } catch (\QueryException $th) {
            $msg = "Error al guardar el registro";
            $icon = "error";
        }

        return redirect('evalYears')->with(['message' => $msg, 'icon' => $icon]);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $year = Year::findOrFail($request->idYear);
                $year->status_id = $request->status;
                $year->updated_by = Auth()->user()->id;
                $year->update();
            });
            $msg = "Se guardó el registro con éxito";
            $icon = "success";
        } catch (\QueryException $th) {
            $msg = "Error al guardar el registro";
            $icon = "error";
        }

        return redirect('evalYears')->with(['message' => $msg, 'icon' => $icon]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
