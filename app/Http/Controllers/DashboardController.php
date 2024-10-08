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

    public function index(){
        $TodayVisitWeb = Guest::where('login_date',Carbon::today()->format('Y-m-d'))->count();
        $models = ModelPart::orderByDesc('count_visit')->simplePaginate(5);
        $parts = Part::orderByDesc('count_visit')->simplePaginate(5);
        $partAreas = PartArea::orderByDesc('count_visit')->simplePaginate(5);
        $expired = AreaPart::where('expired_date' ,'<', Carbon::today()->format('Y-m-d'))->count();
        $willExpired = AreaPart::whereBetween('expired_date', [Carbon::now()->addDays(1)->format('Y-m-d'), Carbon::now()->addDays(1)->format('Y-m-d'), Carbon::now()->addDays(2)])->count();

        return view('limitSample.dashboard',compact('models','parts','partAreas','expired','willExpired','TodayVisitWeb'));
    }

    public function getVisitsData()
    {
        $visits = [];

        // Ambil data kunjungan untuk 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $totalVisit = Guest::whereDate('login_date', $date)->count();

            // Simpan data dalam format yang lebih sederhana
            $visits[] = [
                'date' => $date,
                'total' => $totalVisit
            ];
        }

        return response()->json($visits);
    }

    public function getDatatables(){
        $guests = Guest::select('guest_name', DB::raw('COUNT(*) as count_visit'), DB::raw('MAX(login_date) as login_date'), DB::raw('MIN(id) as id')) // Use MAX to get the latest login date
        ->groupBy('guest_name'); // Get all guest data

        // Return the DataTables JSON response
        return DataTables::of($guests)
            ->make(true); // Automatically handle formatting to JSON
    }

    public function activity(){
        return view('limitSample.activity');
    }
}
