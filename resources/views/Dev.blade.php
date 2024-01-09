@extends('Layouts.Main')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Developer Zone</h4>
    <p class="card-description">Halo Zuma Ganteng</p>
    <form method="post" action="">
      @csrf

      <div class="row">
          <div class="form-group">

            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" name="liburan" class="form-check-input" @if($dev->liburan) checked @endif> Sedang Liburan </label>
            </div>

          </div>

          <div class="form-group">
            <label for="">Kas Default</label>
            <input type="text" name="kas_default" value="{{ $dev->kas_default }}" required class="form-control">
          </div>

          <div class="form-group">
            <label for="">API WA</label>
            <input type="text" name="api_wa" value="{{ $dev->api_wa }}" required class="form-control">
          </div>

          <div class="form-group">
            <label for="">[BANK] No Rek/Wallet</label>
            <input type="text" name="no_wallet" value="{{ $dev->no_wallet }}" required class="form-control">
          </div>

          <div class="form-group">
            <label for="">Holder Wallet</label>
            <input type="text" name="holder_wallet" value="{{ $dev->holder_wallet }}" required class="form-control">
          </div>

        
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection