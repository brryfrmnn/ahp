<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Criteria;
use Auth;
use Session;

class CriteriaController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $criterias = Criteria::orderBy('name')->paginate(6);
        return view('criteria.index',compact('criteria'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('criteria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->name;
        // $user_id = Auth::user()->id;
        $user_id = 1;
        $criteria = Criteria::firstOrNew(['name' => $name]);
        $criteria->name = $name;
        $criteria->user_id = $user_id;
        if ($criteria->save()) {
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil menyimpan $criteria->name"
            ]);
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Gagal menyimpan $criteria->name"
            ]);
        }
        return redirect()->route('criteria.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $criteria = Criteria::findOrFail($id);
        return view('criteria.show',compact('criteria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $criteria = Criteria::findOrFail($id);
        return view('criteria.edit', compact('criteria'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->name;
        $user_id = Auth::getUser()->id;

        $criteria = Criteria::findOrFail($id);
        $criteria->name = $name;
        $criteria->user_id = $user_id;
        if ($criteria->save()) {
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil mengubah $criteria->name"
            ]);
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Gagal mengubah $criteria->name"
            ]);
        }
        return redirect()->route('criteria.edit',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $criteria = Criteria::findOrFail($id);
        if ($criteria->delete()) {
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil menghapus $criteria->name"
            ]);
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Gagal menghapus $criteria->name"
            ]);
        }
        return redirect()->route('criteria.index');
    }}
