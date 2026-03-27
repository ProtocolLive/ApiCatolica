<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/ApiCatolica
//2026.03.27.00

//Ferramenta para visualizar de forma fácil as leituras de cada dia
//Para pular para uma determinada data, use o parâmetro dia na url, no formato internacional, com leading 0
//Exemplo: visualizador.php?dia=2021-09-07

define('Pasta', dirname(__DIR__));

$_GET['dia'] ??= date('Y-m-d');
$Ts = strtotime($_GET['dia']);
$AnoLiturgico = new AnoLiturgico($Ts);

$index = file_get_contents(Pasta . '/src/index.json');
$index = json_decode($index, true);
$datas = file_get_contents(Pasta . '/src/datas.json');
$datas = json_decode($datas, true);
$especiais = file_get_contents(Pasta . '/src/especiais.json');
$especiais = json_decode($especiais, true);
$santos = file_get_contents(Pasta . '/src/santos.json');
$santos = json_decode($santos, true);

list($tempo, $semana) = $AnoLiturgico->TempoGet($Ts);
$Semanas = [null, 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];

$DiaSemana = date('N', $Ts);
if($DiaSemana === '7'):
  $ano = AnoLetra(date('Y'));
elseif(date('Y') % 2 === 0):
  $ano = 'p';
else:
  $ano = 'i';
endif;
if(isset($datas['all'][$_GET['dia']])):
  $especial = $especiais[$datas['all'][$_GET['dia']]];
endif;

echo '<h2>' . $_GET['dia'] . '<br>';
echo $semana . 'ª semana do(a) ' . Tempo::from($tempo)->name . ' - ' . $Semanas[$DiaSemana];
if(isset($especial['nome'])):
  echo '<br>' . $especial['nome'];
endif;
$SantoDia = date('m-d', $Ts);
if(isset($santos[$SantoDia])):
  echo '<br>' . $santos[$SantoDia]['nome'];
endif;
echo '</h2>';

echo '<p><b>Primeira leitura:</b> ' . ($santos[$SantoDia][1] ?? $index[$tempo][$semana][$DiaSemana][1]) . '</p>';

if(isset($santos[$SantoDia]['r'])
or isset($index[$tempo][$semana][$DiaSemana]['r'])):
  echo '<p><b>Responsório:</b> ' . ($santos[$SantoDia]['r'] ?? $index[$tempo][$semana][$DiaSemana]['r']);
  if(isset($santos[$SantoDia]['rt'])
  or isset($index[$tempo][$semana][$DiaSemana]['rt'])):
    echo '<br>';
    $temp = file_get_contents(Pasta . '/src/responsorios/' . ($santos[$SantoDia]['rt'] ?? $index[$tempo][$semana][$DiaSemana]['rt']) . '.json');
    $temp = json_decode($temp, true);
    foreach($temp as $id => $texto):
      if($id === 0):
        echo '<b>' . $texto . '</b><br>';
        continue;
      endif;
      echo '- ' . $texto . '<br>';
    endforeach;
  endif;
  echo '</p>';
endif;

if(isset($index[$tempo][$semana][$DiaSemana][2])):
  echo '<p><b>Segunda leitura:</b> ' . ($santos[$SantoDia][2] ?? $index[$tempo][$semana][$DiaSemana][2]) . '</p>';
endif;

echo '<p><b>Evangelho:</b> ' . ($santos[$SantoDia]['e'] ?? $index[$tempo][$semana][$DiaSemana]['e']) . '</p>';