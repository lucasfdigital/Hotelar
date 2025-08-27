<?php
if (isset($_POST['start'])) {
    include "../../config/connMysql.php";
    include "../../config/config.php";
    include "../../include/func.php";
    
    $idacomodacao = $_POST['id'];
    $start = dataAmerica($_POST['start']);
    $end = dataAmerica($_POST['end']);

    $sqlReservas = "SELECT r.idreserva,
                            c.nome,
                            r.quantidadehospedes,
                            r.entradaprevista,
                            r.saidaprevista,
                            r.status
                     FROM reserva r 
                     INNER JOIN cliente c ON (r.idcliente = c.idcliente)
                     WHERE idacomodacao = {$idacomodacao}
                     AND (entradaprevista >= date('{$start}') and saidaprevista <= date('{$end}')
                     OR saidaprevista >= date('{$start}') and entradaprevista <= date('{$end}'))";
    $resultReservas = mysqli_query($con, $sqlReservas);
    while ($rowReservas = mysqli_fetch_array($resultReservas)) {
        ?>
        <tr> 
            <td> <?= $rowReservas[0] ?> </td>
            <td> <?= $rowReservas[1] ?> </td>
            <td> <?= dataBrasil($rowReservas[3]) ?> </td>
            <td> <?= dataBrasil($rowReservas[4]) ?> </td>
            <td class="text-center"> <?= statusReserva($rowReservas[5], 1) ?> </td>
            <td class="text-center" title="visualizar"> <a href="../reserva/visualizarReserva.php?id=<?= $rowReservas[0] ?>" class="badge-card badge bg-blue1 text-dark"> <i class="fa-solid fa-eye"></i> </a> </td>
        </tr>
        <?php
    }
} else {
    $text = "Sem acesso";
    header("Location: ../../../index.php?text=$text&type=1");
}    