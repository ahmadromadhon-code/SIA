<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card login-card border-0">
                    <div class="card-header login-header text-center py-4">
                        <h3><i class="fas fa-graduation-cap me-2"></i>SIA</h3>
                        <p class="mb-0">Sistem Informasi Akademik</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= $this->session->flashdata('error'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?= form_open('auth/proses_login', ['class' => 'needs-validation', 'novalidate' => '']); ?>
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user me-2"></i>Username
                                </label>
                                <input type="text" class="form-control" name="username" required>
                                <div class="invalid-feedback">
                                    Username harus diisi.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <input type="password" class="form-control" name="password" required>
                                <div class="invalid-feedback">
                                    Password harus diisi.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-user-tag me-2"></i>Login Sebagai
                                </label>
                                <select class="form-select" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="guru">Guru</option>
                                    <option value="siswa">Siswa</option>
                                </select>
                                <div class="invalid-feedback">
                                    Role harus dipilih.
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </div>
                        <?= form_close(); ?>
                    </div>
                    <div class="card-footer text-center text-muted py-3">
                        <small>&copy; 2025 Sistem Informasi Akademik</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>