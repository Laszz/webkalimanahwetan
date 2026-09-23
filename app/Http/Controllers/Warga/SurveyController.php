<?php

// Controller survei sisi WARGA - lihat survei dibuka dan isi sebulan sekali

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\IsiSurveyRequest;
use App\Models\Survey;
use App\Models\SurveyJawaban;
use App\Models\User;
use App\Notifications\SurveyDiisi;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class SurveyController extends Controller
{
    // Survei yang dibuka + penanda sudah diisi bulan ini, terbaru dulu 12 per halaman
    // Lunas semua = alihkan ke dashboard (bisa View atau Redirect)
    public function index(): View|RedirectResponse
    {
        $userId = auth()->id();
        $tahun = now()->year;
        $bulan = now()->month;

        $surveys = Survey::aktif()
            // Pertanyaan langsung diisi di kartu daftar
            ->with('pertanyaans')
            // Tandai survei yang sudah diisi user bulan berjalan
            ->addSelect(['sudah_isi' => SurveyJawaban::selectRaw('1')
                ->whereColumn('survey_id', 'surveys.id')
                ->where('user_id', $userId)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->limit(1),
            ])
            ->latest()
            ->paginate(12);

        // Lunas bila semua survei aktif sudah diisi bulan ini
        $total = Survey::aktif()->count();
        $terisi = SurveyJawaban::where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->distinct('survey_id')
            ->count('survey_id');
        $semuaTerisi = $total > 0 && $terisi >= $total;

        // Sudah lunas: kunci halaman, lempar ke dashboard dengan popup
        if ($semuaTerisi) {
            return redirect()
                ->route('warga.dashboard')
                ->with('info', 'Terima kasih, jawaban Anda sudah berhasil dikirim. Anda dapat mengisi survey kembali pada bulan berikutnya.');
        }

        return view('warga.survey.index', compact('surveys', 'semuaTerisi'));
    }

    // Tautan lama: isi survei kini langsung di daftar
    public function show(): RedirectResponse
    {
        return redirect()->route('warga.survey.index');
    }

    // Simpan jawaban sekaligus dalam satu transaksi
    public function store(IsiSurveyRequest $request, Survey $survey): RedirectResponse
    {
        // Biodata wajib lengkap dulu
        if (! auth()->user()->warga) {
            return redirect()
                ->route('warga.dashboard')
                ->with('lengkapi', 'Silahkan lengkapi data diri untuk memakai fitur website.');
        }

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

        // Beri tahu semua admin bahwa survei ini diisi
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new SurveyDiisi($survey, $request->user()->name));

        return redirect()
            ->route('warga.survey.index')
            ->with('success', 'Terima kasih, jawaban Anda sudah berhasil dikirim. Anda dapat mengisi survey kembali pada bulan berikutnya.');
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
