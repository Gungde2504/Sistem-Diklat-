<?php

namespace App\Livewire\Admin\RekapJam;

use App\Actions\RekapJam\CalculateRekapJamAction;
use App\Helpers\RekapHelper;
use App\Models\MUnit;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Rekap Jam Pelatihan')]
class RekapJamIndex extends Component
{
    use WithPagination;

    public string $search  = '';
    public string $unit    = '';
    public string $tahun   = '';
    public string $filter  = 'semua'; // semua | kurang | terpenuhi
    public string $tipe    = 'semua'; // semua | internal | karyawan
    public float  $target  = 20;

    public function mount(): void
    {
        $this->tahun = (string) now()->year;
    }

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingUnit(): void   { $this->resetPage(); }
    public function updatingFilter(): void { $this->resetPage(); }
    public function updatingTipe(): void   { $this->resetPage(); }

    public function render()
    {
        $action = app(CalculateRekapJamAction::class);

        $karyawanJenis = [
            'karyawan_iss', 'karyawan_bss', 'karyawan_adidaya',
            'karyawan_bayi_tabung', 'karyawan_koperasi', 'karyawan_lotus_spa',
        ];

        $query = User::where('isActive', 1)
            ->where(function ($q) use ($karyawanJenis) {
                // Internal
                $q->where('type', 'internal')
                  ->orWhere(function ($q2) use ($karyawanJenis) {
                      // Karyawan external yang approved
                      $q2->where('type', 'external')
                         ->whereHas('detailEksternal', fn($d) =>
                             $d->whereIn('jenis', $karyawanJenis)
                               ->where('approval_status', 'approved')
                         );
                  });
            })
            ->when($this->search, fn($q) =>
                $q->where('nama', 'like', '%'.$this->search.'%')
                  ->orWhere('nip', 'like', '%'.$this->search.'%')
            )
            ->when($this->unit, fn($q) => $q->where('unit', $this->unit))
            ->when($this->tipe === 'internal',  fn($q) => $q->where('type', 'internal'))
            ->when($this->tipe === 'karyawan',  fn($q) => $q->where('type', 'external'))
            ->orderBy('nama');

        $allUsers = $query->get()->map(function (User $user) use ($action, $karyawanJenis) {
            $rekap     = $action->execute($user->id, (int) $this->tahun);
            $totalJam  = $rekap->total();
            $terpenuhi = $rekap->sudahMemenuhiTarget($this->target);

            // Cek tipe user
            $isKaryawan = $user->type === 'external'
                && $user->detailEksternal
                && in_array($user->detailEksternal->jenis, $karyawanJenis);

            return [
                'user'          => $user,
                'is_karyawan'   => $isKaryawan,
                'total_jam'     => $totalJam,
                'jam_acara'     => $rekap->jamDiklatAcara,
                'jam_mandiri'   => $rekap->jamDiklatMandiri,
                'jam_elearning' => $rekap->jamElearning,
                'terpenuhi'     => $terpenuhi,
                'persen'        => RekapHelper::persentaseProgress($totalJam, $this->target),
                // Kekurangan jam — otomatis dari elearning jika < 20
                'kekurangan'    => max(0, round($this->target - $totalJam, 2)),
            ];
        });

        // Filter status
        $filtered = $allUsers
            ->when($this->filter === 'kurang',    fn($c) => $c->filter(fn($r) => !$r['terpenuhi']))
            ->when($this->filter === 'terpenuhi', fn($c) => $c->filter(fn($r) => $r['terpenuhi']));

        // Stats
        $totalKaryawan  = $allUsers->count();
        $sudahTerpenuhi = $allUsers->where('terpenuhi', true)->count();
        $belumTerpenuhi = $allUsers->where('terpenuhi', false)->count();
        $rataRataJam    = $totalKaryawan > 0 ? round($allUsers->avg('total_jam'), 1) : 0;

        // Manual pagination
        $page    = $this->getPage();
        $perPage = 15;
        $items   = $filtered->forPage($page, $perPage)->values();
        $total   = $filtered->count();

        $units = MUnit::orderBy('nama')->get();

        return view('livewire.admin.rekap-jam.rekap-jam-index', [
            'rekaps'         => $items,
            'totalPages'     => ceil($total / $perPage),
            'currentPage'    => $page,
            'totalItems'     => $total,
            'totalKaryawan'  => $totalKaryawan,
            'sudahTerpenuhi' => $sudahTerpenuhi,
            'belumTerpenuhi' => $belumTerpenuhi,
            'rataRataJam'    => $rataRataJam,
            'units'          => $units,
        ]);
    }
}