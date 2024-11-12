<?php

namespace App\Http\Controllers;

use App\Models\AreaPart;
use App\Models\Departments;
use App\Models\Guest;
use App\Models\ManageAccess;
use App\Models\ModelPart;
use App\Models\Part;
use App\Models\PartArea;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        // Menghitung jumlah tamu yang login hari ini
        $TodayVisitWeb = Guest::where('login_date', Carbon::today()->format('Y-m-d'))->count();

        // Mengambil data ModelPart yang diurutkan berdasarkan jumlah kunjungan tertinggi dan dipaginasi (6 per halaman)
        $models = ModelPart::orderByDesc('count_visit')->simplePaginate(6);

        // Mengambil data Part yang diurutkan berdasarkan jumlah kunjungan tertinggi dan dipaginasi (6 per halaman)
        $parts = Part::orderByDesc('count_visit')->simplePaginate(6);

        // Mengambil data AreaPart yang diurutkan berdasarkan jumlah kunjungan tertinggi dan dipaginasi (6 per halaman)
        $AreaParts = AreaPart::orderByDesc('count_visit')->simplePaginate(6);

        // Mengambil data PartArea yang diurutkan berdasarkan jumlah kunjungan tertinggi dan dipaginasi (6 per halaman)
        $partAreas = PartArea::orderByDesc('count_visit')->simplePaginate(6);

        // Menghitung jumlah AreaPart yang sudah kadaluarsa
        $expired = AreaPart::where('expired_date', '<', Carbon::today()->format('Y-m-d'))->count();

        // Menghitung jumlah AreaPart yang akan kadaluarsa dalam 5 hari ke depan
        $willExpired = AreaPart::whereBetween('expired_date', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays(5)->format('Y-m-d')])->count();

        // Memeriksa apakah user dari departemen Quality Control
        if (auth()->user()->id == $secHead1->user_id) {
            // Menghitung jumlah AreaPart yang butuh persetujuan dari Seksi Head (kondisi khusus QC)
            $NeedApproveSecHead = AreaPart::whereNull('sec_head_approval_date1')->where('status', '!=', 'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->count();
        } else {
            // Menghitung jumlah AreaPart yang butuh persetujuan dari Seksi Head (umum, bukan QC)
            $NeedApproveSecHead = AreaPart::whereNull('sec_head_approval_date2')->where('status', '!=', 'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->count();
        }

        // Menghitung jumlah AreaPart yang butuh persetujuan dari Kepala Departemen
        $NeedApproveDeptHead = AreaPart::where('sec_head_approval_date1', '!=', null)->where('sec_head_approval_date2', '!=', null)->whereNull('dept_head_approval_date')->where('expired_date', '>', Carbon::today()->format('Y-m-d'))->count();

        // Mengembalikan tampilan ke view 'limitSample.dashboard' dengan data yang sudah dihitung
        return view('limitSample.dashboard', compact('secHead1', 'secHead2', 'DeptHead', 'models', 'NeedApproveSecHead', 'NeedApproveDeptHead', 'AreaParts', 'parts', 'partAreas', 'expired', 'willExpired', 'TodayVisitWeb'));
    }

    public function getVisitsData(Request $request)
    {
        $visits = [];

        // Ambil data kunjungan untuk 7 hari terakhir jika pilihan sort adalah 'week'
        if ($request->sort == 'week') {
            for ($i = 6; $i >= 0; $i--) {
                // Ambil tanggal mulai dari 6 hari yang lalu hingga hari ini
                $date = Carbon::today()->subDays($i)->format('Y-m-d');

                // Hitung total kunjungan untuk tanggal tertentu
                $totalVisit = Guest::whereDate('login_date', $date)->count();

                // Simpan data dalam format yang lebih sederhana
                $visits[] = [
                    'date' => $date,
                    'total' => $totalVisit,
                ];
            }
        }
        // Ambil data kunjungan untuk 31 hari terakhir jika pilihan sort adalah 'month'
        elseif ($request->sort == 'month') {
            for ($i = 30; $i >= 0; $i--) {
                // Ambil tanggal mulai dari 30 hari yang lalu hingga hari ini
                $date = Carbon::today()->subDays($i)->format('Y-m-d');

                // Hitung total kunjungan untuk tanggal tertentu
                $totalVisit = Guest::whereDate('login_date', $date)->count();

                // Simpan data dalam format yang lebih sederhana
                $visits[] = [
                    'date' => $date,
                    'total' => $totalVisit,
                ];
            }
        }

        // Kembalikan data kunjungan dalam format JSON
        return response()->json($visits);
    }

    public function getDatatables(Request $request)
    {
        // Memeriksa apakah ada kata kunci pencarian
        $searchTerm = $request->get('search')['value'];

        if (!empty($searchTerm)) {
            // Jika ada kata kunci pencarian, cari tamu berdasarkan nama yang mirip dan yang memiliki 'count_visit' tidak kosong
            $guests = Guest::where('guest_name', 'LIKE', "%{$searchTerm}%")->where('count_visit', '!=', null);
        } else {
            // Jika tidak ada kata kunci pencarian, ambil data tamu dengan nama unik,
            // jumlah kunjungan maksimum, tanggal login terbaru, dan id minimum, lalu kelompokkan berdasarkan nama tamu
            $guests = Guest::select('guest_name', DB::raw('MAX(count_visit) as count_visit'), DB::raw('MAX(login_date) as login_date'), DB::raw('MIN(id) as id'))->groupBy('guest_name');
        }

        return DataTables::of($guests)
            ->filter(function ($query) use ($searchTerm) {
                if (!empty($searchTerm)) {
                    // Tambahkan logika penyaringan khusus untuk menghindari perilaku pencarian default DataTables
                    $query->where('guest_name', 'LIKE', "%{$searchTerm}%");
                }
            })
            ->make(true);
    }

    public function activity()
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        return view('limitSample.activity',compact('secHead1','secHead2','DeptHead'));
    }

    public function allExpired(Request $request)
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        if ($request->ajax()) {
            //mengambil data area part yang expired date telah melewati tanggal sekarang
            $data = AreaPart::with('modelpart', 'parts', 'partarea')->where('expired_date', '<', Carbon::now()->format('Y-m-d'))->get();
            return DataTables::of($data)->make(true);
        }
        return view('limitSample.expired',compact('secHead1','secHead2','DeptHead'));
    }

    public function willExpired(Request $request)
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        // Memeriksa apakah permintaan ini adalah permintaan AJAX
        if ($request->ajax()) {
            // Mengambil data AreaPart yang akan kadaluarsa dalam 5 hari ke depan beserta relasinya (modelpart, parts, partarea)
            $data = AreaPart::with('modelpart', 'parts', 'partarea')
                ->whereBetween('expired_date', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays(5)->format('Y-m-d')])
                ->get();

            return DataTables::of($data)
                ->addColumn('days_until_expired', function ($row) {
                    // Menghitung selisih hari sebelum tanggal kadaluarsa (expired_date)
                    $daysUntilExpired = Carbon::parse($row->expired_date)->diffInDays(Carbon::now());
                    $daysUntilExpired++; // Tambahkan 1 hari untuk menghitung mulai dari hari ini
                    return $daysUntilExpired; // Mengembalikan jumlah hari sampai kadaluarsa
                })
                ->make(true);
        }

        // Menampilkan view 'limitSample.willExpired' jika bukan permintaan AJAX
        return view('limitSample.willExpired',compact('secHead1','secHead2','DeptHead'));
    }

    public function arsip(Request $request)
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        if ($request->ajax()) {
            //mengambil data yang sudah pernah dihapus
            $data = AreaPart::with(['modelPart'])
                ->onlyTrashed()
                ->get();
            return DataTables::of($data)->make(true);
        }

        return view('limitSample.arsip', compact('secHead1', 'secHead2', 'DeptHead'));
    }
    public function arsipModal(Request $request)
    {
        if ($request->ajax()) {
            //mengambil data yang sudah pernah dihapus
            $data = AreaPart::with(['modelPart'])
                ->onlyTrashed()
                ->get();
            return response()->json($data);
        }
    }

    public function needApprovePage(Request $request)
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        // Memeriksa apakah permintaan ini adalah permintaan AJAX
        if ($request->ajax()) {
            // Jika user memiliki peran 'Supervisor' dan departemennya adalah 'Quality Control'
            if (auth()->user()->position->position == 'Supervisor' && auth()->user()->id == $secHead1->user_id) {
                // Mengambil data AreaPart yang belum disetujui oleh Seksi Head (QC) dan belum kadaluarsa, serta statusnya bukan 'tolak'
                $data = AreaPart::with('modelpart', 'parts', 'partarea')->whereNull('sec_head_approval_date1')->where('status', '!=', 'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->get();
            }
            // Jika user memiliki peran 'Supervisor' dan departemennya adalah 'Quality Engineering'
            elseif (auth()->user()->position->position == 'Supervisor' && auth()->user()->id == $secHead2->user_id) {
                // Mengambil data AreaPart yang belum disetujui oleh Seksi Head (QA) dan belum kadaluarsa, serta statusnya bukan 'tolak'
                $data = AreaPart::with('modelpart', 'parts', 'partarea')->whereNull('sec_head_approval_date2')->where('status', '!=', 'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->get();
            }
            // Jika user memiliki peran 'Department Head' dan departemennya adalah 'Quality Control'
            elseif (auth()->user()->position->position == 'Department Head' && auth()->user()->id == $DeptHead->user_id) {
                // Mengambil data AreaPart yang sudah disetujui oleh Seksi Head, tetapi belum disetujui oleh Kepala Departemen, dan belum kadaluarsa, serta statusnya bukan 'tolak'
                $data = AreaPart::with('modelpart', 'parts', 'partarea')->whereNotNull('sec_head_approval_date1')->where('status', '!=', 'tolak')->where('expired_date', '>', Carbon::now()->format('Y-m-d'))->whereNotNull('sec_head_approval_date2')->whereNull('dept_head_approval_date')->get();
            }

            // Mengembalikan data dalam format DataTables
            return DataTables::of($data)->make(true);
        }

        // Menampilkan view 'limitSample.needApprovePage' jika bukan permintaan AJAX
        return view('limitSample.needApprovePage',compact('secHead1','secHead2','DeptHead'));
    }

    public function allLimitSample(Request $request)
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        // Mengambil data dari ModelPart dengan kolom tertentu
        $modelPart = ModelPart::select('id', 'name', DB::raw('foto_model AS foto'), 'created_at')->get();

        // Mengambil data dari Part dengan kolom tertentu
        $part = Part::select('id', 'name', DB::raw('foto_part AS foto'), 'created_at')->get();

        // Memeriksa apakah user memiliki peran 'Guest' berdasarkan session
        if (auth()->user()->id != $secHead1->user_id && auth()->user()->id != $secHead2->user_id && auth()->user()->id != $DeptHead->user_id && !auth()->user()->hasRole('AdminLS')) {
            // Mengambil data AreaPart yang memenuhi kondisi berikut:
            // 1. Status tidak 'tolak'
            // 2. Disetujui oleh setidaknya satu Seksi Head (QC atau QA)
            // 3. Belum kadaluarsa
            $areaPart = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'created_at', 'characteristics')
                ->where('status', '!=', 'tolak')
                ->where(function ($query) {
                    $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                })
                ->where('expired_date', '>', Carbon::now()->format('Y-m-d'))
                ->get();
        } else {
            // Mengambil semua data AreaPart tanpa kondisi tambahan
            $areaPart = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'created_at', 'characteristics')->get();
        }

        // Memberikan label ke tiap model data
        $modelPart->each(function ($item) {
            $item->filter = 'Model'; // Menambahkan label 'Model' pada data dari ModelPart
            $item->document_number = '-'; // Menetapkan 'document_number' menjadi '-'
        });

        $part->each(function ($item) {
            $item->document_number = '-'; // Menetapkan 'document_number' menjadi '-'
            $item->filter = 'Part'; // Menambahkan label 'Part' pada data dari Part
        });

        $areaPart->each(function ($item) {
            $item->filter = 'Limit Sample'; // Menambahkan label 'Limit Sample' pada data dari AreaPart
        });

        // Menggabungkan semua data dari ModelPart, Part, dan AreaPart
        $combinedDatas = $modelPart->concat($part)->concat($areaPart);

        // Jika permintaan ini adalah AJAX, kembalikan data dalam format DataTables
        if ($request->ajax()) {
            return DataTables::of($combinedDatas)->make(true);
        }

        // Menampilkan view 'limitSample.allLimitSample' dengan data gabungan
        return view('limitSample.allLimitSample', compact('combinedDatas', 'secHead1', 'secHead2', 'DeptHead'));
    }

    public function allLimitSampleSearch(Request $request)
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        // Memeriksa apakah permintaan ini adalah permintaan AJAX
        if ($request->ajax()) {
            // Mengambil input pencarian dari permintaan AJAX
            $searchTerm = $request->input('query');
        } else {
            // Mengambil input pencarian dari parameter permintaan biasa
            $searchTerm = $request->search;
        }

        // Mengambil data dari ModelPart yang cocok dengan search term
        $modelPart = ModelPart::select('id', 'name', DB::raw('foto_model AS foto'))
            ->where('name', 'LIKE', "%$searchTerm%")
            ->get();

        // Mengambil data dari Part yang cocok dengan search term
        $part = Part::select('id', 'name', DB::raw('foto_part AS foto'))
            ->where('name', 'LIKE', "%$searchTerm%")
            ->get();

        // Memeriksa apakah user memiliki peran 'Guest' berdasarkan session
        if (auth()->user()->id != $secHead1->user_id && auth()->user()->id != $secHead2->user_id && auth()->user()->id != $DeptHead->user_id && !auth()->user()->hasRole('AdminLS')) {
            // Mengambil data AreaPart yang memenuhi kondisi berikut:
            // 1. Nama cocok dengan search term
            // 2. Status tidak 'tolak'
            // 3. Disetujui oleh setidaknya satu Seksi Head (QC atau QA)
            // 4. Belum kadaluarsa
            $areaPart = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')
                ->where('name', 'LIKE', "%$searchTerm%")
                ->where('status', '!=', 'tolak')
                ->where(function ($query) {
                    $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                })
                ->where('expired_date', '>', Carbon::now()->format('Y-m-d'))
                ->get();
        } else {
            // Mengambil semua data AreaPart yang cocok dengan search term tanpa kondisi tambahan
            $areaPart = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')
                ->where('name', 'LIKE', "%$searchTerm%")
                ->get();
        }

        // Memberikan label ke tiap model data
        $modelPart->each(function ($item) {
            $item->filter = 'Model'; // Menambahkan label 'Model' pada data dari ModelPart
        });

        $part->each(function ($item) {
            $item->filter = 'Part'; // Menambahkan label 'Part' pada data dari Part
        });

        $areaPart->each(function ($item) {
            $item->filter = 'Limit Sample'; // Menambahkan label 'Limit Sample' pada data dari AreaPart
        });

        // Menggabungkan semua data dari ModelPart, Part, dan AreaPart
        $combinedDatas = $modelPart->concat($part)->concat($areaPart);

        // Jika permintaan ini adalah AJAX, kembalikan data dalam format JSON
        if ($request->ajax()) {
            return response()->json($combinedDatas);
        }

        // Menampilkan view 'limitSample.allLimitSample' dengan data gabungan
        return view('limitSample.allLimitSample', compact('combinedDatas'));
    }

    public function allLimitSampleModal(Request $request)
    {
        if ($request->ajax()) {
            $data = AreaPart::with(['modelPart'])->get();
            return response()->json($data);
        }
    }

    public function allModelSearch(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('query');
        } else {
            $searchTerm = $request->search;
        }
        if ($searchTerm == null) {
            $combinedDatas = ModelPart::select('id', 'name', DB::raw('foto_model AS foto'))->get();
        } else {
            $combinedDatas = ModelPart::select('id', 'name', DB::raw('foto_model AS foto'))
                ->where('name', 'like', "%$searchTerm%")
                ->get();
        }

        //memberikan label ke tiap model data
        $combinedDatas->each(function ($item) {
            $item->filter = 'Model';
        });

        if ($request->ajax()) {
            return response()->json($combinedDatas);
        }
        return view('limitSample.allLimitSample', compact('combinedDatas'));
    }

    public function allPartSearch(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('query');
        } else {
            $searchTerm = $request->search;
        }

        if ($searchTerm == null) {
            $combinedDatas = Part::select('id', 'name', DB::raw('foto_part AS foto'))->get();
        } else {
            $combinedDatas = Part::select('id', 'name', DB::raw('foto_part AS foto'))
                ->where('name', 'like', "%$request->search%")
                ->get();
        }

        //memberikan label ke tiap part data
        $combinedDatas->each(function ($item) {
            $item->filter = 'Part';
        });

        if ($request->ajax()) {
            return response()->json($combinedDatas);
        }
        return view('limitSample.allLimitSample', compact('combinedDatas'));
    }

    public function allAreaPartSearch(Request $request)
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        // Memeriksa apakah permintaan ini adalah permintaan AJAX
        if ($request->ajax()) {
            // Mengambil input pencarian dari permintaan AJAX
            $searchTerm = $request->input('query');
        } else {
            // Mengambil input pencarian dari parameter permintaan biasa
            $searchTerm = $request->search;
        }

        // Memeriksa apakah search term kosong
        if ($searchTerm == null) {
            // Jika peran user adalah 'Guest'
            if (auth()->user()->id != $secHead1->user_id && auth()->user()->id != $secHead2->user_id && auth()->user()->id != $DeptHead->user_id && !auth()->user()->hasRole('AdminLS')) {
                // Mengambil data AreaPart yang memenuhi kondisi:
                // 1. Status tidak 'tolak'
                // 2. Disetujui oleh setidaknya satu Seksi Head (QC atau QA)
                // 3. Belum kadaluarsa
                $combinedDatas = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')
                    ->where('status', '!=', 'tolak')
                    ->where(function ($query) {
                        $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                    })
                    ->where('expired_date', '>', Carbon::now()->format('Y-m-d'))
                    ->get();
            } else {
                // Mengambil semua data AreaPart tanpa kondisi tambahan
                $combinedDatas = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')->get();
            }
        } else {
            // Jika ada search term
            if (auth()->user()->id != $secHead1->user_id && auth()->user()->id != $secHead2->user_id && auth()->user()->id != $DeptHead->user_id && !auth()->user()->hasRole('AdminLS')) {
                // Mengambil data AreaPart berdasarkan nama yang cocok dengan search term
                $combinedDatas = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')
                    ->where('name', 'like', "%$searchTerm%")
                    ->where('status', '!=', 'tolak')
                    ->where(function ($query) {
                        $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                    })
                    ->where('expired_date', '>', Carbon::now()->format('Y-m-d'))
                    ->count(); // Menghitung jumlah data
            } else {
                // Mengambil data AreaPart berdasarkan nama yang cocok dengan search term tanpa kondisi tambahan
                $combinedDatas = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')
                    ->where('name', 'like', "%$searchTerm%")
                    ->count(); // Menghitung jumlah data
            }

            // Jika tidak ada data ditemukan
            if ($combinedDatas == 0) {
                // Jika peran user adalah 'Guest'
                if (auth()->user()->id != $secHead1->user_id && auth()->user()->id != $secHead2->user_id && auth()->user()->id != $DeptHead->user_id && !auth()->user()->hasRole('AdminLS')) {
                    // Mengambil data AreaPart berdasarkan karakteristik yang cocok dengan search term
                    $combinedDatas = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')
                        ->where('characteristics', 'like', "%$searchTerm%")
                        ->where('status', '!=', 'tolak')
                        ->where(function ($query) {
                            $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                        })
                        ->where('expired_date', '>', Carbon::now()->format('Y-m-d'))
                        ->get();
                } else {
                    // Mengambil data AreaPart berdasarkan karakteristik tanpa kondisi tambahan
                    $combinedDatas = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')
                        ->where('characteristics', 'like', "%$searchTerm%")
                        ->get();
                }

                // Menambahkan label kolom ke setiap item
                $combinedDatas->each(function ($item) {
                    $item->column = 'characteristics'; // Menandai kolom sebagai 'characteristics'
                });
            } else {
                // Jika ada data ditemukan sebelumnya
                if (auth()->user()->id != $secHead1->user_id && auth()->user()->id != $secHead2->user_id && auth()->user()->id != $DeptHead->user_id && !auth()->user()->hasRole('AdminLS')) {
                    // Mengambil data AreaPart berdasarkan nama yang cocok dengan search term
                    $combinedDatas = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')
                        ->where('name', 'like', "%$searchTerm%")
                        ->where('status', '!=', 'tolak')
                        ->where(function ($query) {
                            $query->where('sec_head_approval_date1', '!=', null)->orWhere('sec_head_approval_date2', '!=', null);
                        })
                        ->where('expired_date', '>', Carbon::now()->format('Y-m-d'))
                        ->get();
                } else {
                    // Mengambil data AreaPart berdasarkan nama yang cocok dengan search term tanpa kondisi tambahan
                    $combinedDatas = AreaPart::select('document_number', 'id', 'name', DB::raw('foto_ke_satu AS foto'), 'characteristics')
                        ->where('name', 'like', "%$searchTerm%")
                        ->get();
                }

                // Menambahkan label kolom ke setiap item
                $combinedDatas->each(function ($item) {
                    $item->column = 'name'; // Menandai kolom sebagai 'name'
                });
            }
        }

        // Memberikan label ke tiap part data
        $combinedDatas->each(function ($item) {
            $item->filter = 'Limit Sample'; // Menandai setiap item dengan filter 'Limit Sample'
        });

        // Jika permintaan ini adalah AJAX, kembalikan data dalam format JSON
        if ($request->ajax()) {
            return response()->json($combinedDatas);
        }

        // Menampilkan view 'limitSample.allLimitSample' dengan data gabungan
        return view('limitSample.allLimitSample', compact('secHead1','secHead2','DeptHead','combinedDatas'));
    }

    public function ditolak(Request $request)
    {
        $secHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $secHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $DeptHead = ManageAccess::where('peran', 'Department Head')->first();
        if ($request->ajax()) {
            $data = AreaPart::with('modelpart', 'parts', 'partarea')->where('status', 'tolak')->get();
            return DataTables::of($data)->make(true);
        }
        return view('limitSample.ditolak',compact('secHead1','secHead2','DeptHead'));
    }

    public function manageAccess()
    {
        $oldSecHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $oldSecHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $oldDeptHead = ManageAccess::where('peran', 'Department Head')->first();
        $PostDeptHead = Position::where('position', 'Dept Head')->first();
        $PostSecHead = Position::where('position', 'Supervisor')->first();
        $DeptHeads = User::where('position_id', $PostDeptHead->id)->get();
        $SecHeads = User::where('position_id', $PostSecHead->id)->get();
        return view('limitSample.manageAccess', compact('DeptHeads', 'SecHeads', 'oldSecHead1', 'oldSecHead2', 'oldDeptHead'));
    }

    public function manageAccessStore(Request $request)
    {
        $validateData = $request->validate([
            'idSec1' => 'required',
            'idSec2' => 'required',
            'idDeptHead' => 'required',
        ]);

        $sectionHead1 = ManageAccess::where('peran', 'Section Head 1')->first();
        $sectionHead2 = ManageAccess::where('peran', 'Section Head 2')->first();
        $departmentHead = ManageAccess::where('peran', 'Department Head')->first();

        $sectionHead1->update([
            'user_id' => $validateData['idSec1'],
        ]);

        $sectionHead2->update([
            'user_id' => $validateData['idSec2'],
        ]);

        $departmentHead->update([
            'user_id' => $validateData['idDeptHead'],
        ]);

        return redirect()->route('dashboard.manage.access')->with('success', 'Manage Access Berhasil diperbarui');
    }
}
