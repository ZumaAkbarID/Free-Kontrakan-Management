<script>
  @if ($errors->any())
      Swal.fire({
          icon: 'error',
          title: 'Bjir...',
          html: "{!! implode('', $errors->all('<div>:message</div>')) !!}"
      });
      $('.swal2-select').addClass('d-none');
  @endif
  @if (session()->has('error'))
      Swal.fire({
          icon: 'error',
          title: 'Bjir...',
          html: "{!! session('error') !!}"
      });
      $('.swal2-select').addClass('d-none');
  @endif
  @if (session()->has('success'))
      Swal.fire({
          icon: 'success',
          title: 'Okeh',
          html: "{!! session('success') !!}"
      });
  @endif
  @if (session()->has('info'))
      Swal.fire({
          icon: 'info',
          title: 'Ingfo',
          html: "{!! session('info') !!}"
      });
  @endif
</script>