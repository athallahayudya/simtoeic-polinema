@extends('layouts.app')

@section('title', 'Kelola Pengajuan Surat Keterangan')

@push('style')
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/sweetalert/sweetalert2.min.css') }}">
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Kelola Pengajuan Surat Keterangan</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
          <div class="breadcrumb-item">Pengajuan Surat Keterangan</div>
        </div>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4><i class="fas fa-certificate mr-2"></i>Daftar Pengajuan Surat Keterangan</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="certificate-requests-table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Data will be loaded via DataTables -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- View Request Modal -->
  <div class="modal fade" id="viewRequestModal" tabindex="-1" role="dialog" aria-labelledby="viewRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewRequestModalLabel">
            <i class="fas fa-eye mr-2"></i>Detail Pengajuan Surat Keterangan
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <h6><strong>Informasi Mahasiswa</strong></h6>
              <p><strong>Nama:</strong> <span id="modal-student-name"></span></p>
              <p><strong>NIM:</strong> <span id="modal-student-nim"></span></p>
            </div>
            <div class="col-md-6">
              <h6><strong>Informasi Pengajuan</strong></h6>
              <p><strong>Tanggal:</strong> <span id="modal-created-at"></span></p>
              <p><strong>Status:</strong> <span id="modal-status"></span></p>
            </div>
          </div>
          
          <div class="row mt-3">
            <div class="col-12">
              <h6><strong>Komentar/Alasan:</strong></h6>
              <p id="modal-comment" class="border p-3 bg-light"></p>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">
              <h6><strong>Sertifikat yang Dilampirkan:</strong></h6>
              <div id="modal-certificate-preview"></div>
            </div>
          </div>

          <div class="row mt-3" id="admin-notes-section" style="display: none;">
            <div class="col-12">
              <h6><strong>Catatan Admin:</strong></h6>
              <p id="modal-admin-notes" class="border p-3 bg-light"></p>
              <p><strong>Diproses oleh:</strong> <span id="modal-approved-by"></span></p>
              <p><strong>Tanggal Diproses:</strong> <span id="modal-approved-at"></span></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Approve Modal -->
  <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="approveModalLabel">
            <i class="fas fa-check mr-2"></i>Setujui Pengajuan
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="approveForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="approve-admin-notes">Catatan Admin (Opsional)</label>
              <textarea class="form-control" id="approve-admin-notes" name="admin_notes" rows="3" 
                        placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">
              <i class="fas fa-check mr-1"></i>Setujui
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Reject Modal -->
  <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rejectModalLabel">
            <i class="fas fa-times mr-2"></i>Tolak Pengajuan
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="rejectForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="reject-admin-notes">Alasan Penolakan <span class="text-danger">*</span></label>
              <textarea class="form-control" id="reject-admin-notes" name="admin_notes" rows="3" 
                        placeholder="Jelaskan alasan penolakan..." required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">
              <i class="fas fa-times mr-1"></i>Tolak
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- JS Libraries -->
  <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/modules/sweetalert/sweetalert2.all.min.js') }}"></script>
  
  <script>
    let table;
    let currentRequestId;

    $(document).ready(function() {
      // Initialize DataTable
      table = $('#certificate-requests-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.certificate.requests.data") }}',
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
          { data: 'student_info', name: 'student_info' },
          { data: 'formatted_date', name: 'created_at' },
          { data: 'status_badge', name: 'status' },
          { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[2, 'desc']]
      });
    });

    // View request details
    function viewRequest(id) {
      $.get(`/admin/certificate-requests/${id}`)
        .done(function(response) {
          if (response.success) {
            const data = response.data;
            
            $('#modal-student-name').text(data.student_name);
            $('#modal-student-nim').text(data.student_nim);
            $('#modal-created-at').text(data.created_at);
            $('#modal-status').html(getStatusBadge(data.status));
            $('#modal-comment').text(data.comment);
            
            // Show certificate preview
            const certificateUrl = `/storage/${data.certificate_file}`;
            const fileExtension = data.certificate_file.split('.').pop().toLowerCase();
            
            if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
              $('#modal-certificate-preview').html(`<img src="${certificateUrl}" class="img-fluid" style="max-height: 300px;">`);
            } else {
              $('#modal-certificate-preview').html(`<a href="${certificateUrl}" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf mr-1"></i>Lihat PDF</a>`);
            }
            
            // Show admin notes if processed
            if (data.status !== 'pending') {
              $('#admin-notes-section').show();
              $('#modal-admin-notes').text(data.admin_notes || 'Tidak ada catatan');
              $('#modal-approved-by').text(data.approved_by || 'N/A');
              $('#modal-approved-at').text(data.approved_at);
            } else {
              $('#admin-notes-section').hide();
            }
            
            $('#viewRequestModal').modal('show');
          }
        })
        .fail(function() {
          Swal.fire('Error', 'Gagal memuat detail pengajuan', 'error');
        });
    }

    // Approve request
    function approveRequest(id) {
      currentRequestId = id;
      $('#approveModal').modal('show');
    }

    // Reject request
    function rejectRequest(id) {
      currentRequestId = id;
      $('#rejectModal').modal('show');
    }

    // Handle approve form submission
    $('#approveForm').on('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      
      $.ajax({
        url: `/admin/certificate-requests/${currentRequestId}/approve`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.success) {
            $('#approveModal').modal('hide');
            Swal.fire('Berhasil', response.message, 'success');
            table.ajax.reload();
          } else {
            Swal.fire('Error', response.message, 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Terjadi kesalahan saat memproses pengajuan', 'error');
        }
      });
    });

    // Handle reject form submission
    $('#rejectForm').on('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      
      $.ajax({
        url: `/admin/certificate-requests/${currentRequestId}/reject`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.success) {
            $('#rejectModal').modal('hide');
            Swal.fire('Berhasil', response.message, 'success');
            table.ajax.reload();
          } else {
            Swal.fire('Error', response.message, 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Terjadi kesalahan saat memproses pengajuan', 'error');
        }
      });
    });

    // Helper function to get status badge
    function getStatusBadge(status) {
      switch(status) {
        case 'pending':
          return '<span class="badge badge-warning">Pending</span>';
        case 'approved':
          return '<span class="badge badge-success">Approved</span>';
        case 'rejected':
          return '<span class="badge badge-danger">Rejected</span>';
        default:
          return '<span class="badge badge-secondary">Unknown</span>';
      }
    }
  </script>
@endpush
