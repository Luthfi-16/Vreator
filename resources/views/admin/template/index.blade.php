@extends('layouts.creator')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-4">All Templates</h4>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Template</th>
                        <th>Creator</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($templates as $template)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $template->title }}</td>
                        <td>{{ $template->user->name }}</td>
                        <td>Rp {{ number_format($template->price,0,',','.') }}</td>
                        <td>
                            <span class="badge {{ $template->status=='active'?'bg-success':'bg-secondary' }}">
                                {{ ucfirst($template->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info"
                                data-bs-toggle="modal"
                                data-bs-target="#templateModal{{ $template->id }}">
                                Detail
                            </button>

                            <form action="{{ route('admin.template.destroy',$template->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus template ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- MODAL --}}
                    <div class="modal fade" id="templateModal{{ $template->id }}">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $template->title }}</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <img src="{{ asset('storage/'.$template->preview) }}"
                                         class="img-fluid rounded mb-3">

                                    <p>{{ $template->description }}</p>

                                    <form action="{{ route('admin.template.update',$template->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('PUT')

                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="active" {{ $template->status=='active'?'selected':'' }}>Active</option>
                                            <option value="inactive" {{ $template->status=='inactive'?'selected':'' }}>Inactive</option>
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
