<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ChamauZé</title>
    <link rel="shortcut icon" href="assets/img/chamuzeFavicon.ico" type="image/x-icon">
        <style>
        .card-hover:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .card-img-top {
            max-height: 300px;
            object-fit: contain;
            padding: 10px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column" style="height: 100vh;">
    <div class="container-fluid d-flex justify-content-center align-items-center flex-grow-1">
            <div class="container d-flex justify-content-center align-items-center mb-4 mb-md-0">
                <div class="row g-4">
                    <div class="col-sm">
                        <a href="cadastro.php?tipo_perfil=solicitante" class="text-decoration-none">
                            <div class="card h-100 shadow card-hover">
                                <div class="card-body text-center">
                                    <h3 class="card-title text-dark">Solicitante</h3>
                                    <img src="assets/img/solicitante.png" class="card-img-top" alt="Solicitante">
                                    <p class="text-muted">Quero contratar serviços</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm">
                        <a href="cadastro.php?tipo_perfil=prestador" class="text-decoration-none">
                            <div class="card h-100 shadow card-hover">
                                <div class="card-body text-center">
                                    <h3 class="card-title text-dark">Prestador</h3>
                                    <img src="assets/img/prestador.png" class="card-img-top" alt="Prestador">
                                    <p class="text-muted">Quero prestar serviços</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php include "footer.php";?>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>