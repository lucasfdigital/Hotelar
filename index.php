<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="app/assets/bootstrap-5.1.3/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Hotelar</title>
</head>

<body>
    <div class='body py-5'>
        <div class="row container-login shadow-sm">
            <div class="col-md-6 p-4 left">
                <div class='d-flex justify-content-center'>
                    <img style='height:2.5rem;' src="assets/img/Hotelar.png" alt="">
                </div>
                <h2 class='slogan'>Simplificando a sua gestão.</h2>
                <form action="verLogin/verLogin.php" method="POST" class="my-4 py-4 border-top border-bottom">
                    <?php
                    if (isset($_GET['text'])) {
                        if (isset($_GET['type']) and $_GET['type'] == '1') {
                            $text = 'text-danger';
                        } else {
                            $text = 'text-success';
                        }
                        echo "<h5 class='mensagem $text text-center'> " . $_GET['text'] . "</h5>";
                    }
                    ?>
                    <div class="mt-2">
                        <input type="text" name="login" id="login" class="input-login" placeholder="Login">
                        <input type="password" name="senha" id="senha" class="input-login mt-3" placeholder="Senha">
                    </div>

                    <button class='btn btn-secondary w-100 rounded-0 mt-3' name="btn-login">Entrar</button>
                </form>
                <div>
                    <h2 class='slogan'>Desenvolvidor por<br>
                    <span style="color: #3a97f7;">Lucas Fernandes</span>
                    </h2>
                </div>

            </div>
            <div class="col-md-6 p-4 right">
                <div class='h-100'>
                    <h1 class="text-inn">Versão 0.1.5</h1>
                    <p>Com o Hotelar, você centraliza as operações, automatiza tarefas e toma decisões mais inteligentes. Controle reservas, check-ins, finanças e muito mais em um só lugar.</p>
                </div>
            </div>
        </div>
    </div>
</body>
<!--bootstrap-->
<script src="app/assets/bootstrap-5.1.3/js/bootstrap.js"></script>
<script src="app/assets/bootstrap-5.1.3/js/bootstrap.bundle.min.js"></script>
<!--jquery-->
<script src="app/assets/js/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/26f2848625.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</html>