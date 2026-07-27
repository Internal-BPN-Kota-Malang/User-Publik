<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin - Kantor Pertanahan</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background:
      linear-gradient(180deg, rgba(10,14,20,0.55) 0%, rgba(10,14,20,0.45) 50%, rgba(10,14,20,0.7) 100%),
      url('malang.jpg');
    background-size: cover;
    background-position: center;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
  }

  .login-card {
    width: 100%;
    max-width: 400px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.25);
    padding: 40px 34px;
    position: relative;
    overflow: hidden;
  }

  .login-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 6px;
    background: linear-gradient(90deg, #17b8c4, #2f5a8a);
  }

  .login-brand {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 28px;
  }

  .login-brand img {
    width: 64px; height: 64px;
    border-radius: 50%;
    object-fit: cover;
    background: #fdf6ee;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    margin-bottom: 14px;
  }

  .login-brand h1 {
    font-size: 18px;
    font-weight: 800;
    color: #1e2a3a;
    text-align: center;
  }

  .login-brand p {
    font-size: 12.5px;
    color: #8b95a5;
    margin-top: 4px;
    text-align: center;
  }

  .field { margin-bottom: 18px; }

  .field label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #333;
    margin-bottom: 7px;
  }

  .field input {
    width: 100%;
    border: 1px solid #d8dde3;
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .field input:focus {
    border-color: #17b8c4;
    box-shadow: 0 0 0 3px rgba(23,184,196,0.12);
  }

  .field-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
    font-size: 12.5px;
  }

  .field-row label {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #5a6b7d;
    cursor: pointer;
  }

  .field-row a { color: #17b8c4; text-decoration: none; font-weight: 600; }
  .field-row a:hover { text-decoration: underline; }

  .btn-login {
    width: 100%;
    background: linear-gradient(90deg, #17b8c4, #2f5a8a);
    color: #fff;
    border: none;
    padding: 13px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: filter 0.2s, transform 0.15s;
  }
  .btn-login:hover { filter: brightness(1.06); transform: translateY(-1px); }

  .error-box {
    background: #fcebeb;
    color: #791f1f;
    font-size: 12.5px;
    padding: 12px 14px;
    border-radius: 8px;
    margin-bottom: 18px;
    display: none;
  }

  .login-footer {
    margin-top: 26px;
    text-align: center;
    font-size: 12px;
    color: #9aa4af;
  }

  .login-footer a { color: #17b8c4; text-decoration: none; font-weight: 600; }
</style>
</head>
<body>

<div class="login-card">
  <div class="login-brand">
    <img src="logo.png" alt="Logo Kantor Pertanahan" onerror="this.style.display='none'">
    <h1>Login Admin</h1>
    <p>Khusus untuk petugas Kantor Pertanahan</p>
  </div>

  <div class="error-box" id="errorBox">Email atau kata sandi salah, atau akun Anda tidak memiliki akses admin.</div>

  <form method="POST" action="{{ route('admin.login.attempt') }}" id="formLogin">
    @csrf
    <div class="field">
      <label for="email">Email Admin</label>
      <input type="email" id="email" name="email" placeholder="admin@kantorpertanahan.go.id" required autofocus>
    </div>

    <div class="field">
      <label for="password">Kata Sandi</label>
      <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
    </div>

    <div class="field-row">
      <label><input type="checkbox" name="remember"> Ingat saya</label>
    </div>

    <button type="submit" class="btn-login">Masuk</button>
  </form>

  <div class="login-footer">
    <a href="/">← Kembali ke situs publik</a>
  </div>
</div>

</body>
</html>