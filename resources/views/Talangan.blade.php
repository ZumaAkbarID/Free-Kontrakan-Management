@extends('Layouts.Main')

@section('content')
    <div class="row">

        <div class="col-lg-6 col-sm-12 col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Histori Talangi <code class="text-danger">Personal</code></h4>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> Tujuan </th>
                                    <th> Jumlah </th>
                                    <th> Tanggal </th>
                                    <th> Dikembalikan? </th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($talanganPersonal as $item)
                                    <tr>
                                        <td> {{ $item->tujuan }} </td>
                                        <td> Rp. {{ number_format($item->amount, 0,',','.') }} </td>
                                        <td> {{ date('D, d M Y H:i:s', strtotime($item->created_at)) }} </td>
                                        <td>
                                            @if ($item->dikembalikan)
                                            <div class="badge bg-success">YA</div>
                                            @else
                                            <div class="badge bg-warning">BELUM</div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data coy</td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-12 col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Input Talangi</h4>
                    </p>

                    <form action="{{ route('Talangan.Personal') }}" method="post">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="">Tujuan Talangan?</label>
                            <input type="text" name="tujuan" id="tujuan" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Berapa duit? <code class="text-warning">tanpa titik, koma,
                                    dll</code></label>
                            <input type="number" name="amount" id="amount" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="formBtn" class="btn btn-primary">Kirim</button>
                        </div>


                    </form>

                </div>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Histori Talangi <code class="text-danger">All</code></h4>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> Nama </th>
                                    <th> Tujuan </th>
                                    <th> Jumlah </th>
                                    <th> Tanggal </th>
                                    <th> Dikembalikan? </th>
                                    @if ($user->role == "Bendahara")
                                      <th> Aksi Bendahara </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($talanganAll as $item)
                                    <tr>
                                        <td> {{ $item->user->name }} </td>
                                        <td> {{ $item->tujuan }} </td>
                                        <td> Rp. {{ number_format($item->amount, 0,',','.') }} </td>
                                        <td> {{ date('D, d M Y H:i:s', strtotime($item->created_at)) }} </td>
                                        <td>
                                          @if ($item->dikembalikan)
                                            <div class="badge bg-success">YA</div>
                                            @else
                                            <div class="badge bg-warning">BELUM</div>
                                            @endif
                                        </td>
                                        @if ($user->role == "Bendahara" && !$item->dikembalikan)
                                          <td> 
                                            <a href="{{ route('Talangan.Kembalikan', base64_encode($item->id)) }}" class="badge bg-success text-decoration-none">Set Done</a>  
                                          </td>
                                        @elseif($user->role == "Bendahara" && $item->dikembalikan)
                                        <td>
                                          <div class="badge bg-warning">Aman</div>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data coy</td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
