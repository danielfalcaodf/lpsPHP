<?php

require_once "TonyLPClass.php";

$tonylp = new TonyLPClass();



// $carros = $tonylp->convert('listcarros.csv', ',');
$carrosVender = array();

// $carrosVender = $tonylp->verificarVendido($carros);

$ofertas = array();
// modelo de lista de carros fora do csv

$ofertas[] = array(
   'img' => 'img/kwid.jpg',
   'marca' => 'RENAULT',
   'modelo' => 'Kwid',
   'ano' => '2019',
   'calcao_' => 'R$ 2.900,00',
   'prazo_' => '60',
   'mensal_' => 'R$ 892,00',
   'token' => '1fcd7e4214624a399c8a6d6c21d7652d',
   'iD_Veiculo' => '19610'

);


$ofertas[] = array(
   'img' => 'img/mobi.jpeg',
   'marca' => 'FIAT',
   'modelo' => 'Mobi - 4 Portas',
   'ano' => '2018',
   'calcao_' => 'R$ 3.900,00',
   'prazo_' => '60',
   'mensal_' => 'R$ 699,00',
   'token' => '1fcd7e4214624a399c8a6d6c21d7652d',
   'iD_Veiculo' => '19251'

);
$ofertas[] = array(
   'img' => 'img/onix.jpg',
   'marca' => 'GM - CHEVROLET',
   'modelo' => 'Onix 1.0 COMPLETO',
   'ano' => '2019',
   'calcao_' => 'R$ 3.900,00',
   'prazo_' => '60',
   'mensal_' => 'R$ 989,00',
   'token' => '1fcd7e4214624a399c8a6d6c21d7652d',
   'iD_Veiculo' => '18727'

);

$ofertas[] = array(
   'img' => 'img/gol.jpg',
   'marca' => 'VOLKSWAGEN',
   'modelo' => 'Gol - 1.6 COMPLETO',
   'ano' => '2019',
   'calcao_' => 'R$ 3.900,00',
   'prazo_' => '60',
   'mensal_' => 'R$ 1.090,00',
   'token' => '1fcd7e4214624a399c8a6d6c21d7652d',
   'iD_Veiculo' => '19089'


);

if(count($ofertas) > 0 and count($carrosVender) <= 0)
{
   array_multisort($tonylp->ordemArray($ofertas, 'mensal_'), SORT_NUMERIC, $ofertas);
}
else if(count($carrosVender) > 0 and  count($ofertas) <= 0)
{
   array_multisort($tonylp->ordemArray($carrosVender, 'mensal_'), SORT_NUMERIC, $carrosVender);
   
}
else 
{
   array_multisort($tonylp->ordemArray($ofertas, 'mensal_'), SORT_NUMERIC, $ofertas);
   array_multisort($tonylp->ordemArray($carrosVender, 'mensal_'), SORT_NUMERIC, $carrosVender);
   
}

?>


<!-- oferta especial para 3 tipo de entrada -->

