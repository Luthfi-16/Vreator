@extends('layouts.creator')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-4">All Services</h4>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Creator</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->title }}</td>
                        <td>{{ $service->user->name }}</td>
                        <td>Rp {{ number_format($service->price,0,',','.') }}</td>
                        <td>
                            <span class="badge {{ $service->status=='active'?'bg-success':'bg-secondary' }}">
                                {{ ucfirst($service->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info"
                                data-bs-toggle="modal"
                                data-bs-target="#serviceModal{{ $service->id }}">
                                Detail
                            </button>

                            <form action="{{ route('admin.service.destroy',$service->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus service ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- MODAL --}}
                    <div class="modal fade" id="serviceModal{{ $service->id }}">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $service->title }}</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p>{{ $service->description }}</p>

                                    <form action="{{ route('admin.service.update',$service->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('PUT')

                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="active" {{ $service->status=='active'?'selected':'' }}>Active</option>
                                            <option value="inactive" {{ $service->status=='inactive'?'selected':'' }}>Inactive</option>
                                        </select>

                                        <button class="btn btn-primary mt-3">
                                            Update Status
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
