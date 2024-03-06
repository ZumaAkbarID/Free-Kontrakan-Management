<div>
    @inject('carbon', 'Carbon\Carbon')
    <div class="col-lg-12 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Ledger Bulan
                    <select name="" id="" wire:model.live='selectedMonth'>
                        <option value="1" @if ($selectedMonth == 1) selected @endif>Januari</option>
                        <option value="2" @if ($selectedMonth == 2) selected @endif>Februari</option>
                        <option value="3" @if ($selectedMonth == 3) selected @endif>Maret</option>
                        <option value="4" @if ($selectedMonth == 4) selected @endif>April</option>
                        <option value="5" @if ($selectedMonth == 5) selected @endif>Mei</option>
                        <option value="6" @if ($selectedMonth == 6) selected @endif>Juni</option>
                        <option value="7" @if ($selectedMonth == 7) selected @endif>Juli</option>
                        <option value="8" @if ($selectedMonth == 8) selected @endif>Agustus</option>
                        <option value="9" @if ($selectedMonth == 9) selected @endif>September</option>
                        <option value="10" @if ($selectedMonth == 10) selected @endif>Oktober</option>
                        <option value="11" @if ($selectedMonth == 11) selected @endif>November</option>
                        <option value="12" @if ($selectedMonth == 12) selected @endif>Desember</option>
                    </select>
                </h4>
                </p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> User </th>
                                <th> Nama </th>
                                <th> Tujuan </th>
                                <th> Jumlah </th>
                                <th> Tanggal </th>
                                <th> Bukti </th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($ledgers as $item)
                                <tr>
                                    <td class="py-1">
                                        <img src="{{ asset('/storage') }}/profile/{{ $item->user->image }}"
                                            alt="image" />
                                    </td>
                                    <td> {{ $item->user->name }} </td>
                                    @if ($item->status === 'IN')
                                        <td> <span class="badge bg-success">{{ $item->transaction_purpose }}</span>
                                        </td>
                                    @else
                                        <td> <span class="badge bg-danger">{{ $item->transaction_purpose }}</span> </td>
                                    @endif
                                    <td> Rp. {{ number_format($item->amount, 0, ',', '.') }} </td>
                                    <td> {{ $carbon::parse($item->created_at)->locale('id_ID')->translatedFormat('l, j F Y H:i:s') }}
                                    </td>
                                    <td>
                                        @if ($item->manual_prof)
                                            <a href="javascript:void(0)"
                                                class="badge bg-info text-decoration-none cek-button"
                                                data-bs-toggle="modal" data-bs-target="#myModal"
                                                data-img-src="{{ $item->manual_prof }}">Cek</a>
                                        @else
                                            <div class="badge bg-warning">No Foto</div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data coy</td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
