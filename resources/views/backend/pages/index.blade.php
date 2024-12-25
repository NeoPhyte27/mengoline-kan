@extends('backend.app')
@section('title')Create static pages @endsection
@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@section('content')
<div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
  <div class="breadcrumb-title pr-3">Dashboard</div>
  <div class="pl-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 p-0">
        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}"><i class='bx bx-home-alt'></i></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Pages</li>
      </ol>
    </nav>
  </div>
</div>
<div class="card border-lg-top-info radius-15">
  <div class="card-header border-bottom-0 mb-4">
    <div class="d-flex align-items-center">
      <div>
        <h5>All static pages</h5>
      </div>
      <div class="ml-auto">
        <a class="btn btn-primary" href="{{ route('app.pages.create') }}" data-toggle="tooltip" title="Create new static page  &#9989;"><i class="bx bx-plus"></i>Add</a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="example" class="table table-striped table-bordered text-center table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Title</th>
            <th>Status</th>
            <th>Last modified</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pages as $key => $page)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>
              <div class="media align-items-center">
                <img @if (file_exists($page->image)) src="/{{ $page->image }}"
                @else
                src="/images/no_image.jpg" @endif
                class="rounded-circle"
                alt=""
                width="45"
                height="45">
              </div>
            </td>
            <td>{{ $page->title }}</td>
            <td>
              @if ($page->status)
              <span class="badge badge-info rounded " data-toggle="tooltip" title="Page status is true &#128077">Active</span>
              @else
              <span class="badge badge-danger" data-toggle="tooltip" title="Page status is false &#128078">Inactive</span>
              @endif
            </td>
            <td>{{ $page->created_at->diffForHumans() }}</td>
            <td>
              @if (Auth::user()->hasPermission('app.pages.edit'))
              <a class="btn btn-sm btn-success" href="{{ route('app.pages.edit', $page->id) }}" data-toggle="tooltip" title="Edit &#128221"><i class="fadeIn animated bx bx-edit"></i>
              </a>
              @endif
              @if (Auth::user()->hasPermission('app.pages.destroy'))
              <form action="{{ route('app.pages.destroy', $page->id) }}" style="display: inline-block" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger delete-confirm" type="submit" data-toggle="tooltip" title="Delete &#128683">
                  <i class="fadeIn animated bx bx-trash"></i>
                </button>
              </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
@push('js')
<!--Data Tables js-->
<script src="{{ asset('backend/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
  $(function() {
    $("#example").DataTable({
      "responsive": true
      , "lengthChange": true
      , "autoWidth": false
      , "buttons": ["pdf", "print"]
      , "bDestroy": true
    , }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
  });

</script>
@endpush
