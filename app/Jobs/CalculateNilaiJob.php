<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SummaryNilai;
use App\Models\SummaryNilaiDetail;
use App\Models\Nilai;
use App\Models\Peserta;
use DB;

class CalculateNilaiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = Nilai::select('peserta.name','peserta.id as peserta_id','d.name as nama_jurus','d.id as jurus_id','nilai.event_id',DB::raw('sum(nilai)nilai,COUNT(c.id)jurus_dinilai'))
                ->join('peserta','peserta.id','nilai.peserta_id')
                ->join('jurus as c','c.id','nilai.jurus_id')
                ->join('jurus as d','d.id','c.parent_id')
                ->groupBy('peserta.id','peserta.name','d.name','d.id','nilai.event_id')
                ->orderBy('peserta.id')
                ->get()->toArray();
        $sum_nilai=[];
        $peserta_id='';
        $insM = '';
        $insD = '';
        $summary='';
        $this->summary_nilai = new SummaryNilai();
        $this->summary_nilai_detail = new SummaryNilaiDetail();
        foreach($data as $key =>$value){
            if( $peserta_id!=$value['peserta_id']){
                $p = array_filter($value,function($key){
                    return in_array($key,$this->summary_nilai->fillable)!==false;
                },ARRAY_FILTER_USE_KEY);
                
                // dd($p);
                $summary = SummaryNilai::where(['event_id'=>$p['event_id'],'peserta_id'=>$p['peserta_id']]);
                if($summary->exists()){
                    $p['updated_user']=$this->user->id;
                    $insM = $summary->update($p);
                } else {
                    $p['created_user']=$this->user->id;
                    $insM = SummaryNilai::create($p);
                }
            }
            $params = array_filter($value,function($key){
                return in_array($key,$this->summary_nilai_detail->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);
            
            $params['nilai']=round($params['nilai']/$this->summary_nilai_detail->averageParams($value['jurus_id']),1);
            $params['total_jurus']=$this->summary_nilai_detail->averageParams($value['jurus_id']);
            $params['kriteria']=$this->summary_nilai_detail->criteria(round($params['nilai']/$this->summary_nilai_detail->averageParams($value['jurus_id']),1));
            $summary_detail = SummaryNilaiDetail::where(['peserta_id'=>$params['peserta_id'],'jurus_id'=>$params['jurus_id']]);
            
            if($summary_detail->exists()){
                $params['updated_user']=$this->user->id;
                $insD = $summary_detail->update($params);
            } else {
                $params['summary_id']=$insM->id??$summary->first()->id;
                $params['created_user']=$this->user->id;
                $insD = SummaryNilaiDetail::create($params);
            }
            
            $peserta_id=$params['peserta_id'];
        }
        $dataPeserta = Peserta::all();

        foreach ( $dataPeserta as $value){
            Peserta::where('id',$value->id)->update([
                'ts_akhir_id'=>$value->data_ts->ts_next
            ]);
        }
    }
}
