<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alternative;
use Auth;
use Session;
class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alternatives = Alternative::orderBy('name')->paginate(6);
        return view('alternative.index',compact('alternative'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alternative.create');
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
        $user_id = Auth::getUser()->id;

        $alternative = Alternative::firstOrNew(['name' => $name]);
        $alternative->name = $name;
        $alternative->user_id = $user_id;
        if ($alternative->save()) {
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil menyimpan $alternative->name"
            ]);
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Gagal menyimpan $alternative->name"
            ]);
        }
        return redirect()->route('alternative.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alternative = Alternative::findOrFail($id);
        return view('alternative.show',compact('alternative'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alternative = Alternative::findOrFail($id);
        return view('alternative.edit', compact('alternative'));

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

        $alternative = Alternative::findOrFail($id);
        $alternative->name = $name;
        $alternative->user_id = $user_id;
        if ($alternative->save()) {
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil mengubah $alternative->name"
            ]);
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Gagal mengubah $alternative->name"
            ]);
        }
        return redirect()->route('alternative.edit',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alternative = Alternative::findOrFail($id);
        if ($alternative->delete()) {
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil menghapus $alternative->name"
            ]);
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Gagal menghapus $alternative->name"
            ]);
        }
        return redirect()->route('alternative.index');
    }
}
