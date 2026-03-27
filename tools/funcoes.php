<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/ApiCatolica
//2026.03.26.00

require_once(__DIR__ . '/Tempo.php');

/**
 * @param int $Ano Timestamp
 * @param string $Tempo A identificação do tempo litúrgico, usando as constantes da classe AnoLiturgico
 */
function AnoLetra(
  int $Ano,
  Tempo|null $Tempo = null
):string|null{
  if($Tempo === Tempo::Advento):
    $Ano = strtotime('+1 year', $Ano);
  endif;
  $temp = date('Y', $Ano) % 3;
  if($temp === 0):
    return 'c';
  elseif($temp === 1):
    return 'a';
  elseif($temp === 2):
    return 'b';
  else:
    return null;
  endif;
}