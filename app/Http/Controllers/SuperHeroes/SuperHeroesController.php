<?php

namespace App\Http\Controllers\SuperHeroes;

use App\Http\Controllers\Controller;
use App\Models\SuperHeroes;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SuperHeroesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('superheroes.indexSH');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('superheroes.createSH');
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
        $query->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir']);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $item = $request->all();

        $newSH = new SuperHeroes();

        $extensions = ['jpg', 'jpeg', 'png', 'bmp'];
        $temp_avatar = $request->file('avatar');

        if ($temp_avatar) {
            $ext = $temp_avatar->getClientOriginalExtension();
            if (in_array($ext, $extensions)) {
                $fileName = md5(time());
                $request->file('avatar')->move('uploads/', $fileName . '.' . $temp_avatar->getClientOriginalExtension());
                $newSH->path_to_image = 'uploads/' . $fileName . '.' . $temp_avatar->getClientOriginalExtension();
            }
        }

        $newSH->nickname = $item['nickname'];
        $newSH->real_name = $item['real_name'];
        $newSH->origin_description = $item['origin_description'];
        $newSH->superpowers = $item['superpowers'];
        $newSH->catch_phrase = $item['catch_phrase'];

        try {
            $newSH->save();
            Session::flash('message', 'Success!');
            Session::flash('alert-success', 'alert-danger');
            return redirect()->route('super_heroes')->with(['success' => 'Успешно сохранено']);
        } catch (\Exception $exception) {
            Session::flash('message', 'Error!');
            Session::flash('alert-danger', 'danger');
            return redirect()->route('super_heroes')->with(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $superHeroesData = SuperHeroes::where('id', $id)->first()->toArray();

        return view('superheroes.editSH',
            compact('superHeroesData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $item = $request->all();
        $extensions = ['jpg', 'jpeg', 'png', 'bmp'];
        $temp_avatar = $request->file('avatar');
        if ($temp_avatar) {
            $ext = $temp_avatar->getClientOriginalExtension();
            if (in_array($ext, $extensions)) {
                $fileName = md5(time());
                $request->file('avatar')->move('uploads/', $fileName . '.' . $temp_avatar->getClientOriginalExtension());
                $item['path_to_image'] = 'uploads/' . $fileName . '.' . $temp_avatar->getClientOriginalExtension();
            }
        }

        $checkSHData = SuperHeroes::where('id', $id)->first();
        if ($checkSHData) {
            $checkSHData->nickname = $item['nickname'];
            $checkSHData->real_name = $item['real_name'];
            $checkSHData->origin_description = $item['origin_description'];
            $checkSHData->superpowers = $item['superpowers'];
            $checkSHData->catch_phrase = $item['catch_phrase'];
            if (isset($item['path_to_image'])) {
                $checkSHData->path_to_image = $item['path_to_image'];
            }
            $checkSHData->save();
            Session::flash('message', 'Success!');
            Session::flash('alert-success', 'alert-danger');
            return redirect()->route('super_heroes')->with(['success' => 'Успешно сохранено']);
        } else {
            Session::flash('message', 'Error!');
            Session::flash('alert-danger', 'danger');
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Delete marked rows
     * TODO Need to add checkbox ids to local storage
     */
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
