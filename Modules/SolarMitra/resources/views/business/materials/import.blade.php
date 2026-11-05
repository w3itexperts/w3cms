{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <form action="{{ route('business.solarmitra.materials.import') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-8">
                <!-- Select List -->
                <!-- File Type & Upload -->
                <div class="card h-auto">
                    <div class="card-header bg-white fw-semibold">
                        Select File Type & Upload
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Excel Card -->
                            <div class="col-md-6">
                                <label for="import_file" class="upload-card text-center p-5 d-block">
                                    <i class="icon-file display-4 text-primary mb-3"></i>
                                    <h5 class="fw-semibold">Excel Files</h5>
                                    <p class="text-muted mb-2">Microsoft Excel Spreadsheets</p>
                                    <span class="file-badge">.xlsx, .xls</span>
                                </label>
                                <input type="file" class="form-control ps-2 img-business-input-onchange" name="import_file" id="import_file" accept=".xlsx" hidden="">
                                @error('import_file')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- CSV Card -->
                            <div class="col-md-6 d-none"> 
                                <label class="upload-card green text-center p-5 d-block">
                                    <i class="icon-file display-4 text-success mb-3"></i>
                                    <h5 class="fw-semibold">CSV Files</h5>
                                    <p class="text-muted mb-2">Comma Separated Values</p>
                                    <span class="file-badge">.csv</span>
                                </label>
                                <input type="file" class="form-control ps-2 img-business-input-onchange" name="import_csv_file" id="import_csv_file" accept=".csv" hidden="">
                                @error('import_csv_file')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.submit') }}</button>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <!-- Sample Template Card -->
                <div class="card h-auto">
                    <div class="card-header bg-light fw-semibold">
                        <span><i class="icon-download me-2"></i>Sample Template</span>
                    </div>
                    <div class="card-body text-center py-4">
                        <p class="text-muted mb-3">
                            Download our sample template to see the recommended format:
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ asset('modules/solarmitra/images/sample-material-excel.xlsx') }}" class="btn btn-outline-secondary">
                                <i class="icon-download me-2"></i>
                                Excel Template
                            </a>
                            <a href="#" class="btn btn-outline-secondary disabled">
                                <i class="icon-download me-2"></i>
                                CSV Template
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>

@endsection

@push('inline-css')
    <style>
        .upload-card {
            border: 2px dashed #0d6efd;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .upload-card:hover {
            background-color: #f8f9fa;
        }
        .upload-card.selected {
            border-color: #198754;
            background-color: #f0fdf4;
        }
        .upload-card.selected .icon-file {
            color: #198754;
        }
        .upload-card.green {
            border-color: #198754;
        }
        .file-badge {
            font-size: 0.75rem;
            background-color: #e9ecef;
            color: #6c757d;
            border-radius: 50px;
            padding: 3px 10px;
        }
        .file-name {
            font-size: 0.85rem;
            color: #198754;
            font-weight: 600;
            margin-top: 8px;
            display: none;
            word-break: break-all;
        }
        .file-name.show { display: block; }
    </style>
@endpush

@push('inline-scripts')
    <script>
        document.getElementById('import_file').addEventListener('change', function() {
            var card = this.previousElementSibling;
            var fileName = this.files[0] ? this.files[0].name : '';
            var nameEl = card.querySelector('.file-name');

            if (!nameEl) {
                nameEl = document.createElement('div');
                nameEl.className = 'file-name';
                card.appendChild(nameEl);
            }

            if (fileName) {
                nameEl.textContent = fileName;
                nameEl.classList.add('show');
                card.classList.add('selected');
            } else {
                nameEl.classList.remove('show');
                card.classList.remove('selected');
            }
        });
    </script>
@endpush
