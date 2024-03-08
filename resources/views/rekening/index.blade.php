@extends('layouts.main')

@section('title')
    Dashboard Admin
@endsection

@section('content')
    <div class="mx-1">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between">
                    <div class="">
                        <h5 class="m-0 font-weight-bold">Tabel Rekening</h5>
                    </div>
                    <div class="d-flex flex-row">
                        <form action="{{ route('rekening.index') }}" method="get" class="mr-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="search" placeholder="Pencarian" name="search" class="form-control" aria-label="Search" aria-describedby="basic-addon1" value="{{ request('search') }}">
                            </div>
                        </form>
                        <a href="{{ route('rekening.create') }}" class="btn btn-primary mb-2"><i class="fa fa-pencil-alt"></i> Tambah</a>
                        <a href="{{ route('export.rekening') }}" class="btn btn-primary mb-2"><i class="fa fa-pencil-alt"></i> Export</a>
                    </div>
                </div>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>Jenis Rekening</th>
                            <th>Sub Rekening</th>
                            <th>Nama Rekening</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($rekenings as $rekening)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rekening->jenis_rekening }}</td>
                            <td>{{ $rekening->sub_rekening }}</td>
                            <td>{{ $rekening->nama_rekening }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <a href="{{ route('rekening.edit', ['rekening' => $rekening->id_rekening]) }}" class="btn btn-info mr-3"><i class="fa fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-rekening-id="{{ $rekening->id_rekening }}"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <td colspan="10" class="text-center">Data tidak ada</td>
                        @endforelse
                    </table>
                    {{ $rekenings->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this rekening?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="post" action="">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('page_js')
        <script>
            $(document).ready(function () {
            $('.btn-danger').on('click', function () {
                var rekeningId = $(this).data('rekening-id');
                $('#deleteModal').data('rekening-id', rekeningId);
            });

            $('#deleteModal').on('show.bs.modal', function () {
                var rekeningId = $(this).data('rekening-id');
                var deleteUrl = "{{ route('rekening.destroy', ['rekening' => 'id']) }}";
                deleteUrl = deleteUrl.replace('id', rekeningId);
                $('#deleteForm').attr('action', deleteUrl);
            });
        });
        </script>
    @endpush
@endsection
