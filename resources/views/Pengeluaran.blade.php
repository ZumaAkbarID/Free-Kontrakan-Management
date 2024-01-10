@extends('Layouts.Main')

@section('content')
<div class="col-lg-12 col-sm-12 col-12 grid-margin">
  <div class="card">
      <div class="card-body">
          <h4 class="card-title">Input Pengeluaran</h4>

          <form action="" method="post" enctype="multipart/form-data" accept=".png,.jpg,.gif" id="formUpload">
              @csrf

              <div class="form-group mb-3">
                  <label for="">Tujuan Pengeluaran?</label>
                  <input type="text" name="tujuan" id="tujuan" class="form-control" required>
              </div>

              <div class="form-group mb-3">
                  <label for="">Berapa duit? <code class="text-warning">tanpa titik, koma,
                          dll</code></label>
                  <input type="number" name="amount" id="amount" class="form-control" required>
              </div>

              <img src="" alt="" width="300" class="img" id="imgPreview">

              <div class="form-group mb-3">
                  <label for="">Buktinya?
                  <input type="file" name="bukti" id="bukti" accept=".png,.jpg,.gif" class="form-control" required>
              </div>

              <div class="form-group">
                  <button type="submit" id="formBtn" class="btn btn-primary">Kirim</button>
              </div>


          </form>

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