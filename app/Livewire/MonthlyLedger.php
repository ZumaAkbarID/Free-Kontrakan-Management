<?php

namespace App\Livewire;

use App\Models\Ledgers;
use Carbon\Carbon;
use Livewire\Component;

class MonthlyLedger extends Component
{
    public $ledgers;
    public $selectedMonth;
    public $firstDateThisMonth;
    public $lastDateThisMonth;

    public function mount()
    {
        $this->firstDateThisMonth = Carbon::now()->startOfMonth();
        $this->lastDateThisMonth = Carbon::now()->endOfMonth();
        $this->selectedMonth = Carbon::now()->month;
        $this->ledgers = Ledgers::whereBetween('created_at', [$this->firstDateThisMonth, $this->lastDateThisMonth])->with('user')->get();
    }

    public function updatedSelectedMonth()
    {
        $carbon = Carbon::now();
        $this->firstDateThisMonth = Carbon::createFromDate($carbon->year, $this->selectedMonth, $carbon->day)->startOfMonth();
        $this->lastDateThisMonth = Carbon::createFromDate($carbon->year, $this->selectedMonth, $carbon->day)->endOfMonth();

        $this->ledgers = Ledgers::whereBetween('created_at', [$this->firstDateThisMonth, $this->lastDateThisMonth])->with('user')->get();
    }

    public function render()
    {
        return view('livewire.monthly-ledger');
    }
}
