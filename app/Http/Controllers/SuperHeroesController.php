<?php

namespace App\Http\Controllers;

use App\Models\SuperHeroes;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperHeroesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('auth.superheroes.indexSH');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd(2);
    }

    public function SuperHeroList(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $columns = $request->get('columns');
        $order = $request->get('order');

        $query = SuperHeroes::select(
            ['id',
                'nickname',
                'real_name',
                'origin_description',
                'superpowers',
                'catch_phrase',
                'path_to_image as url',
                'created_at as added'
            ]
        );


        if (isset($search) && !empty($search['value'])) {
            $query->where(
                function ($q) use ($search) {
                    $q->where('nickname', 'like', '%' . $search['value'] . '%');
                    $q->orWhere('real_name', 'like', '%' . $search['value'] . '%');
                    $q->orWhere('origin_description', 'like', '%' . $search['value'] . '%');
                    $q->orWhere('superpowers', 'like', '%' . $search['value'] . '%');
                    $q->orWhere('catch_phrase', 'like', '%' . $search['value'] . '%');
                }
            );
        }

        $totalFiltered = $query->count();

        $query->limit($length);
        $query->offset($start);
        $a = $query->get()->toArray();
        $data = [
            'draw' => $draw,
            'recordsTotal' => SuperHeroes::count(),
            'recordsFiltered' => $totalFiltered,
            'data' => $a,
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(3);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd(4);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd(5);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        dd(6);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function bulkDelete(Request $request)
    {
        $countDeleted = 0;
        $Ids = $request->all();
        foreach ($Ids['ids'] as $id) {
            SuperHeroes::where('id', $id)->delete();
            $countDeleted++;
        }

        $record = ($countDeleted > 1) ? 'Records' : 'Record';
        $response = [
            'status' => true,
            'message' => $countDeleted . " {$record} removed."
        ];
        return response()->json($response);
    }
}
