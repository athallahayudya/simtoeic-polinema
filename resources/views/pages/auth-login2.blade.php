<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; SIMTOEIC</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo-simtoeic.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo-simtoeic.png') }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/no-scroll.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex align-items-stretch flex-wrap">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="m-3 p-4">
                        <img src="{{ asset('img/logo-polinema.png') }}" alt="logo" width="80"
                            class="shadow-light rounded-circle mb-5 mt-2 mx-auto d-block">
                        <h4 class="text-dark font-weight-normal">Welcome to <span
                                class="font-weight-bold">SIMTOEIC</span> Politeknik Negeri Malang
                        </h4>
                        <p class="text-muted">Please log in to proceed with your TOEIC registration</p>
                        <form method="POST" action="{{ route('auth.process') }}" class="needs-validation" novalidate="">
                            @csrf
                            <div class="form-group">
                                <label for="identity_number">Identity Number</label>
                                <input id="identity_number" type="text"
                                    class="form-control @error('identity_number') is-invalid @enderror"
                                    name="identity_number" value="{{ old('identity_number') }}" tabindex="1" required
                                    autofocus>
                                @error('identity_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Please fill in your identity number</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                </div>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        tabindex="2" required>
                                    <div class="input-group-append">
                                        <button class="btn border-left-0 password-toggle-btn" type="button" id="password-toggle">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please fill in your password</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="4"
                                        id="remember-me">
                                    <label class="custom-control-label" for="remember-me">Remember Me</label>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right w-100"
                                    tabindex="5">
                                    Login
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted">Don't have an account?
                                <a href="#" class="text-primary" data-toggle="modal" data-target="#registrationInfoModal" style="text-decoration: none;">
                                    Register here
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 background-walk-y position-relative overlay-gradient-bottom order-1"
                    data-background="{{ asset('img/gedung-polinema.jpg') }}"
                    style="min-height: 105vh; height: 105vh;">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-5 pb-3">
                                <h1 class="display-4 font-weight-bold mb-2">TOEIC Registration Portal</h1>
                                <h5 class="font-weight-normal text-muted-transparent">Malang, Indonesia</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Registration Info Modal -->
    <div class="modal fade" id="registrationInfoModal" tabindex="-1" role="dialog" aria-labelledby="registrationInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="registrationInfoModalLabel">
                        <i class="fas fa-info-circle mr-2"></i>Registration Information
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-shield fa-3x text-primary mb-3"></i>
                    </div>
                    <h6 class="font-weight-bold mb-3">Account Registration</h6>
                    <p class="text-muted mb-4">
                        New user registration for SIMTOEIC is managed by the system administrator.
                        Please contact the admin to create your account.
                    </p>
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <strong>How it works:</strong>
                        <ul class="text-left mt-2 mb-0">
                            <li>Contact the system administrator</li>
                            <li>Provide your personal information</li>
                            <li>Admin will create your account</li>
                            <li>You'll receive login credentials</li>
                        </ul>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Important:</strong> Only authorized personnel can register for TOEIC exams through this system.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="contactAdmin()">
                        <i class="fas fa-envelope mr-2"></i>Contact Admin
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/password-toggle.js') }}"></script>

    <!-- Registration Modal JS -->
    <script>
        function contactAdmin() {
            // Show contact information in a more user-friendly way
            const adminEmail = 'admin@polinema.ac.id';
            const subject = 'Request for SIMTOEIC Account Registration';
            const body = 'Dear Admin,%0D%0A%0D%0AI would like to request an account for the SIMTOEIC system.%0D%0A%0D%0APlease provide me with the necessary information and steps to complete my registration.%0D%0A%0D%0AThank you.';

            // Show confirmation dialog with contact options
            if (confirm('Contact Admin via:\n\n1. Email: admin@polinema.ac.id\n2. Visit IT Department\n3. Call: (0341) 404424\n\nClick OK to open email client or Cancel to close.')) {
                window.location.href = `mailto:${adminEmail}?subject=${subject}&body=${body}`;
            }

            // Close modal after action
            $('#registrationInfoModal').modal('hide');
        }
    </script>
</body>
</html>=
