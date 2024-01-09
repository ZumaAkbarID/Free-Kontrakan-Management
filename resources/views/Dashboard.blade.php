@extends('Layouts/Main')

@section('content')
<div class="row">
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-danger card-img-holder text-white">
      <div class="card-body">
        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3">Sisa Saldo <i class="mdi mdi-cash-multiple mdi-24px float-right"></i>
        </h4>
        <h2 class="mb-5">Rp. {{ number_format($sisaSaldo, 0, ',', '.') }}</h2>
      </div>
    </div>
  </div>
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-info card-img-holder text-white">
      <div class="card-body">
        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3">Kas Terkumpul {{ date('M Y') }} <i class="mdi mdi-chart-arc mdi-24px float-right"></i>
        </h4>
        <h2 class="mb-5">Rp. {{ number_format($kasTerkumpul, 0, ',', '.') }}</h2>
        <h6 class="card-text">@if($kurangOrang < 1) Sip Coy Lunas Kabeh @else Kurang {{ $kurangOrang }} Anggota @endif</h6>
      </div>
    </div>
  </div>
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3">Talangan Bersama <i class="mdi mdi-cash mdi-24px float-right"></i>
        </h4>
        <h2 class="mb-5">Rp. {{ number_format($talanganBersama, 0, ',', '.') }}</h2>
        <h6 class="card-text">@if($talanganBersama > 0) <code class="text-danger">Belum kembali</code> @endif</h6>

      </div>
    </div>
  </div>
</div>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Ledger Bulan {{ date('M Y') }}</h4>
      </p>
      <div class="table-responsive">
        <table class="table">
          <tr>
            <td>WiFi <br>
              ID Pelanggan : 12615566 <br>
              Nama WIFI : THE BOYS 5 <br>
              Password : 1sampai10</td>
      
              <td>
                PDAM : 1300038 <br>
                PLN : 86030966864 <br>
              </td>
      
              <td>
                urutan air: <br>
              1. Alex <br>
              2. Zuma <br>
              3. Wahid <br>
              4. Bahar <br>
              5. Azka <br>
              </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Ledger Bulan {{ date('M Y') }}</h4>
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
                <img src="{{ asset('/storage') }}/profile/{{ $item->user->image }}" alt="image" />
              </td>
              <td> {{ $item->user->name }} </td>
              @if ($item->status === 'IN')
              <td> <span class="badge bg-success">{{ $item->transaction_purpose }}</span> </td>
              @else
              <td> <span class="badge bg-danger">{{ $item->transaction_purpose }}</span> </td>
              @endif
              <td> Rp. {{ number_format($item->amount, 0, ',','.') }} </td>
              <td> {{ date('D, d M Y H:i:s', strtotime($item->created_at)) }} </td>
              <td> 
                <a href="javascript:void(0)" class="badge bg-info text-decoration-none cek-button" data-bs-toggle="modal" data-bs-target="#myModal" data-img-src="{{ $item->manual_prof }}">Cek</a>
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

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bukti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex align-items-center justify-content-center">
        <!-- Include image here -->
        <img id="modalImage" src="" alt="Image Title" class="img-fluid">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('.cek-button').click(function() {
      var imgUrl = $(this).data('img-src');

      $('#modalImage').attr('src', imgUrl);
    });

    $('#myModal').on('hidden.bs.modal', function() {
      $('#modalImage').attr('src', '');
    });
  });
</script>
@endsection