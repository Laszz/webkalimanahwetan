<?php

// Controller pertanyaan survei sisi ADMIN - kelola butir pertanyaan per survei

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePertanyaanRequest;
use App\Http\Requests\Admin\UpdatePertanyaanRequest;
use App\Models\Survey;
use App\Models\SurveyJawaban;
use App\Models\SurveyPertanyaan;
use Illuminate\Http\RedirectResponse;

class PertanyaanController extends Controller
{
    // Tambah pertanyaan ke survei tertentu
    public function store(StorePertanyaanRequest $request, Survey $survey): RedirectResponse
    {
        $data = $request->validated();
        // Semua pertanyaan wajib diisi warga
        $data['wajib'] = true;

        $survey->pertanyaans()->create($data);

        return redirect()
            ->route('admin.survey.show', $survey)
            ->with('success', 'Pertanyaan ditambahkan.');
    }

    // Ubah satu pertanyaan
    public function update(UpdatePertanyaanRequest $request, SurveyPertanyaan $pertanyaan): RedirectResponse
    {
        $data = $request->validated();
        // Semua pertanyaan wajib diisi warga
        $data['wajib'] = true;

        $pertanyaan->update($data);

        return redirect()
            ->route('admin.survey.show', $pertanyaan->survey_id)
            ->with('success', 'Pertanyaan diperbarui.');
    }

    // Hapus pertanyaan (jawaban ikut terhapus via cascade)
    public function destroy(SurveyPertanyaan $pertanyaan): RedirectResponse
    {
        $surveyId = $pertanyaan->survey_id;
        $pertanyaan->delete();

        return redirect()
            ->route('admin.survey.show', $surveyId)
            ->with('success', 'Pertanyaan dihapus.');
    }

    // Hapus satu jawaban warga saja, pertanyaan tetap ada
    public function destroyJawaban(SurveyJawaban $jawaban): RedirectResponse
    {
        $surveyId = $jawaban->survey_id;
        $jawaban->delete();

        return redirect()
            ->route('admin.survey.show', $surveyId)
            ->with('success', 'Jawaban dihapus.');
    }
}
