<?php

/*
 * Autor: Herrison Trugilho
 * Data 01/05/20022
 */

if (!isset($_POST['validar'])) {
    $text = "Sem acesso";
    header("Location: ../../../index.php?text=$text&type=1");
    exit();
}

include "../../config/connMysql.php";
include "../../config/config.php";

$sqlDeletaLogo = "delete from logo";

if (empty($_FILES['logo']['name'])) {
    if (mysqli_query($con, $sqlDeletaLogo)) {
        $text = "Logo alerada com sucesso.";
        $type = 0;
        unlink("../arquivos/logo/logo.png");
        header("Location: ../index.php?text=$text&type=$type");
        exit; // Para a execução do script 
    }
}
// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '../arquivos/logo/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
// Array com as extensões permitidas
$_UP['extensoes'] = array('png');

// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['logo']['error'] != 0) {
    $text = "Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']];
    $type = 1;
    header("Location: ../index.php?text=$text&type=$type");
    exit; // Para a execução do script
}

// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
// Faz a verificação da extensão do arquivo
$temp = explode('.', $_FILES['logo']['name']);
$extensao = strtolower(end($temp));
if (array_search($extensao, $_UP['extensoes']) === false) {
    $text = "Por favor, envie arquivos com a seguinte extensão: png";
    $type = 1;
}
// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['logo']['size']) {
    $type = 1;
    $text = "O arquivo enviado é muito grande, envie arquivos de até 64Mb.";
}

// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
// Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .png
        $nome_final = 'logo.png';
    } else {
// Mantém o nome original do arquivo
        $nome_final = $_FILES['logo']['name'];
    }

    //Verifica de o arquivo foi deletado corretamente no banco de dados.
    if (mysqli_query($con, $sqlDeletaLogo)) {
        $sqlInsertLogo = "insert into logo values (null,
                                                   '$nome_final',
                                                   '$nome_final')";
        // Tenta inserir a logo no banco de dados
        if (mysqli_query($con, $sqlInsertLogo)) {
            //Depois verifica se é possível mover o arquivo para a pasta escolhida
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $_UP['pasta'] . $nome_final)) {

                //GERA LOG
                $idFuncionario = $_SESSION['idlogin'];
                $funcionario = $_SESSION['login'];
                $date = date("Y-m-d"); //FORMATO AMERICANO 
                $data = date("d/m/Y");
                $hora = date("H:i:s");
                $descricaoLog = "Funcionário: <b>$funcionario</b>, cadastrou uma nova logo, no dia <b>$data</b> às <b>$hora</b>";
                $sqlLog = "INSERT INTO log VALUES (null,
                                                {$idFuncionario},
                                                'cadastro',
                                                '{$descricaoLog}',
                                                'logo',
                                                {$idcategoria},
                                                null,    
                                                '$date',
                                                '$hora')";
                if (mysqli_query($con, $sqlLog)) {
                    
                }

                //Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
                $text = "Logo alterada com sucesso.";
                $type = 0;
            } else {
                //Não foi possível fazer o upload, provavelmente a pasta está incorreta
                $text = "Não foi possível enviar o arquivo, tente novamente.";
                $type = 1;
            }
        } else {
            $text = "Erro ao cadastrar nova logo.";
            $type = 1;
        }
    } else {
        $text = "Erro ao cadastrar nova logo.";
        $type = 1;
    }
}

mysqli_close($con);
header("Location: ../index.php?text=$text&type=$type");
