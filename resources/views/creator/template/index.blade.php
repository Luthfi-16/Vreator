@extends('layouts.creator')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">My Templates</h4>
        <a href="{{ route('creator.template.create') }}" class="btn btn-primary">
            + Add Template
        </a>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Template</th>
                            <th>Price</th>
                            <th>Preview</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($templates as $template)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $template->title }}</strong>
                                    <div class="text-muted small">
                                        {{ Str::limit($template->description, 50) }}
                                    </div>
                                </td>

                                <td>
                                    @if ($template->price == 0)
                                        <span class="badge bg-success">Free</span>
                                    @else
                                        Rp {{ number_format($template->price, 0, ',', '.') }}
                                    @endif
                                </td>

                                <td>
                                    <img src="{{ asset('storage/' . $template->preview) }}"
                                         alt="Preview"
                                         width="70"
                                         class="rounded shadow-sm">
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('creator.template.edit', $template->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('creator.template.destroy', $template->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin hapus template ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada template 😴
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
