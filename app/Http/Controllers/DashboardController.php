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
        $willExpired = AreaPart::whereBetween('expired_date', [Carbon::now()->addDays(1)->format('Y-m-d'), Carbon::now()->addDays(1)->format('Y-m-d'), Carbon::now()->addDays(2)])->count();

        return view('limitSample.dashboard', compact('models','AreaParts', 'parts', 'partAreas', 'expired', 'willExpired', 'TodayVisitWeb'));
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
            $guests = Guest::where('guest_name', 'LIKE', "%{$searchTerm}%")->where('count_visit' ,'!=', null);
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
        if($request->ajax()){
            $data = AreaPart::with(['modelPart'])->onlyTrashed()->get();
            return DataTables::of($data)->make(true);
        }

        return view('limitSample.arsip');
    }
    public function arsipModal(Request $request)
    {
        if($request->ajax()){
            $data = AreaPart::with(['modelPart'])->onlyTrashed()->get();
            return response()->json($data);
        }
    }
}
