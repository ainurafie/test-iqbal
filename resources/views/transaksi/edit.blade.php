@extends('layouts.main')

@section('title')
    Dashboard Admin
@endsection

@section('content')
    <div class="row">
        <div class="col-10">
            <h5>Edit Tranaksi</h5>
            <input type="text" class="" id="allRekening" value="{{$rekenings}}" hidden>
            <form action="{{route('transaksi.update', ['transaksi' => $transaksi->id_transaksi])}}" id="custom_form" class="mt-5" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="id_rekening">Kode Rekening</label>
                            <select class="form-control" id="id_rekening" name="id_rekening">
                                <option value="" disabled selected>Pilih Kode Rekening</option>
                                @foreach ($rekenings as $rekening)
                                    <option value="{{ $rekening->id_rekening }}"
                                        @if ($transaksi->id_rekening == $rekening->id_rekening) selected @endif>{{ $rekening->jenis_rekening}}.{{$rekening->sub_rekening}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="nama_rekening">Nama Rekening</label>
                            <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="tanggal_setor">Tanggal Setor</label>
                            <input type="date" name="tanggal_setor" id="tanggal_setor" class="form-control"
                                value="{{ $transaksi->tanggal_setor }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="jumlah_setoe">Jumlah Setor (Rp)</label>
                            <input type="number" name="jumlah_setor" id="jumlah_setor"
                                value="{{ $transaksi->jumlah_setor }}" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" id="btn_submit" class="btn btn-primary px-4 mt-2">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('page_js')
    <script>
        $(document).ready(function() {
            var id_rekening = $("#id_rekening").val();
            var allRekening = JSON.parse($("#allRekening").val());

            var filteredData = allRekening.filter(function(item) {
                return item.id_rekening == id_rekening;
            });

            $("#sub_rekening").val(filteredData[0].sub_rekening);
            $("#nama_rekening").val(filteredData[0].nama_rekening);
        });

        $(document).on("change", "#id_rekening", function() {
            var id_rekening = $(this).val();
            var allRekening = JSON.parse($("#allRekening").val());

            var filteredData = allRekening.filter(function(item) {
                return item.id_rekening == id_rekening;
            });

            $("#sub_rekening").val(filteredData[0].sub_rekening);
            $("#nama_rekening").val(filteredData[0].nama_rekening);
        });

        $(document).on('click', '#btn_submit', function(e) {
            console.log('Button clicked'); // Debug statemen
            console.log('sss');
            e.preventDefault();
            customFormSubmit();
        });

        function customFormSubmit() {
            console.log('Submitting form'); // Debug statement
            $("#btn_submit").prop("disabled", true);

            let myForm = document.getElementById('custom_form');
            let formData = new FormData(myForm);

            const form = $(myForm);
            $.ajax({
                type: "POST",
                url: $('#custom_form').attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-HTTP-Method-Override': 'PATCH'
                },
                success: function(result) {
                    if (result.success) {
                        console.log('AJAX success:', result); // Debug statement
                        Swal.fire(result.message, '', 'success').then((res) => {
                            if (result.redirect) {
                                window.location.replace(result.redirect);
                            }
                        });
                    } else {
                        form.find('input, select, textarea').removeClass('is-invalid');
                        form.find('.invalid-feedback').remove();
                        Swal.fire(result.message, '', 'error');
                    }

                    // showLoading(false);
                },
                error: function(xhr, err, thrownError) {
                    console.log('AJAX error:', xhr, err, thrownError); // Debug statement
                    var errorsArray = [];

                    $(".invalid-feedback-modal").remove();

                    var data = xhr.responseJSON;
                    $.each(data.errors, function(key, v) {
                        form.find('input[name="' + key + '"]')
                            .addClass('is-invalid')
                            .after(`<div class="invalid-feedback invalid-feedback-modal float-start">` +
                                v[0] + `</div>`);
                        form.find('select[name="' + key + '"]')
                            .addClass('is-invalid')
                            .after(`<div class="invalid-feedback invalid-feedback-modal float-start">` +
                                v[0] + `</div>`);
                        form.find('textarea[name="' + key + '"]')
                            .addClass('is-invalid')
                            .after(`<div class="invalid-feedback invalid-feedback-modal float-start">` +
                                v[0] + `</div>`);

                        var errorObj = {
                            key: key,
                            text: v[0]
                        };
                        errorsArray.push(errorObj);
                    });

                    if (errorsArray.length > 0) {
                        var error_html = '';
                        $.each(errorsArray, function(index, value) {
                            error_html += `
                            <li class="text-start">` + value.text + `</li>
                        `;
                        });

                        Swal.fire({
                            title: '<strong>There is something wrong</strong>',
                            icon: 'warning',
                            html: `
                            <ul class="mb-0">
                                ` + error_html + `
                            </ul>
                        `,
                            showCloseButton: true,
                        });
                    }

                    // showLoading(false);
                }
            });

            $("#btn_submit").prop("disabled", false);
        }
    </script>
@endpush
