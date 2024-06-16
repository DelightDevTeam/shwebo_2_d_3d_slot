@extends('admin_layouts.app')
@section('styles')
<style>
  .transparent-btn {
    background: none;
    border: none;
    padding: 0;
    outline: none;
    cursor: pointer;
    box-shadow: none;
    appearance: none;
    /* For some browsers */
  }
</style>
@endsection
@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <!-- Card header -->
      <div class="card-header pb-0">
        <div class="d-lg-flex">
          <div>
            <h5 class="mb-0">Deposit Requested Lists</h5>

          </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-flush" id="users-search">
      <thead class="thead-light">
        <th>#</th>
        <th>Name</th>
        <th>Requested Amount</th>
        <th>Payment Method</th>
        <th>Account Name</th>
        <th>Account No</th>
        <th>RefrenceNo</th>
        <th>Status</th>
        <th>Created_at</th>
        <th>Action</th>
      </thead>
      <tbody>
        @foreach ($deposits as $deposit)

        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>
            <span class="d-block">{{ $deposit->user->user_name }}</span>
          </td>
          <td>{{ number_format($deposit->amount) }}</td>
          <td>{{ $deposit->userPayment->paymentType->name}}</td>
          <td>{{ $deposit->userPayment->account_name }}</td>
          <td>{{$deposit->userPayment->account_no}}</td>
          <td>{{$deposit->refrence_no}}</td>
          <td>
          <span class="badge text-bg-{{ $deposit->status == 0 ? 'danger' : ($deposit->status == 1 ? 'success' : 'warning') }} text-white mb-2">
            {{ $deposit->status == 0 ? "pending" : ($deposit->status == 1 ? "approved" : "rejected") }}
        </span>
          </td>

          <td>{{ $deposit->created_at}}</td>
          <td>
            @if($deposit->status == 0 )
            <a href="{{route('admin.agent.depositshow',$deposit->id)}}" class="btn btn-primary" disabled >Update</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('admin_app/assets/js/plugins/datatables.js') }}"></script>

<script>
  if (document.getElementById('users-search')) {
    const dataTableSearch = new simpleDatatables.DataTable("#users-search", {
      searchable: true,
      fixedHeight: false,
      perPage: 7
    });

    document.querySelectorAll(".export").forEach(function(el) {
      el.addEventListener("click", function(e) {
        var type = el.dataset.type;

        var data = {
          type: type,
          filename: "material-" + type,
        };

        if (type === "csv") {
          data.columnDelimiter = "|";
        }

        dataTableSearch.export(data);
      });
    });
  };
</script>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
@endsection