<!-- <?php /* $tokenOferta = '524c2740ae2abb4f2f6e919a72796dc53b2d83ae'; */?>
<div class="row card-container ">
   <div class="col-md-12 card_fundo text-center">
      <h1>OFERTA ESPECIAL</h1>
      <div class="col-md-12 card_carros">
         <div class="row ">
            <div class="col-md-4 align-self-center">
               <img class="img-fluid img-carro" aling="middle" src="img/fordka.jpeg" alt="" srcset="">
            </div>
            <div class="col-md-8 azul" style="padding: 20px;text-align:left">
               <div class="card-texto23">FORD
               </div>
               <div class="card-texto40 azul" style="margin-bottom:5px;vertical-align: middle;display: inline-block;">
                  KA HATCH 1.0 COMPLETO
               </div>
               <div class="card-texto12 azul">
                  <div style="font-size:18px">2018</div>
               </div>
               <hr class="d-md-block d-none">
               <div class="row">

                  <div class="col-md-4">

                     <hr class="d-md-none d-block">
                     <div class="card-texto12 laranja " style="margin-top:5px;">
                        Entrada de </br> R$ 7900,00 </br> </div>
                     <div class="card-texto12 laranja " style="margin-top:5px;">
                        48 Parcelas de:
                     </div>
                     <div class="card-texto12  font-black  laranja" style="margin-bottom:5px;">
                        R$ 1284,00</div>
                     <button onclick="show_cad('1K','<?= $tokenOferta ?>','7900.00','48','1284.00','19473')" type="button" class="btn btn-primary botao-padrao btn-sm"><b>APROVAR
                           CRÉDITO</b></button>
                  </div>
                  <div class="col-md-4">
                     <hr class="d-md-none d-block">
                     <div class="card-texto12 laranja " style="margin-top:5px;">
                        Entrada de<br> R$ 9900,00<br> </div>
                     <div class="card-texto12 laranja" style="margin-top:5px;">
                        48 Parcelas de:
                     </div>
                     <div class="card-texto12  font-black  laranja" style="margin-bottom:5px;">
                        R$ 1174,00</div> <button onclick="show_cad('2KA', '<?= $tokenOferta ?>','9900.00','48','1174.00','19473')" type="button" class="btn btn-primary botao-padrao btn-sm"><b>APROVAR
                           CRÉDITO</b></button>
                  </div>
                  <div class="col-md-4">
                     <hr class="d-md-none d-block">
                     <div class="card-texto12 laranja " style="margin-top:5px;">
                        Entrada de<br>R$ 12900,00<br> </div>
                     <div class="card-texto12 laranja  " style="margin-top:5px;">
                        48 Parcelas de:
                     </div>
                     <div class="card-texto12  font-black   laranja" style="margin-bottom:5px;">
                        R$ 899,00</div> <button onclick="show_cad('3KA',' <?= $tokenOferta ?> ','12900.00','48','899.00','19473')" type="button" class="btn btn-primary botao-padrao btn-sm"><b>APROVAR
                           CRÉDITO</b></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="card-container-cad col-12 mx-0" style="display:none" id="cad1KA" name="cad"></div>
   <div class="card-container-cad col-12 mx-0" style="display:none" id="cad2KA" name="cad"></div>
   <div class="card-container-cad col-12 mx-0" style="display:none" id="cad3KA" name="cad"></div>
</div> -->

<!-- Ofertas Novas sem csv, usar array la encima  -->

<?php
   $i = 0;
   while($i < count($ofertas) AND count($ofertas) > 0) {
   $token = $ofertas[$i]['token'];
   $idVei = $ofertas[$i]['iD_Veiculo'];
   $entrada = $tonylp->removePontoCifrao($ofertas[$i]['calcao_']);
   $prazo = $tonylp->removePontoCifrao($ofertas[$i]['prazo_']);
   $mensal = $tonylp->removePontoCifrao($ofertas[$i]['mensal_']);   ?>
<div class='row card-container'>

    <!-- para colocar a borda vermelho no card do carro -->

    <!-- <div class="col-md-12 card_fundo text-center">
        <h1>OFERTA ESPECIAL</h1> -->

    <div class="col-md-12 card_carros">
        <div class="row ">

            <div class="col-md-4 align-self-center">
                <img src="<?= $ofertas[$i]['img'] ?> " class='img-fluid img-carro' aling='middle'>
            </div>

            <div class="col-md-8 azul" style="padding: 20px;text-align:left">
                <div class='card-texto23'>
                    <?= $ofertas[$i]['marca'] ?>
                </div>
                <div class='card-texto40 azul' style='margin-bottom:5px;vertical-align: middle;display: inline-block;'>
                    <?= $ofertas[$i]['modelo'] ?>
                </div>

                <div class='card-texto12 azul'>
                    <div style='font-size:18px'>
                        <?= $ofertas[$i]['ano'] ?>
                    </div>
                </div>

                <hr>

                <div class='card-texto20 laranja font-weight-bold' style='margin-top:5px;'>
                    <b>Entrada de <?= $ofertas[$i]['calcao_'] ?></b> <br>
                </div>
                <div class='card-texto20 laranja font-weight-bold' style='margin-top:5px;'>
                    <b><?= $ofertas[$i]['prazo_'] ?> Parcelas de: </b>
                </div>
                <div class='card-texto46 laranja' style='margin-bottom:5px;'>
                    <?= $ofertas[$i]['mensal_'] ?>
                </div>
                <button
                    onclick="show_cad('<?= ($i . 'Oferta') ?>','<?= $token ?>','<?= $entrada ?>','<?= $prazo ?>','<?= $mensal ?>','<?= $idVei ?>')"
                    type="button" class="btn btn-primary botao-padrao">
                    <b>APROVAR CRÉDITO</b>
                </button>
            </div>
        </div>
    </div>
    <!-- </div> -->
    <div class='card-container-cad col-12 mx-0' style='display:none' id="cad<?= ($i . 'Oferta') ?>" name='cad'></div>
</div>
<?php $i++; }  ?>

