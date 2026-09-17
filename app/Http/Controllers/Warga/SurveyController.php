<?php

// Controller survei sisi WARGA - lihat survei dibuka dan isi sebulan sekali

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\IsiSurveyRequest;
use App\Models\Survey;
use App\Models\SurveyJawaban;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SurveyController extends Controller
{
    // Survei yang dibuka, terbaru dulu 12 per halaman
    public function index(): View
    {
        $surveys = Survey::aktif()->withCount('pertanyaans')->latest()->paginate(12);

        return view('warga.survey.index', compact('surveys'));
    }

    // Form isi survei; sudah isi bulan ini = kembali ke daftar
    public function show(Survey $survey): View|RedirectResponse
    {
        // Hanya survei aktif yang boleh dibuka
        abort_unless($survey->aktif, 404);
        $survey->load('pertanyaans');

        // Satu warga satu survei per bulan
        if ($this->sudahIsi($survey->id)) {
            return redirect()
                ->route('warga.survey.index')
                ->with('info', 'Survei ini sudah diisi bulan ini.');
        }

        return view('warga.survey.show', compact('survey'));
    }

    // Simpan jawaban sekaligus dalam satu transaksi
    public function store(IsiSurveyRequest $request, Survey $survey): RedirectResponse
    {
        // Cegah isi ulang sebelum validasi berjalan
        if ($this->sudahIsi($survey->id)) {
            return redirect()
                ->route('warga.survey.index')
                ->with('info', 'Survei ini sudah diisi bulan ini.');
        }

        $data = $request->validated();
        $tahun = now()->year;
        $bulan = now()->month;

        try {
            DB::transaction(function () use ($request, $data, $survey, $tahun, $bulan) {
                foreach ($survey->pertanyaans as $tanya) {
                    $isi = $data['jawaban'][$tanya->id] ?? null;

                    // Lewati pertanyaan opsional yang dikosongkan
                    if ($isi === null || $isi === '') {
                        continue;
                    }

                    $request->user()->surveyJawabans()->create([
                        'survey_id' => $survey->id,
                        'pertanyaan_id' => $tanya->id,
                        'jawaban' => $isi,
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                    ]);
                }
            });
        } catch (QueryException) {
            // Pengaman balap: unique database menolak isi ganda
            return redirect()
                ->route('warga.survey.index')
                ->with('info', 'Survei ini sudah diisi bulan ini.');
        }

        return redirect()
            ->route('warga.survey.index')
            ->with('success', 'Terima kasih, jawaban tersimpan.');
    }

    // Cek apakah user sudah mengisi survei ini di bulan berjalan
    private function sudahIsi(int $surveyId): bool
    {
        return SurveyJawaban::where('survey_id', $surveyId)
            ->where('user_id', auth()->id())
            ->where('tahun', now()->year)
            ->where('bulan', now()->month)
            ->exists();
    }
}
