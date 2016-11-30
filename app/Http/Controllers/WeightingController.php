<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Criteria;
use App\Alternative;
use App\RatioIndex;
use App\CriteriaWeighting;
use App\EigenCriteria;
use App\EigenAlternative;
use App\AlternativeCriteria;
use App\Result;
use Session;

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
                    Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Berhasil"
                    ]);

                    return redirect()->route('weighting.create');
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
                            Session::flash("flash_notification", [
                                "level"=>"success",
                                "message"=>"Berhasil"
                            ]);

                            return redirect()->route('weighting.create');
                        }
                    } else {
                        Session::flash("flash_notification", [
                                "level"=>"danger",
                                "message"=>"Berhasil"
                        ]);

                            return redirect()->route('weighting.create');
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
            // dd($for_db_eigens);
            $for_db_eigens = collect($for_db_eigens);
            $max = $for_db_eigens->max();
            foreach ($for_db_eigens as $key => $db_eigen) {
                // dd($db_eigen);
                $eigen_vector = EigenCriteria::firstOrNew(['criteria_id' => $key]);
                $eigen_vector->criteria_id = $key;
                $eigen_vector->value = $db_eigen;
                $eigen_vector->save();
            }


            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Kriteria Memenuhi syarat karena nilai CR==$cr"
            ]);

            return redirect()->route('weighting.alternative');
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Kriteria tidak memenuhi syarat karena nilai CR=$cr"
            ]);
            return redirect()->route('weighting.eigen');
        }

    }

    public function alternative()
    {
        $criterias = Criteria::all();
        // dd($criterias);
        $no=1;
        $status = false;
        foreach ($criterias as $criteria) {
            $alternatives = AlternativeCriteria::with('criteria','alternative')->where('criteria_id',$criteria->id)->orderBy('alternative_id')->get();
            //membandingkan bobo alternatif
            foreach ($alternatives as $key => $alternative1) {
                foreach ($alternatives as $key => $alternative2) {
                    if ($alternative1->desc == 'more') {
                        $alternative[$alternative1->id][$alternative2->id] = $alternative1->value/$alternative2->value;
                    } elseif ($alternative1->desc=='less') {
                        $alternative[$alternative1->id][$alternative2->id] = $alternative2->value/$alternative1->value;
                    }
                }   
            }
            // dd($alternative);
            //menghitung total nilai baris
            foreach ($alternative as $key => $al) {
                $data_alternative[$key]=0;
                foreach ($al as $k => $data) {
                    $data_alternative[$key] += $data;
                }
            }

            /*if ($no==2) {
                        dd($data_alternative);
                    }*/
            // dd($data_alternative);
            //menghitung total data dari baris
            $data_alternative = collect($data_alternative);
            $total_baris = $data_alternative->sum();
            //menghitung bobot/ eigen vector
            // dd($total_baris);
            foreach ($alternative as $key => $al) {
                foreach ($data_alternative as $dak => $data) {
                    $eigen_alternative[$dak] = $data/$total_baris;
                    /*if ($no==2) {
                        dd($eigen_alternative);
                    }*/
                    $alternative_criteria = AlternativeCriteria::find($dak);
                    $alternative_criteria->eigen_alternative = $eigen_alternative[$dak];
                    if ($alternative_criteria->save()) {
                        $status = true;
                    } else {
                        $status = false;
                    }
                }
            }
            //hapus array terdahulu
            unset($alternative);
            unset($data_alternative);
            unset($eigen_alternative);
            $no++;
        }

        // $data_alternative

        if ($status) {
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil"
            ]);
        } else {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Gagal "
            ]);
        }
        return redirect()->route('weighting.process');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function process()
    {
        
        $alternatives = Alternative::orderBy('id')->get();        

        foreach ($alternatives as $key => $alternative) {
            $alternative_criterias = AlternativeCriteria::where('alternative_id',$alternative->id)->orderBy('criteria_id')->get();
            $nilai_keputusan[$alternative->id] = 0;
            foreach ($alternative_criterias as $ackey => $alternative_criteria) {
               $criteria_id = $alternative_criteria->criteria_id;
               $eigen_criteria = EigenCriteria::where('criteria_id',$criteria_id)->orderBy('criteria_id')->first();
               // dd($alternative_criteria->eigen_alternative,$eigen_criteria->value);
               $nilai_keputusan[$alternative->id] += ($alternative_criteria->eigen_alternative*$eigen_criteria->value);
            }
        }
        
        foreach ($nilai_keputusan as $key => $nilai) {
            $result = Result::firstOrNew(['alternative_id'=>$key]);
            $result->alternative_id = $key;
            $result->value = $nilai;
            $result->save();
        }

        $nilai_criteria_id = array_keys($nilai_keputusan);
 
        $nilai_keputusan = collect($nilai_keputusan);
        // dd($nilai_keputusan);
        $nilai_max = $nilai_keputusan->max();
        $results = Result::orderBy('value','desc')->get();
        // $max = $results->max('value');
        return view('weighting.result',compact('results')) ;   
    }

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
