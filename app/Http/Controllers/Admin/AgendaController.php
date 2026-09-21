<?php

// Controller agenda sisi ADMIN - kelola jadwal kegiatan desa

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAgendaRequest;
use App\Http\Requests\Admin\UpdateAgendaRequest;
use App\Models\Agenda;
use App\Models\User;
use App\Notifications\AgendaBaru;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class AgendaController extends Controller
{
    // Semua agenda, terdekat dulu 15 per halaman
    public function index(): View
    {
        $agendas = Agenda::orderBy('mulai')->paginate(15);

        return view('admin.agenda.index', compact('agendas'));
    }

    // Form tambah agenda baru
    public function create(): View
    {
        return view('admin.agenda.create');
    }

    // Simpan agenda baru
    public function store(StoreAgendaRequest $request): RedirectResponse
    {
        $agenda = Agenda::create($request->validated());

        // Beri tahu semua warga seperti survei baru
        $wargas = User::where('role', 'warga')->get();
        Notification::send($wargas, new AgendaBaru($agenda));

        return redirect()
            ->route('admin.agenda.show', $agenda)
            ->with('success', 'Agenda tersimpan.');
    }

    // Detail satu agenda
    public function show(Agenda $agenda): View
    {
        return view('admin.agenda.show', compact('agenda'));
    }

    // Form ubah agenda
    public function edit(Agenda $agenda): View
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    // Simpan perubahan agenda
    public function update(UpdateAgendaRequest $request, Agenda $agenda): RedirectResponse
    {
        $agenda->update($request->validated());

        return redirect()
            ->route('admin.agenda.show', $agenda)
            ->with('success', 'Agenda diperbarui.');
    }

    // Hapus agenda
    public function destroy(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda dihapus.');
    }
}
