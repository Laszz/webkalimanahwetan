<?php

// Controller survei sisi ADMIN - kelola survei dan lihat hasilnya

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSurveyRequest;
use App\Http\Requests\Admin\UpdateSurveyRequest;
use App\Models\Survey;
use App\Models\SurveyPertanyaan;
use App\Models\User;
use App\Notifications\SurveyBaru;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SurveyController extends Controller
{
    // Semua survei + pertanyaan pertama + total pengisi, terbaru dulu 15 per halaman
    public function index(): View
    {
        $surveys = Survey::query()
            // Teks pertanyaan pertama untuk kolom tabel
            ->addSelect(['pertanyaan_pertama' => SurveyPertanyaan::select('pertanyaan')
                ->whereColumn('survey_id', 'surveys.id')
                ->orderBy('urutan')
                ->orderBy('id')
                ->limit(1),
            ])
            // Total warga unik yang sudah mengisi
            ->withCount(['jawabans as pengisi' => fn ($query) => $query->select(DB::raw('COUNT(DISTINCT user_id)'))])
            ->latest()
            ->paginate(15);

        return view('admin.survey.index', compact('surveys'));
    }

    // Form tambah survei baru
    public function create(): View
    {
        return view('admin.survey.create');
    }

    // Simpan survei + pertanyaan pertamanya dalam satu transaksi
    public function store(StoreSurveyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $survey = DB::transaction(function () use ($data, $request) {
            // Judul dibuat otomatis dari awal pertanyaan
            $survey = Survey::create([
                'judul' => Str::limit($data['pertanyaan'], 60),
                'mulai' => $data['mulai'] ?? null,
                'selesai' => $data['selesai'] ?? null,
                // Checkbox tidak terkirim saat tidak dicentang = nonaktif
                'aktif' => $request->boolean('aktif'),
            ]);

            // Pertanyaan pertama selalu wajib diisi warga
            $survey->pertanyaans()->create([
                'pertanyaan' => $data['pertanyaan'],
                'tipe' => $data['tipe'],
                'wajib' => true,
                'urutan' => 0,
            ]);

            return $survey;
        });

        // Beri tahu semua warga agar bisa membuka lagi bila sebelumnya lunas
        $wargas = User::where('role', 'warga')->get();
        Notification::send($wargas, new SurveyBaru($survey));

        return redirect()
            ->route('admin.survey.show', $survey)
            ->with('success', 'Survei tersimpan.');
    }

    // Detail survei + pertanyaan + siapa saja yang menjawab tiap pertanyaan
    public function show(Survey $survey): View
    {
        $survey->load(['pertanyaans.jawabans.user:id,name']);

        // Ringkasan: responden unik + rata-rata jawaban angka
        $semua = $survey->pertanyaans->flatMap->jawabans;
        $angka = $semua->filter(fn ($j) => is_numeric($j->jawaban))->map(fn ($j) => (float) $j->jawaban);
        $ringkasan = [
            'responden' => $semua->unique('user_id')->count(),
            'rata_rata' => $angka->isNotEmpty() ? round($angka->avg(), 1) : null,
        ];

        return view('admin.survey.show', compact('survey', 'ringkasan'));
    }

    // Form ubah survei + pertanyaan pertamanya
    public function edit(Survey $survey): View
    {
        $survey->load('pertanyaans');
        // Pertanyaan pertama untuk diedit inline (tambah lagi lewat daftar bawah)
        $pertama = $survey->pertanyaans->sortBy([['urutan', 'asc'], ['id', 'asc']])->first();

        return view('admin.survey.edit', compact('survey', 'pertama'));
    }

    // Simpan perubahan survei + pertanyaan pertamanya
    public function update(UpdateSurveyRequest $request, Survey $survey): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $survey) {
            $survey->update([
                'judul' => Str::limit($data['pertanyaan'], 60),
                'mulai' => $data['mulai'] ?? null,
                'selesai' => $data['selesai'] ?? null,
                'aktif' => $request->boolean('aktif'),
            ]);

            // Timpa pertanyaan pertama; buat baru jika belum ada
            $pertama = $survey->pertanyaans()->orderBy('urutan')->orderBy('id')->first();
            $tanyaData = ['pertanyaan' => $data['pertanyaan'], 'tipe' => $data['tipe']];

            if ($pertama) {
                $pertama->update($tanyaData);
            } else {
                $survey->pertanyaans()->create($tanyaData + ['wajib' => true, 'urutan' => 0]);
            }
        });

        return redirect()
            ->route('admin.survey.show', $survey)
            ->with('success', 'Survei diperbarui.');
    }

    // Hapus survei (pertanyaan dan jawaban ikut terhapus via cascade)
    public function destroy(Survey $survey): RedirectResponse
    {
        $survey->delete();

        return redirect()
            ->route('admin.survey.index')
            ->with('success', 'Survei dihapus.');
    }
}
