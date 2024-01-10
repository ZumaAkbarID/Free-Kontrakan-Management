@extends('Layouts.Main')
@inject('carbon', 'Carbon\Carbon')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Jadwal Piket</h4>
                    </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($jadwal as $item)
                                    <tr>
                                        <td>{{ $item->day_id }}</td>
                                        <td>
                                            @forelse ($item->jadwal as $jdwl)
                                                <span class="badge bg-info">{{ $jdwl->user->name }}</span>
                                            @empty
                                                <span class="badge bg-danger">Ga Ada</span>
                                            @endforelse
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-12 col-12 grid-margin">
            @if ($isPiket && !$donePiket)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Jadwal Piket</h4>
                        </p>

                        <form action="" method="post" accept=".jpg,.png,.gif" id="formUpload" enctype="multipart/form-data">
                            @csrf

                            <img src="" alt="" width="300" class="img" id="imgPreview">

                            <div class="form-group mb-3">
                                <label for="">Upload bukti piket</label>
                                <input type="file" name="bukti" id="bukti" class="form-control"
                                    accept=".jpg,.png,.gif">
                            </div>

                            <div class="form-group">
                                <button type="submit" id="formBtn" class="btn btn-primary">Kirim</button>
                            </div>


                        </form>

                    </div>
                </div>
            @elseif(!$isPiket && $donePiket)
              <div class="alert bg-success text-white">Nais Sir! Dah Piket</div>
            @else
                <div class="alert bg-warning">Lu ga ada jadwal boss nyantaii</div>
            @endif
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Histori Piket</h4>
          </p>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th> Profil </th>
                  <th> Nama </th>
                  <th> Tanggal </th>
                  <th> Bukti </th>
                </tr>
              </thead>
              <tbody>
    
                @forelse ($history as $item)
                <tr>
                  <td class="py-1">
                    <img src="{{ asset('/storage') }}/profile/{{ $item->user->image }}" alt="image" />
                  </td>
                  <td> {{ $item->user->name }} </td>
                  <td> {{ $carbon::parse($item->created_at)->locale('id_ID')->translatedFormat('l, j F Y H:i:s') }} </td>
                  <td> 
                    <a href="javascript:void(0)" class="badge bg-info text-decoration-none cek-button" data-bs-toggle="modal" data-bs-target="#myModal" data-img-src="{{ $item->bukti }}">Cek</a>
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
        $(document).ready(() => {
            const photoInp = $("#bukti");
            let imgURL;

            $('#formBtn').click((e) => {
                e.preventDefault();
                if (!imgURL) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Bjir...',
                        html: "EI ISI BUKTI DLU"
                    });
                    $('.swal2-select').addClass('d-none');
                } else {
                    $('#formUpload').submit();
                }

            });

            photoInp.change(function(e) {
                imgURL = URL.createObjectURL(e.target.files[0]);
                $("#imgPreview").attr("src", imgURL);
            });
        });
    </script>

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
