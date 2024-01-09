@extends('Layouts.Main')

@section('content')
<div class="row">
  <div class="col-lg-6 col-sm-12 col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pengaturan Akun</h4>
    
        <form class="forms-sample" action="{{ route('Pengaturan.Akun') }}" method="POST" id="formUpload" enctype="multipart/form-data" accept=".png,.jpg,.gif">
          @csrf
    
          <div class="form-group row">
            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Nama" name="name" value="{{ $user->name }}" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="exampleInputEmail2" placeholder="Username" name="username" value="{{ $user->username }}" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="exampleInputMobile" class="col-sm-3 col-form-label">WhatsApp</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" id="exampleInputMobile" placeholder="Nomor WA MU" name="whatsapp" value="{{ $user->whatsapp }}" required>
            </div>
          </div>
    
          <div class="form-group row">
            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">PP saat ini</label>
            <img src="{{ asset('/storage') }}/profile/{{ $user->image }}" alt="" width="300" style="max-width: 300px !important;" class="img" id="imgPreview">
          </div>
    
          <div class="form-group row">
            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">PP <code class="text-danger">ga wajib</code></label>
            <div class="col-sm-9">
              <input type="file" class="form-control" accept=".png,.jpg,.gif" id="ppImg" name="image">
            </div>
          </div>
          
          <button type="submit" id="formBtn" class="btn btn-gradient-primary me-2">Simpan</button>
        </form>
    
      </div>
    </div>
  </div>

  <div class="col-lg-6 col-sm-12 col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pengaturan Password</h4>
    
        <form class="forms-sample" action="{{ route('Pengaturan.Password') }}" method="POST">
          @csrf
    
          <div class="form-group row">
            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Password Baru</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="exampleInputUsername2" placeholder="Password" name="password" required>
            </div>
          </div>
          
          <div class="form-group row">
            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Konfirmasi Password</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="exampleInputUsername2" placeholder="Konfirmasi Password" name="password_confirmation" required>
            </div>
          </div>
          
          <button type="submit" class="btn btn-gradient-primary me-2">Perbarui</button>
        </form>
    
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  $(document).ready(() => {
      const photoInp = $("#ppImg");
      let imgURL;

      photoInp.change(function(e) {
          imgURL = URL.createObjectURL(e.target.files[0]);
          $("#imgPreview").attr("src", imgURL);
      });
  });
  </script>
@endsection