@extends('layouts.app')

@section('title', 'Telegram Settings')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="font-size: 21px;">Telegram Notification Settings</h1>
            </div>

            <div class="section-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Bot Status Card -->
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Bot Status</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Connection Status</label>
                                    <div>
                                        @if($is_connected)
                                            <span class="badge badge-success">Connected</span>
                                        @else
                                            <span class="badge badge-danger">Disconnected</span>
                                        @endif
                                    </div>
                                </div>

                                @if($bot_info && $is_connected)
                                    <div class="form-group">
                                        <label>Bot Information</label>
                                        <div class="bg-light p-3 rounded">
                                            <strong>Name:</strong> {{ $bot_info['result']['first_name'] ?? 'N/A' }}<br>
                                            <strong>Username:</strong> @{{ $bot_info['result']['username'] ?? 'N/A' }}<br>
                                            <strong>ID:</strong> {{ $bot_info['result']['id'] ?? 'N/A' }}
                                        </div>
                                    </div>
                                @endif

                                <button type="button" class="btn btn-primary" onclick="testConnection()">
                                    <i class="fas fa-sync"></i> Test Connection
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Bot Token</h4>
                            </div>
                            <div class="card-body">
                                <form id="tokenForm">
                                    @csrf
                                    <div class="form-group">
                                        <label>Bot Token</label>
                                        <input type="text" name="bot_token" id="bot_token" class="form-control"
                                            value="{{ $bot_token }}" placeholder="Enter your Telegram bot token">
                                        <small class="form-text text-muted">
                                            Get your bot token from @BotFather on Telegram
                                        </small>
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Token
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Test Message Card -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Send Test Message</h4>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning">
                                    <h5><i class="fas fa-exclamation-triangle"></i> Before Testing:</h5>
                                    <ol>
                                        <li><strong>Get your Chat ID:</strong> Message <code>@userinfobot</code> on Telegram
                                        </li>
                                        <li><strong>Start the bot:</strong> Search and start <code>@simtopolinema_bot</code>
                                        </li>
                                        <li><strong>Use numbers only:</strong> Chat ID should be numbers like
                                            <code>123456789</code>
                                        </li>
                                    </ol>
                                    <small><strong>Common Error:</strong> "Chat not found" means you haven't started the bot
                                        or wrong Chat ID.</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="testMessageForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chat ID</label>
                                                <input type="text" name="chat_id" id="chat_id" class="form-control"
                                                    placeholder="Enter your chat ID (numbers only)">
                                                <small class="form-text text-muted">
                                                    <strong>How to get your Chat ID:</strong><br>
                                                    1. Open Telegram and search for <code>@userinfobot</code><br>
                                                    2. Click START and send any message<br>
                                                    3. Copy the "Your chat ID" number<br>
                                                    4. Make sure you've started <code>@simtopolinema_bot</code> first!
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Test Message</label>
                                                <input type="text" name="message" id="message" class="form-control"
                                                    value="Test message from SIMTOEIC Polinema"
                                                    placeholder="Enter test message">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-paper-plane"></i> Send Test Message
                                    </button>
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
    <script>
        $(document).ready(function () {
            function testConnection() {
                $.ajax({
                    url: "{{ route('telegram.test') }}",
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire('Success!', response.message, 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to test connection', 'error');
                    }
                });
            }

            // Make testConnection function global
            window.testConnection = testConnection;

            $('#tokenForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('telegram.update-token') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.status) {
                            Swal.fire('Success!', response.message, 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to update token', 'error');
                    }
                });
            });

            $('#testMessageForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('telegram.send-test') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.status) {
                            Swal.fire('Success!', response.message, 'success');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to send test message', 'error');
                    }
                });
            });
        });
    </script>
@endpush