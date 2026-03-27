<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/ApiCatolica

/**
 * @version 2026.03.27.00
 */
final class AnoLiturgico{
  private array $Cache = [];

  private function CalculaAno(int $Timestamp){
    $Cache = [];
    //Cria o timestamp do natal do ano anterior
    $Cache[Tempo::Natal->value][25] = mktime(0, 0, 0, 12, 25, date('Y', $Timestamp) - 1);
    //Subtrai 3 semanas e pega o dia da semana
    $Cache[Tempo::Advento->value][1] = strtotime('-3 weeks', $Cache[Tempo::Natal->value][25]);
    $DiaSemana = date('N', $Cache[Tempo::Advento->value][1]);
    //Se não for domingo, acha o domingo anterior
    if($DiaSemana < 7):
      $Cache[Tempo::Advento->value][1] = strtotime('-' . $DiaSemana . ' day', $Cache[Tempo::Advento->value][1]);
    endif;
    $Cache[Tempo::Advento->value][2] = strtotime('+1 week', $Cache[Tempo::Advento->value][1]);
    $Cache[Tempo::Advento->value][3] = strtotime('+1 week', $Cache[Tempo::Advento->value][2]);
    $Cache[Tempo::Advento->value][4] = strtotime('+1 week', $Cache[Tempo::Advento->value][3]);

    $DiaSemana = date('N', $Cache[Tempo::Natal->value][25]);
    $Cache[Tempo::Natal->value]['sgf'] = strtotime('+' . (7 - $DiaSemana) . 'days', $Cache[Tempo::Natal->value][25]);
    $Cache[Tempo::Natal->value][2] = strtotime('+1 week', $Cache[Tempo::Natal->value]['sgf']);

    $Cache[Tempo::Epifania->value] = strtotime('+12 day', $Cache[Tempo::Natal->value][25]);
    $DiaSemana = date('N', $Cache[Tempo::Epifania->value]);
    $Cache[Tempo::Comum->value][1] = strtotime('+' . (7 - $DiaSemana) . ' day', $Cache[Tempo::Epifania->value]);
    $Cache[Tempo::Comum->value][2] = strtotime('+1 week', $Cache[Tempo::Comum->value][1]);
    $Cache[Tempo::Comum->value][3] = strtotime('+1 week', $Cache[Tempo::Comum->value][2]);
    $Cache[Tempo::Comum->value][4] = strtotime('+1 week', $Cache[Tempo::Comum->value][3]);
    $Cache[Tempo::Comum->value][5] = strtotime('+1 week', $Cache[Tempo::Comum->value][4]);
    $Cache[Tempo::Comum->value][6] = strtotime('+1 week', $Cache[Tempo::Comum->value][5]);

    $Cache[Tempo::Pascoa->value][1] = easter_date(date('Y', $Timestamp));
    $Cache[Tempo::Cinzas->value] = strtotime('-46 day', $Cache[Tempo::Pascoa->value][1]);
    $Cache[Tempo::Pascoa->value][2] = strtotime('+1 week', $Cache[Tempo::Pascoa->value][1]);
    $Cache[Tempo::Pascoa->value][3] = strtotime('+1 week', $Cache[Tempo::Pascoa->value][2]);
    $Cache[Tempo::Pascoa->value][4] = strtotime('+1 week', $Cache[Tempo::Pascoa->value][3]);
    $Cache[Tempo::Pascoa->value][5] = strtotime('+1 week', $Cache[Tempo::Pascoa->value][4]);
    $Cache[Tempo::Pascoa->value][6] = strtotime('+1 week', $Cache[Tempo::Pascoa->value][5]);
    $Cache[Tempo::Pascoa->value][7] = strtotime('+1 week', $Cache[Tempo::Pascoa->value][6]);

    $temp = strtotime('+1 week', $Cache[Tempo::Comum->value][6]);
    if($temp < $Cache[Tempo::Cinzas->value]):
      $Cache[Tempo::Comum->value][6] = $temp;
    endif;

    $Cache[Tempo::Quaresma->value][1] = strtotime('+4 day', $Cache[Tempo::Cinzas->value]);
    $Cache[Tempo::Quaresma->value][2] = strtotime('+1 week', $Cache[Tempo::Quaresma->value][1]);
    $Cache[Tempo::Quaresma->value][3] = strtotime('+1 week', $Cache[Tempo::Quaresma->value][2]);
    $Cache[Tempo::Quaresma->value][4] = strtotime('+1 week', $Cache[Tempo::Quaresma->value][3]);
    $Cache[Tempo::Quaresma->value][5] = strtotime('+1 week', $Cache[Tempo::Quaresma->value][4]);
    $Cache[Tempo::Ramos->value] = strtotime('+1 week', $Cache[Tempo::Quaresma->value][5]);
    
    $Cache[Tempo::Pentecostes->value] = strtotime('+50 days', $Cache[Tempo::Pascoa->value][1]);
    $DiaSemana = date('N', $Cache[Tempo::Pentecostes->value]);
    if($DiaSemana === '1'):
      $Cache[Tempo::Pentecostes->value] = strtotime('-1 day', $Cache[Tempo::Pentecostes->value]);
    endif;
    $Cache[Tempo::Trindade->value] = strtotime('+1 week', $Cache[Tempo::Pentecostes->value]);

    //Tempo comum
    $ProximoNatal = mktime(0, 0, 0, 12, 25, date('Y', $Timestamp));
    $ProximoAdvento1 = strtotime('-3 weeks', $ProximoNatal);
    $DiaSemana = date('N', $ProximoAdvento1);
    if($DiaSemana < 7):
      $ProximoAdvento1 = strtotime('-' . $DiaSemana . ' day', $ProximoAdvento1);
    endif;
    $Cache[Tempo::Comum->value][34] = strtotime('-1 week', $ProximoAdvento1);
    $Cache[Tempo::Comum->value][33] = strtotime('-1 week', $Cache[Tempo::Comum->value][34]);
    $Cache[Tempo::Comum->value][32] = strtotime('-1 week', $Cache[Tempo::Comum->value][33]);
    $Cache[Tempo::Comum->value][31] = strtotime('-1 week', $Cache[Tempo::Comum->value][32]);
    $Cache[Tempo::Comum->value][30] = strtotime('-1 week', $Cache[Tempo::Comum->value][31]);
    $Cache[Tempo::Comum->value][29] = strtotime('-1 week', $Cache[Tempo::Comum->value][30]);
    $Cache[Tempo::Comum->value][28] = strtotime('-1 week', $Cache[Tempo::Comum->value][29]);
    $Cache[Tempo::Comum->value][27] = strtotime('-1 week', $Cache[Tempo::Comum->value][28]);
    $Cache[Tempo::Comum->value][26] = strtotime('-1 week', $Cache[Tempo::Comum->value][27]);
    $Cache[Tempo::Comum->value][25] = strtotime('-1 week', $Cache[Tempo::Comum->value][26]);
    $Cache[Tempo::Comum->value][24] = strtotime('-1 week', $Cache[Tempo::Comum->value][25]);
    $Cache[Tempo::Comum->value][23] = strtotime('-1 week', $Cache[Tempo::Comum->value][24]);
    $Cache[Tempo::Comum->value][22] = strtotime('-1 week', $Cache[Tempo::Comum->value][23]);
    $Cache[Tempo::Comum->value][21] = strtotime('-1 week', $Cache[Tempo::Comum->value][22]);
    $Cache[Tempo::Comum->value][20] = strtotime('-1 week', $Cache[Tempo::Comum->value][21]);
    $Cache[Tempo::Comum->value][19] = strtotime('-1 week', $Cache[Tempo::Comum->value][20]);
    $Cache[Tempo::Comum->value][18] = strtotime('-1 week', $Cache[Tempo::Comum->value][19]);
    $Cache[Tempo::Comum->value][17] = strtotime('-1 week', $Cache[Tempo::Comum->value][18]);
    $Cache[Tempo::Comum->value][16] = strtotime('-1 week', $Cache[Tempo::Comum->value][17]);
    $Cache[Tempo::Comum->value][15] = strtotime('-1 week', $Cache[Tempo::Comum->value][16]);
    $Cache[Tempo::Comum->value][14] = strtotime('-1 week', $Cache[Tempo::Comum->value][15]);
    $Cache[Tempo::Comum->value][13] = strtotime('-1 week', $Cache[Tempo::Comum->value][14]);
    $Cache[Tempo::Comum->value][12] = strtotime('-1 week', $Cache[Tempo::Comum->value][13]);
    $Cache[Tempo::Comum->value][11] = strtotime('-1 week', $Cache[Tempo::Comum->value][12]);
    $temp = strtotime('-1 week', $Cache[Tempo::Comum->value][11]);
    if($temp > $Cache[Tempo::Trindade->value]):
      $Cache[Tempo::Comum->value][10] = $temp;
      $temp = strtotime('-1 week', $Cache[Tempo::Comum->value][10]);
      if($temp > $Cache[Tempo::Trindade->value]):
        $Cache[Tempo::Comum->value][9] = $temp;
      endif;
    endif;
    ksort($Cache);
    $this->Cache['Tempos'] = $Cache;
  }

  private function CalculaDatas():void{
    foreach($this->Cache['Tempos'] as $tempo => $semanas):
      if(is_array($semanas)):
        foreach($semanas as $semana => $data):
          $this->Cache['Datas'][date('Y-m-d', $data)] = [$tempo, $semana];
        endforeach;
      else:
        $this->Cache['Datas'][date('Y-m-d', $semanas)] = $tempo;
      endif;
    endforeach;
    ksort($this->Cache['Datas']);
  }

  public function __construct(
    int|null $Timestamp = null
  ){
    if($Timestamp === null):
      $Timestamp = time();
    endif;
    $this->CalculaAno($Timestamp);
    $this->CalculaDatas();
  }

  public function DatasGet(){
    return $this->Cache['Datas'];
  }

  public function TemposGet(){
    return $this->Cache['Tempos'];
  }

  public function TempoGet(
    int $Timestamp
  ):int|array{
    $DiaSemana = date('N', $Timestamp);
    if($DiaSemana < 7):
      $Timestamp = strtotime('-' . $DiaSemana . ' day', $Timestamp);
    endif;
    $datas = $this->DatasGet();
    return $datas[date('Y-m-d', $Timestamp)];
  }
}