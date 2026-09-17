<?php

// Controller pertanyaan survei sisi ADMIN - kelola butir pertanyaan per survei

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePertanyaanRequest;
use App\Http\Requests\Admin\UpdatePertanyaanRequest;
use App\Models\Survey;
use App\Models\SurveyPertanyaan;
use Illuminate\Http\RedirectResponse;

class PertanyaanController extends Controller
{
    // Tambah pertanyaan ke survei tertentu
    public function store(StorePertanyaanRequest $request, Survey $survey): RedirectResponse
    {
        $data = $request->validated();
        // Checkbox tidak terkirim saat tidak dicentang = boleh kosong
        $data['wajib'] = $request->boolean('wajib');

        $survey->pertanyaans()->create($data);

        return redirect()
            ->route('admin.survey.show', $survey)
            ->with('success', 'Pertanyaan ditambahkan.');
    }

    // Ubah satu pertanyaan
    public function update(UpdatePertanyaanRequest $request, SurveyPertanyaan $pertanyaan): RedirectResponse
    {
        $data = $request->validated();
        $data['wajib'] = $request->boolean('wajib');

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
}
