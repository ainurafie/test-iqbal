@extends('layouts.main')

@section('title')
    Dashboard Admin
@endsection

@section('content')
    <div class="row">
        <div class="col-10">
            <h5>Buat Target</h5>
            <form action="{{ route('target.store') }}" method="post" id="custom_form" class="mt-5" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="jenis_rekening">Jenis Rekening</label>
                            <select class="form-control" id="jenis_rekening" name="jenis_rekening">
                                <option value="" disabled selected>Pilih Jenis Rekening</option>
                                @foreach ($rekenings as $rekening)
                                <option value="{{ $rekening->id }}">{{ $rekening->jenis_rekening }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="sub_rekening">Sub Rekening</label>
                            <input type="text" name="sub_rekening" id="sub_rekening"  class="form-control" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="nama_rekening">Nama Rekening</label>
                            <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="tahun">Tahun Anggaran</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="jumlah_target">Target (Rp)</label>
                            <input type="number" name="jumlah_target" id="jumlah_target" class="form-control">
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
    $(document).on('click', '#btn_submit', function(e) {
            e.preventDefault();
            customFormSubmit();
        });

        function customFormSubmit() {
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
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result.success) {
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
                error: function (xhr, err, thrownError) {
                    var errorsArray = [];

                    $(".invalid-feedback-modal").remove();

                    var data = xhr.responseJSON;
                    $.each(data.errors, function (key, v) {
                        form.find('input[name="' + key + '"]')
                            .addClass('is-invalid')
                            .after(`<div class="invalid-feedback invalid-feedback-modal float-start">` + v[0] + `</div>`);
                        form.find('select[name="' + key + '"]')
                            .addClass('is-invalid')
                            .after(`<div class="invalid-feedback invalid-feedback-modal float-start">` + v[0] + `</div>`);
                        form.find('textarea[name="' + key + '"]')
                            .addClass('is-invalid')
                            .after(`<div class="invalid-feedback invalid-feedback-modal float-start">` + v[0] + `</div>`);

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
