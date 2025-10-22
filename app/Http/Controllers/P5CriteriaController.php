<?php
namespace App\Http\Controllers;

use App\Models\{P5Project,P5ProjectCriterion};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\P5ProjectRating;

class P5CriteriaController extends Controller
{
public function index(P5Project $p5)
{
    $rows = $p5->criteria()->get();
    $nextOrder = max(1, (int)$p5->criteria()->max('order_no') + 1);   // <— hitung default
    return view('p5.criteria.index', compact('p5','rows','nextOrder'));
}

public function store(Request $r, P5Project $p5)
{
    $data = $r->validate([
        'order_no'=>['nullable','integer','min:1'],   // boleh kosong
        'title'   =>['nullable','string','max:255'],
        'dimension_id'=>['nullable','integer','min:1','max:6'],  // 1-6 untuk 6 dimensi
    ]);
    $data['p5_project_id'] = $p5->id;
    $data['order_no'] = $data['order_no'] ?? ((int)$p5->criteria()->max('order_no') + 1); // <— fallback
    P5ProjectCriterion::create($data);
    return back()->with('ok','Kriteria ditambahkan.');
}

public function update(Request $r, \App\Models\P5ProjectCriterion $crit)
{
    // Simpan judul dan dimension_id
    $data = $r->validate([
        'title' => ['nullable','string','max:255'],
        'dimension_id' => ['nullable','integer','min:1','max:6'],  // 1-6 untuk 6 dimensi
    ]);

    $crit->update([
        'title' => $data['title'] ?? null,
        'dimension_id' => $data['dimension_id'] ?? null,
    ]);

    return back()->with('ok','Kriteria diperbarui.');
}



public function move(Request $r, \App\Models\P5ProjectCriterion $crit)
{
    $dir = $r->get('dir','up');
    $pid = $crit->p5_project_id;

    // Cari tetangga
    $q = \App\Models\P5ProjectCriterion::where('p5_project_id',$pid);
    $neighbor = $dir === 'up'
        ? $q->where('order_no','<',$crit->order_no)->orderBy('order_no','desc')->first()
        : $q->where('order_no','>',$crit->order_no)->orderBy('order_no','asc')->first();

    if (!$neighbor) {
        return back(); // sudah paling atas/bawah
    }

    \DB::transaction(function () use ($crit, $neighbor, $pid) {
        $aOld = (int)$crit->order_no;
        $bOld = (int)$neighbor->order_no;

        // Angka sementara yang aman (max+1 di projek ini)
        $tmp = (int)\App\Models\P5ProjectCriterion::where('p5_project_id',$pid)->max('order_no') + 1;

        // 1) Pindahkan neighbor ke angka sementara untuk menghindari duplikasi unik
        $neighbor->update(['order_no' => $tmp]);

        // 2) Tukar nilai
        $crit->update(['order_no' => $bOld]);
        $neighbor->update(['order_no' => $aOld]);
    });

    return back();
}

    public function reindex(\App\Models\P5Project $p5)
    {
        DB::transaction(function () use ($p5) {
            P5ProjectCriterion::where('p5_project_id', $p5->id)
                ->update(['order_no' => DB::raw('order_no + 1000')]);

            $rows = P5ProjectCriterion::where('p5_project_id', $p5->id)
                ->orderBy('order_no')->get();

            $i = 1;
            foreach ($rows as $row) {
                $row->update(['order_no' => $i++]);
            }
        });

        return back()->with('ok', 'Urutan dirapikan.');
    }

public function destroy(P5ProjectCriterion $crit)
{
    $pid = $crit->p5_project_id;

    DB::transaction(function () use ($crit, $pid) {
        // 0) Hapus semua rating yang mengacu ke kriteria ini
        P5ProjectRating::where('criterion_id', $crit->id)->delete();

        // 1) Hapus kriterianya
        $crit->delete();

        // 2) REINDEX aman (angkat dulu ke range aman lalu 1..n)
        P5ProjectCriterion::where('p5_project_id', $pid)
            ->update(['order_no' => DB::raw('order_no + 1000')]);

        $rows = P5ProjectCriterion::where('p5_project_id', $pid)
            ->orderBy('order_no')->get();

        $i = 1;
        foreach ($rows as $row) {
            $row->update(['order_no' => $i++]);
        }
    });

    return back()->with('ok','Kriteria dihapus.');
}

}
