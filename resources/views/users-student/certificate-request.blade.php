@extends('layouts.app')

@section('title', 'Pengajuan Surat Keterangan')

@push('style')
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Pengajuan Surat Keterangan</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('student.dashboard') }}">Dashboard</a></div>
          <div class="breadcrumb-item">Pengajuan Surat Keterangan</div>
        </div>
      </div>

      <div class="section-body">
        <!-- Information Card -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4><i class="fas fa-info-circle mr-2"></i>Informasi Pengajuan</h4>
              </div>
              <div class="card-body">
                <div class="alert alert-info">
                  <h5><i class="fas fa-exclamation-triangle mr-2"></i>Syarat Pengajuan Surat Keterangan:</h5>
                  <ul class="mb-0">
                    <li>Telah mengikuti ujian TOEIC minimal 2 kali</li>
                    <li>Memiliki skor di bawah 500 pada ujian sebelumnya</li>
                    <li>Melampirkan sertifikat dari ujian sebelumnya</li>
                    <li>Memberikan komentar/alasan pengajuan</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Exam History -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4><i class="fas fa-history mr-2"></i>Riwayat Ujian Anda</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Exam ID</th>
                        <th>Jenis</th>
                        <th>Listening</th>
                        <th>Reading</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($examScores as $result)
                        <tr>
                          <td><strong class="text-primary">{{ $result->exam_id ?? 'N/A' }}</strong></td>
                          <td>{!! $result->exam_type_badge !!}</td>
                          <td><span class="badge badge-info">{{ $result->listening_score ?? 0 }}</span></td>
                          <td><span class="badge badge-info">{{ $result->reading_score ?? 0 }}</span></td>
                          <td>
                            <span class="badge {{ ($result->total_score ?? 0) >= 500 ? 'badge-success' : 'badge-danger' }}">
                              {{ $result->total_score ?? 0 }}
                            </span>
                          </td>
                          <td>
                            @if(($result->total_score ?? 0) >= 500)
                              <span class="badge badge-success"><i class="fas fa-check mr-1"></i> PASS</span>
                            @else
                              <span class="badge badge-danger"><i class="fas fa-times mr-1"></i> FAIL</span>
                            @endif
                          </td>
                          <td>
                            <small class="text-muted">
                              {{ $result->exam_date ? $result->exam_date->format('d M Y') : ($result->created_at ? $result->created_at->format('d M Y') : 'N/A') }}
                            </small>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Request Form -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4><i class="fas fa-file-alt mr-2"></i>Form Pengajuan</h4>
              </div>
              <div class="card-body">
                <form action="{{ route('student.certificate.request.submit') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  
                  <div class="form-group">
                    <label for="comment">Komentar/Alasan Pengajuan <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('comment') is-invalid @enderror" 
                              id="comment" 
                              name="comment" 
                              rows="5" 
                              placeholder="Jelaskan alasan Anda mengajukan surat keterangan..."
                              required>{{ old('comment') }}</textarea>
                    @error('comment')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="certificate_file">Upload Sertifikat Ujian Sebelumnya <span class="text-danger">*</span></label>
                    <input type="file" 
                           class="form-control-file @error('certificate_file') is-invalid @enderror" 
                           id="certificate_file" 
                           name="certificate_file" 
                           accept=".pdf,.jpg,.jpeg,.png"
                           required>
                    <small class="form-text text-muted">
                      Format yang diizinkan: PDF, JPG, JPEG, PNG. Maksimal 5MB.
                    </small>
                    @error('certificate_file')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <div class="d-flex justify-content-between">
                      <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                      </a>
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane mr-1"></i> Kirim Pengajuan
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@push('scripts')
  <!-- JS Libraries -->
  <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      // File upload validation
      $('#certificate_file').on('change', function() {
        const file = this.files[0];
        if (file) {
          const fileSize = file.size / 1024 / 1024; // Convert to MB
          const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
          
          if (fileSize > 5) {
            alert('Ukuran file terlalu besar. Maksimal 5MB.');
            this.value = '';
            return;
          }
          
          if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak diizinkan. Gunakan PDF, JPG, JPEG, atau PNG.');
            this.value = '';
            return;
          }
        }
      });
    });
  </script>
@endpush
