<?php

// Controller survei sisi ADMIN - kelola survei dan lihat hasilnya

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSurveyRequest;
use App\Http\Requests\Admin\UpdateSurveyRequest;
use App\Models\Survey;
use App\Models\SurveyJawaban;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SurveyController extends Controller
{
    // Semua survei + jumlah pertanyaan, terbaru dulu 15 per halaman
    public function index(): View
    {
        $surveys = Survey::withCount('pertanyaans')->latest()->paginate(15);

        return view('admin.survey.index', compact('surveys'));
    }

    // Form tambah survei baru
    public function create(): View
    {
        return view('admin.survey.create');
    }

    // Simpan survei baru
    public function store(StoreSurveyRequest $request): RedirectResponse
    {
        $data = $request->validated();
        // Checkbox tidak terkirim saat tidak dicentang = nonaktif
        $data['aktif'] = $request->boolean('aktif');

        $survey = Survey::create($data);

        return redirect()
            ->route('admin.survey.show', $survey)
            ->with('success', 'Survei tersimpan, lanjut tambah pertanyaan.');
    }

    // Detail survei + pertanyaan + rekap hasil jawaban
    public function show(Survey $survey): View
    {
        $survey->load('pertanyaans');
        $hasil = $this->rekapHasil($survey->id);

        return view('admin.survey.show', compact('survey', 'hasil'));
    }

    // Form ubah survei
    public function edit(Survey $survey): View
    {
        return view('admin.survey.edit', compact('survey'));
    }

    // Simpan perubahan survei
    public function update(UpdateSurveyRequest $request, Survey $survey): RedirectResponse
    {
        $data = $request->validated();
        $data['aktif'] = $request->boolean('aktif');

        $survey->update($data);

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

    // Rekap per pertanyaan: rata-rata untuk skala, daftar untuk teks
    private function rekapHasil(int $surveyId): array
    {
        $rekap = [];

        // Ambil semua jawaban survei ini sekaligus lalu kelompokkan per pertanyaan
        $semua = SurveyJawaban::where('survey_id', $surveyId)->get()->groupBy('pertanyaan_id');

        foreach ($semua as $pertanyaanId => $jawabans) {
            $nilai = $jawabans->pluck('jawaban');
            $rekap[$pertanyaanId] = [
                // Jumlah responden unik
                'responden' => $jawabans->unique('user_id')->count(),
                // Rata-rata jika semua jawaban berupa angka
                'rata_rata' => $nilai->every(fn ($v) => is_numeric($v)) ? round($nilai->avg(), 1) : null,
                // 5 jawaban teks terbaru sebagai contoh
                'contoh' => $nilai->reject(fn ($v) => is_numeric($v))->take(5)->values(),
            ];
        }

        return $rekap;
    }
}
