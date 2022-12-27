@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show p-3" role="alert">
  <strong>Error: </strong> {{Session::get('error')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top: -4px;">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show p-3" role="alert">
  <strong>Message: </strong> {{Session::get('success')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top: -4px;">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif