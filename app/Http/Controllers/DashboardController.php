<?php

namespace App\Http\Controllers;

use App\Models\AreaPart;
use App\Models\Guest;
use App\Models\ModelPart;
use App\Models\Part;
use App\Models\PartArea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $TodayVisitWeb = Guest::where('login_date', Carbon::today()->format('Y-m-d'))->count();
        $models = ModelPart::orderByDesc('count_visit')->simplePaginate(6);
        $parts = Part::orderByDesc('count_visit')->simplePaginate(6);
        $AreaParts = AreaPart::orderByDesc('count_visit')->simplePaginate(6);
        $partAreas = PartArea::orderByDesc('count_visit')->simplePaginate(6);
        $expired = AreaPart::where('expired_date', '<', Carbon::today()->format('Y-m-d'))->count();
        $willExpired = AreaPart::whereBetween('expired_date', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays(5)->format('Y-m-d')])->count();
        if (session('user')['detail_dept_id'] == 15) {
            $NeedApproveSecHead = AreaPart::whereNull('sec_head_approval_date1')->where('status' ,'!=' ,'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->count();
        } else {
            $NeedApproveSecHead = AreaPart::whereNull('sec_head_approval_date2')->where('status' ,'!=' ,'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->count();
        }

        $NeedApproveDeptHead = AreaPart::where(function ($query) {
            $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
        })
            ->whereNull('dept_head_approval_date')
            ->where('expired_date', '>', Carbon::today()->format('Y-m-d'))
            ->count();
        return view('limitSample.dashboard', compact('models', 'NeedApproveSecHead', 'NeedApproveDeptHead', 'AreaParts', 'parts', 'partAreas', 'expired', 'willExpired', 'TodayVisitWeb'));
    }

    public function getVisitsData(Request $request)
    {
        $visits = [];
        // Ambil data kunjungan untuk 7 hari terakhir
        if ($request->sort == 'week') {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i)->format('Y-m-d');
                $totalVisit = Guest::whereDate('login_date', $date)->count();

                // Simpan data dalam format yang lebih sederhana
                $visits[] = [
                    'date' => $date,
                    'total' => $totalVisit,
                ];
            }
        } elseif ($request->sort == 'month') {
            for ($i = 30; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i)->format('Y-m-d');
                $totalVisit = Guest::whereDate('login_date', $date)->count();

                // Simpan data dalam format yang lebih sederhana
                $visits[] = [
                    'date' => $date,
                    'total' => $totalVisit,
                ];
            }
        }

        return response()->json($visits);
    }

    public function getDatatables(Request $request)
    {
        // Check if there is a search term
        $searchTerm = $request->get('search')['value'];

        if (!empty($searchTerm)) {
            $guests = Guest::where('guest_name', 'LIKE', "%{$searchTerm}%")->where('count_visit', '!=', null);
        } else {
            $guests = Guest::select('guest_name', DB::raw('MAX(count_visit) as count_visit'), DB::raw('MAX(login_date) as login_date'), DB::raw('MIN(id) as id'))->groupBy('guest_name');
        }

        return DataTables::of($guests)
            ->filter(function ($query) use ($searchTerm) {
                if (!empty($searchTerm)) {
                    // Add custom filtering logic to avoid DataTables' default search behavior
                    $query->where('guest_name', 'LIKE', "%{$searchTerm}%");
                }
            })
            ->make(true);
    }

    public function activity()
    {
        return view('limitSample.activity');
    }

    public function allExpired(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaPart::with('modelpart', 'parts', 'partarea')->where('expired_date', '<', Carbon::now()->format('Y-m-d'))->get();
            return DataTables::of($data)->make(true);
        }
        return view('limitSample.expired');
    }

    public function willExpired(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaPart::with('modelpart', 'parts', 'partarea')
                ->whereBetween('expired_date', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays(5)->format('Y-m-d')])
                ->get();

            return DataTables::of($data)
                ->addColumn('days_until_expired', function ($row) {
                    // Menghitung selisih hari sebelum expired_date
                    $daysUntilExpired = Carbon::parse($row->expired_date)->diffInDays(Carbon::now());
                    $daysUntilExpired++;
                    return $daysUntilExpired; // Mengembalikan jumlah hari
                })
                ->make(true);
        }
        return view('limitSample.willExpired');
    }
    public function arsip(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaPart::with(['modelPart'])
                ->onlyTrashed()
                ->get();
            return DataTables::of($data)->make(true);
        }

        return view('limitSample.arsip');
    }
    public function arsipModal(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaPart::with(['modelPart'])
                ->onlyTrashed()
                ->get();
            return response()->json($data);
        }
    }

    public function needApprovePage(Request $request){
        if ($request->ajax()) {
            if(in_array('Supervisor', session('roles', [])) && session('user')['detail_dept_id'] == '15')
            {
                $data = AreaPart::with('modelpart', 'parts', 'partarea')->whereNull('sec_head_approval_date1')->where('status' ,'!=' ,'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->get();
            }elseif(in_array('Supervisor', session('roles', [])) && session('user')['detail_dept_id'] == '16'){
                $data = AreaPart::with('modelpart', 'parts', 'partarea')->whereNull('sec_head_approval_date2')->where('status' ,'!=' ,'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->get();
            }elseif(in_array('Department Head', session('roles', [])) && session('user')['detail_dept_id'] == '15'){
                $data = AreaPart::with('modelpart', 'parts', 'partarea')->whereNotNull('sec_head_approval_date1')->where('status' ,'!=' ,'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->whereNotNull('sec_head_approval_date2')->whereNull('dept_head_approval_date')->get();
            }
            return DataTables::of($data)->make(true);
        }
        return view('limitSample.needApprovePage');
    }

    public function allLimitSample(Request $request)
    {
        $modelPart = ModelPart::select('id', 'name', DB::raw('foto_model AS foto'),'created_at')->get();
        $part = Part::select('id','name',DB::raw('foto_part AS foto'),'created_at')->get();
        if (in_array('Guest', session('roles', []))) {
            $areaPart = AreaPart::select('document_number','id','name',DB::raw('foto_ke_satu AS foto'),'created_at','characteristics')->where('status','!=','tolak')->where(function ($query) {
                $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
            })->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->get();
        }else{
            $areaPart = AreaPart::select('document_number','id','name',DB::raw('foto_ke_satu AS foto'),'created_at','characteristics')->get();
        }

        //memberikan label ke tiap model data
        $modelPart->each(function($item) {
            $item->filter = 'Model';
            $item->document_number = '-';
        });
        $part->each(function($item) {
            $item->document_number = '-';
            $item->filter = 'Part';
        });
        $areaPart->each(function($item) {
            $item->filter = 'Limit Sample';
        });

        $combinedDatas = $modelPart->concat($part)->concat($areaPart);

        if($request->ajax())
        {
            return DataTables::of($combinedDatas)->make(true);
        }

        return view('limitSample.allLimitSample',compact('combinedDatas'));
    }

    public function allLimitSampleSearch(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('query');
        }else{
            $searchTerm = $request->search;
        }
        $modelPart = ModelPart::select('id', 'name', DB::raw('foto_model AS foto'))->where('name','LIKE',"%$searchTerm%")->get();
        $part = Part::select('id','name',DB::raw('foto_part AS foto'))->where('name','LIKE',"%$searchTerm%")->get();
        if (in_array('Guest', session('roles', []))) {
            $areaPart = AreaPart::select('document_number','id','name',DB::raw('foto_ke_satu AS foto'),'characteristics')->where('name','LIKE',"%$searchTerm%")->where('status','!=','tolak')->where(function ($query) {
                $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
            })->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->get();
        }else{
            $areaPart = AreaPart::select('document_number','id','name',DB::raw('foto_ke_satu AS foto'),'characteristics')->where('name','LIKE',"%$searchTerm%")->get();
        }


        //memberikan label ke tiap model data
        $modelPart->each(function($item) {
            $item->filter = 'Model';
        });
        $part->each(function($item) {
            $item->filter = 'Part';
        });
        $areaPart->each(function($item) {
            $item->filter = 'Limit Sample';
        });

        $combinedDatas = $modelPart->concat($part)->concat($areaPart);

        if($request->ajax())
        {
            return response()->json($combinedDatas);
        }

        return view('limitSample.allLimitSample',compact('combinedDatas'));
    }

    public function allLimitSampleModal(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaPart::with(['modelPart'])
                ->get();
            return response()->json($data);
        }
    }

    public function allModelSearch(Request $request){
        if ($request->ajax()) {
            $searchTerm = $request->input('query');
        }else{
            $searchTerm = $request->search;
        }
        if($searchTerm == null ){
            $combinedDatas = ModelPart::select('id', 'name', DB::raw('foto_model AS foto'))->get();
        }else{
            $combinedDatas = ModelPart::select('id', 'name', DB::raw('foto_model AS foto'))->where('name','like',"%$searchTerm%")->get();
        }

        //memberikan label ke tiap model data
        $combinedDatas->each(function($item) {
            $item->filter = 'Model';
        });

        if ($request->ajax()) {
            return response()->json($combinedDatas);
        }
        return view('limitSample.allLimitSample',compact('combinedDatas'));
    }

    public function allPartSearch(Request $request){
        if ($request->ajax()) {
            $searchTerm = $request->input('query');
        }else{
            $searchTerm = $request->search;
        }

        if($searchTerm == null){
            $combinedDatas = Part::select('id', 'name', DB::raw('foto_part AS foto'))->get();
        }else{
            $combinedDatas = Part::select('id', 'name', DB::raw('foto_part AS foto'))->where('name','like',"%$request->search%")->get();
        }

        //memberikan label ke tiap part data
        $combinedDatas->each(function($item) {
            $item->filter = 'Part';
        });

        if ($request->ajax()) {
            return response()->json($combinedDatas);
        }
        return view('limitSample.allLimitSample',compact('combinedDatas'));
    }

    public function allAreaPartSearch(Request $request){
        if ($request->ajax()) {
            $searchTerm = $request->input('query');
        }else{
            $searchTerm = $request->search;
        }

        if($searchTerm == null){
            if (in_array('Guest', session('roles', []))) {
                $combinedDatas = AreaPart::select('document_number','id', 'name', DB::raw('foto_ke_satu AS foto'),'characteristics')->where('status','!=','tolak')->where(function ($query) {
                    $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                })->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->get();
            }else{
                $combinedDatas = AreaPart::select('document_number','id', 'name', DB::raw('foto_ke_satu AS foto'),'characteristics')->get();
            }

        }else{
            if (in_array('Guest', session('roles', []))) {
                $combinedDatas = AreaPart::select('document_number','id', 'name', DB::raw('foto_ke_satu AS foto'),'characteristics')->where('name','like',"%$searchTerm%")->where('status','!=','tolak')->where(function ($query) {
                    $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                })->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->count();
            }else{
                $combinedDatas = AreaPart::select('document_number','id', 'name', DB::raw('foto_ke_satu AS foto'),'characteristics')->where('name','like',"%$searchTerm%")->count();
            }
            if($combinedDatas == 0){
                if (in_array('Guest', session('roles', []))) {
                    $combinedDatas = AreaPart::select('document_number','id', 'name', DB::raw('foto_ke_satu AS foto'),'characteristics')->where('characteristics','like',"%$searchTerm%")->where('status','!=','tolak')->where(function ($query) {
                        $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                    })->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->get();
                }else{
                    $combinedDatas = AreaPart::select('document_number','id', 'name', DB::raw('foto_ke_satu AS foto'),'characteristics')->where('characteristics','like',"%$searchTerm%")->get();
                }

                $combinedDatas->each(function($item) {
                    $item->column = 'characteristics';
                });
            }else{
                if (in_array('Guest', session('roles', []))) {
                    $combinedDatas = AreaPart::select('document_number','id', 'name', DB::raw('foto_ke_satu AS foto'),'characteristics')->where('name','like',"%$searchTerm%")->where('status','!=','tolak')->where(function ($query) {
                        $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                    })->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->get();
                }else{
                    $combinedDatas = AreaPart::select('document_number','id', 'name', DB::raw('foto_ke_satu AS foto'),'characteristics')->where('name','like',"%$searchTerm%")->get();
                }

                $combinedDatas->each(function($item) {
                $item->column = 'name';
                });
            }
        }

        //memberikan label ke tiap part data
        $combinedDatas->each(function($item) {
            $item->filter = 'Limit Sample';
        });

        if ($request->ajax()) {
            return response()->json($combinedDatas);
        }
        return view('limitSample.allLimitSample',compact('combinedDatas'));
    }

    public function allLimitSampleList(){

    }
}
