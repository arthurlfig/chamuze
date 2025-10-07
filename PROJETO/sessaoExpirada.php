

<?
if(isset($_SESSION['login']) && $_SESSION){

}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><strong>Sessão Expirada - ChamauZé</strong></title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4 bg-white p-4 rounded shadow">

        <h1 class="text-warning mb-3">
          <i class="bi bi-clock-history me-2"></i> <!-- Ícone de relógio com espaço à direita -->
          <strong>Sessão Expirada</strong>
        
        </h1>

        <p class="mb-4 fs-5"><strong>Sua sessão expirou por inatividade. Por favor, faça login novamente para continuar.</strong></p>

        <a href="login.php" class="btn btn-warning btn-lg text-dark fw-bold">Ir para Login</a>

      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
