@extends('Layouts.Main')

@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12 col-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Ingfo Rekening</h4>
                <p class="text-danger"><code>Nominal Wajib <b>Rp. {{ number_format($developer->kas_default, 0, ',','.') }}</b> Sesuai Kesepakatan</code></p>
          
                <ul class="text-white list-unstyled">
                    <li>{{ $developer->no_wallet }}</li>
                    <li>A.N {{ $developer->holder_wallet }}</li>
                </ul>
            </div>
          </div>
    </div>
    <div class="col-lg-8 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bayar Kas {{ date('M Y') }}</h4>
          
                <form action="" method="post" accept=".jpg,.png,.gif" id="formUpload" enctype="multipart/form-data">
                    @csrf
          
                    <img src="" alt="" width="300" class="img" id="imgPreview">
          
                    <div class="form-group mb-3">
                        <label for="">Upload bukti pembayaran</label>
                        <input type="file" name="bukti" id="bukti" class="form-control"
                            accept=".jpg,.png,.gif">
                    </div>
          
                    <button type="submit" id="formBtn" class="btn btn-primary">Kirim</button>
          
                </form>
          
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
@endsection