<!-- carros do csv -->
<?php
$i = 0;
while ($i < count($carrosVender) AND count($carrosVender) > 0) {
   $token = "524c2740ae2abb4f2f6e919a72796dc53b2d83ae";
   $idVei = $carrosVender[$i]['iD_Veiculo'];
   $entrada = $tonylp->removePontoCifrao($carrosVender[$i]['calcao_']);
   $prazo = $tonylp->removePontoCifrao($carrosVender[$i]['prazo_']);
   $mensal = $tonylp->removePontoCifrao($carrosVender[$i]['mensal_']); ?>
<div class='row card-container '>
    <div class='col-md-12 card_carros'>
        <div class='row '>
            <div class='col-md-4 align-self-center'>
                <img src=" <?= $carrosVender[$i]['foto'] ?> " class='img-fluid img-carro' aling='middle'>
            </div>
            <div class='col-md-8 azul' style='padding: 20px;text-align:left'>
                <div class='card-texto23'>
                    <?= $carrosVender[$i]['marca'] ?>
                </div>
                <div class='card-texto40 azul' style='margin-bottom:5px;vertical-align: middle;display: inline-block;'>
                    <?= $carrosVender[$i]['veiculo_'] ?>
                </div>
                <div class='card-texto12 azul'>
                    <div style='font-size:18px'>
                        <?= $carrosVender[$i]['ano_modelo'] ?>
                    </div>
                    <b>Cor: <?= $carrosVender[$i]['cor_'] ?></b><br>
                </div>

                <hr>

                <div class='card-texto20 laranja font-weight-bold' style='margin-top:5px;'>
                    <b>Entrada de <?= $carrosVender[$i]['calcao_'] ?></b><br>
                </div>
                <div class='card-texto20 laranja font-weight-bold' style='margin-top:5px;'>
                    <b><?= $carrosVender[$i]['prazo_'] ?> Parcelas de: </b>
                </div>
                <div class='card-texto46 laranja' style='margin-bottom:5px;'>
                    <?= $carrosVender[$i]['mensal_'] ?>
                </div>
                <button
                    onclick="show_cad('<?= $i ?>','<?= $token ?>','<?= $entrada ?>','<?= $prazo ?>','<?= $mensal ?>','<?= $idVei ?>')"
                    type="button" class="btn btn-primary botao-padrao">
                    <b>APROVAR CRÉDITO</b>
                </button>
            </div>
        </div>
    </div>
    <div class='card-container-cad col-12 mx-0' style='display:none' id='cad$i' name='cad'>
    </div>
</div>

<?php $i++;  } ?>

<div class="container">
    <div class="row justify-content-center py-3">
        <div class="col-md-4 col-6">
            <a style="color: white; " href="https://tonyveiculos.com.br/Estoque/">
                <button type="button" class="btn btn-primary botao-padrao">
                    <b> Veja mais ofertas </b>
                </button>
            </a>
        </div>
    </div>
</div>