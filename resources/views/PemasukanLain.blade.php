@extends('Layouts.Main')

@section('content')
    <div class="col-lg-12 col-sm-12 col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Pemasukan Lain</h4>

                <form action="" method="post" id="formUpload">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="">Anggota</label>
                        <select name="user_id" id="" class="form-control" required>
                            <option value="" selected disabled>-- Pilih --</option>
                            @foreach ($allUser as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Tujuan Pemasukan?</label>
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
@endsection
