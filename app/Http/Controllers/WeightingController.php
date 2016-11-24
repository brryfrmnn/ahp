<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Criteria;
use App\Alternative;
use App\RatioIndex;
use App\CriteriaWeighting;

class WeightingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $criterias = Criteria::all();
        return view('weighting.create', compact('criterias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(), [
                'first_criteria_id' => 'required',
                'second_criteria_id' => 'required',
                'value' => 'required'
        ]);
        if ($validator->passes()) {

            $first_criteria_id = $request->first_criteria_id;
            $second_criteria_id = $request->second_criteria_id;
            $value = $request->value;
            $reverse_value = (double)(1/$value);
            $criteria_weighting = CriteriaWeighting::where('first_criteria_id',$first_criteria_id)
                                                    ->where('second_criteria_id',$second_criteria_id);
            if ($criteria_weighting->count() > 0) {

                $criteria_weighting->update([
                    'value' => $value
                ]);
                $reverse_criteria_weighting = CriteriaWeighting::where('first_criteria_id',$second_criteria_id)
                                                    ->where('second_criteria_id',$first_criteria_id);
                if ($reverse_criteria_weighting->count() > 0) {
                    
                    $reverse_criteria_weighting->update([
                        'value' => $reverse_value
                    ]);  
                    echo "berhasil";
                }
            } else {

                $criteria_weighting = new CriteriaWeighting;
                $criteria_weighting->first_criteria_id = $first_criteria_id;
                $criteria_weighting->second_criteria_id = $second_criteria_id;
                $criteria_weighting->value = $value;
                if ($criteria_weighting->save()) {
                    if ($first_criteria_id != $second_criteria_id) {
                        $reverse_criteria_weighting = new CriteriaWeighting;
                        $reverse_criteria_weighting->first_criteria_id = $second_criteria_id;
                        $reverse_criteria_weighting->second_criteria_id = $first_criteria_id;
                        $reverse_criteria_weighting->value = $reverse_value;
                        if ($reverse_criteria_weighting->save()) {
                            echo "berhasil";
                        }
                    } else {
                        echo "berhasil";
                    }
                }
            }
        }
        else
        {
            dd($validator->errors());
        }
        
        
    }
    public function eigen()
    {
        $criterias = Criteria::all();
        $n = $criterias->count();
        $total_weight = 0;
        $ri = RatioIndex::where('n',$n)->first()->value;
        
        foreach ($criterias as $criteria) {
            $criteria_weighting = CriteriaWeighting::where('first_criteria_id',$criteria->id)->orderBy('second_criteria_id')->get();
            $weights[$criteria->id] = $criteria_weighting;
            $row_weights[$criteria->id] = $criteria_weighting->sum('value');
            $total_weight += $row_weights[$criteria->id];
        }
        //hitung eigen dengan membagi semua bobot dengan total bobot
        foreach ($row_weights as $key => $row_weight) {
            $eigens[] = $row_weight/$total_weight;
            $for_db_eigens[$key] = $row_weight/$total_weight;
        }
        // dd($eigens[0]);
        //menghitung Aw
        $no = 0;
        foreach ($row_weights as $key => $row_weight) {
            
            $aws[$no]=0;
            
            foreach ($weights[$key] as $wk => $weight) {
                $aws[$no] += ($weight->value*$eigens[$wk]); 
            }
            $no++;
        }
        // mengitung aw/w
        foreach ($eigens as $key => $eigen) {
            $aww[$key] = $aws[$key]/$eigen;
        }
        //hitung lamda max
        $aww_col = collect($aww);
        $lamda_max = $aww_col->sum()/$n;
        // hitung CI
        $ci = ($lamda_max-$n)/($n-1);
        //hitung CR
        $cr = $ci/$ri;
        if ($cr <= 0.1) {
            
            echo "Kriteria Memenuhi syarat karena nilai CR=".$cr;


        } else {
            echo "Kriteria tidak memenuhi syarat karena nilai CR=".$cr;
        }
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
    public function update(Request $request, $id)
    {
        //
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
