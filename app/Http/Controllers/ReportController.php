<?php

namespace App\Http\Controllers;

use App\Models\generate_label;
use App\Models\ns_product;
use App\Models\user_log;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $products=ns_product::get();
        $lastprintdetails=user_log::where('status','Printed')->where('user_id',auth( 'web' )->user()->id)->orderBy('created_at', 'desc')->first();
        return view('generate')->with(compact('products','lastprintdetails'));
    }


    public function generatePDF(Request $request)
{
    $data = $request->all();

    $allowrange = $this->isRangeAllowed($data);

   // return $request;
    $pageSize = $data['page_size'];
    $labelsWidth = $data['labels_width'];
    $labelsHeight = $data['labels_height'];
    $orientation = $data['orientation'];
    $date= $data['date'];
    $startPosition= $allowrange ? $data['start_position']: 0;
    $endPosition= $allowrange ? $data['end_position'] : 0;

    if($allowrange){

        $products = ns_product::whereHas('attributes')
        ->with('attributes')
        ->whereBetween('id', [$startPosition, $endPosition])->get();
    }else{

        $products = ns_product::whereHas('attributes')->with('attributes')->get();
    }
    $labels = null;
    DB::transaction(function () use($products,$labelsWidth,$labelsHeight,$pageSize,$date,$orientation,$endPosition,$startPosition,$allowrange) {
        $this->storeGeneratedPdfValues($labelsWidth,$labelsHeight,$orientation, $pageSize , Carbon::parse($date), $startPosition , $endPosition,$allowrange );

    });

    $labels=$this->SavePrintLabels($products,Carbon::parse($date));
  // $pdf = PDF::loadView('pdf_template', compact('pageSize','orientation' ,'date',  'labelsWidth', 'labelsHeight','products'));
  // return $pdf->stream('pdf_template');
 //$pdf_content = $pdf->output();


     return view('view')->with(compact('pageSize','orientation' ,'date',  'labelsWidth', 'labelsHeight','products','labels'));
}

    private function isRangeAllowed(array $data): bool
    {
        if (!isset($data['allowrange'])) {
            return false;
        }

        return true;
    }


    private function storeGeneratedPdfValues(int $labelsWidth, int $labelsHeight,string $orientation,string $pageSize ,Carbon $date ,int $startPosition ,int $endPosition,bool $allowrange ) : void
    {

        user_log::create([
            'user_id' => auth( 'web' )->user()->id ,
            'label_width' => $labelsWidth,
            'label_height' => $labelsHeight,
            'paper_orientation' => $orientation,
            'paper_size' => $pageSize,
            'date' => $date,
            'allow_range' => $allowrange,
            'start_position' => $startPosition,
            'end_position' => $endPosition
        ]);
    }

    public function SavePrintLabels(EloquentCollection $data, Carbon $date): array
{
    $insertedIds = [];

    foreach ($data as $list) {
        // Insert each record and retrieve its ID
        $insertedIds[] = DB::table('generate_labels')->insertGetId([
            'user_id' => auth('web')->user()->id,
            'product_id' => $list->id,
            'date' => $date,
            'status' => 'waiting'
        ]);
    }
    return $insertedIds;
}


   public function markLabelsAsPrinted(Request $request) : void {
    $labelIds = $request->input('label_ids', []);
    generate_label::whereIn('id', $labelIds)->update(['status' => 'Printed']);
    }

}
