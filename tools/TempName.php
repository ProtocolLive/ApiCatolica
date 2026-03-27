<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/ApiCatolica

/**
 * @version 2026.03.27.00
 */
final class AnoLiturgico{
  private array $Cache = [];

  public const Datas = 0;

  private function CalculaAno(int $Timestamp){
    //Cria o timestamp do natal do ano anterior
    $this->Cache[Tempo::Natal->value][25] = mktime(0, 0, 0, 12, 25, date('Y', $Timestamp) - 1);
    //Subtrai 3 semanas e pega o dia da semana
    $this->Cache[Tempo::Advento->value][1] = strtotime('-3 weeks', $this->Cache[Tempo::Natal->value][25]);
    $DiaSemana = date('N', $this->Cache[Tempo::Advento->value][1]);
    //Se não for domingo, acha o domingo anterior
    if($DiaSemana < 7):
      $this->Cache[Tempo::Advento->value][1] = strtotime('-' . $DiaSemana . ' day', $this->Cache[Tempo::Advento->value][1]);
    endif;
    $this->Cache[Tempo::Advento->value][2] = strtotime('+1 week', $this->Cache[Tempo::Advento->value][1]);
    $this->Cache[Tempo::Advento->value][3] = strtotime('+1 week', $this->Cache[Tempo::Advento->value][2]);
    $this->Cache[Tempo::Advento->value][4] = strtotime('+1 week', $this->Cache[Tempo::Advento->value][3]);

    $DiaSemana = date('N', $this->Cache[Tempo::Natal->value][25]);
    $this->Cache[Tempo::Natal->value]['sgf'] = strtotime('+' . (7 - $DiaSemana) . 'days', $this->Cache[Tempo::Natal->value][25]);
    $this->Cache[Tempo::Natal->value][2] = strtotime('+1 week', $this->Cache[Tempo::Natal->value]['sgf']);

    $this->Cache[Tempo::Epifania->value] = strtotime('+12 day', $this->Cache[Tempo::Natal->value][25]);
    $DiaSemana = date('N', $this->Cache[Tempo::Epifania->value]);
    $this->Cache[Tempo::Comum->value][1] = strtotime('+' . (7 - $DiaSemana) . ' day', $this->Cache[Tempo::Epifania->value]);
    $this->Cache[Tempo::Comum->value][2] = strtotime('+1 week', $this->Cache[Tempo::Comum->value][1]);
    $this->Cache[Tempo::Comum->value][3] = strtotime('+1 week', $this->Cache[Tempo::Comum->value][2]);
    $this->Cache[Tempo::Comum->value][4] = strtotime('+1 week', $this->Cache[Tempo::Comum->value][3]);
    $this->Cache[Tempo::Comum->value][5] = strtotime('+1 week', $this->Cache[Tempo::Comum->value][4]);
    $this->Cache[Tempo::Comum->value][6] = strtotime('+1 week', $this->Cache[Tempo::Comum->value][5]);

    $this->Cache[Tempo::Pascoa->value][1] = easter_date(date('Y', $Timestamp));
    $this->Cache[Tempo::Cinzas->value] = strtotime('-46 day', $this->Cache[Tempo::Pascoa->value][1]);
    $this->Cache[Tempo::Pascoa->value][2] = strtotime('+1 week', $this->Cache[Tempo::Pascoa->value][1]);
    $this->Cache[Tempo::Pascoa->value][3] = strtotime('+1 week', $this->Cache[Tempo::Pascoa->value][2]);
    $this->Cache[Tempo::Pascoa->value][4] = strtotime('+1 week', $this->Cache[Tempo::Pascoa->value][3]);
    $this->Cache[Tempo::Pascoa->value][5] = strtotime('+1 week', $this->Cache[Tempo::Pascoa->value][4]);
    $this->Cache[Tempo::Pascoa->value][6] = strtotime('+1 week', $this->Cache[Tempo::Pascoa->value][5]);
    $this->Cache[Tempo::Pascoa->value][7] = strtotime('+1 week', $this->Cache[Tempo::Pascoa->value][6]);

    $temp = strtotime('+1 week', $this->Cache[Tempo::Comum->value][6]);
    if($temp < $this->Cache[Tempo::Cinzas->value]):
      $this->Cache[Tempo::Comum->value][6] = $temp;
    endif;

    $this->Cache[Tempo::Quaresma->value][1] = strtotime('+4 day', $this->Cache[Tempo::Cinzas->value]);
    $this->Cache[Tempo::Quaresma->value][2] = strtotime('+1 week', $this->Cache[Tempo::Quaresma->value][1]);
    $this->Cache[Tempo::Quaresma->value][3] = strtotime('+1 week', $this->Cache[Tempo::Quaresma->value][2]);
    $this->Cache[Tempo::Quaresma->value][4] = strtotime('+1 week', $this->Cache[Tempo::Quaresma->value][3]);
    $this->Cache[Tempo::Quaresma->value][5] = strtotime('+1 week', $this->Cache[Tempo::Quaresma->value][4]);
    $this->Cache[Tempo::Ramos->value] = strtotime('+1 week', $this->Cache[Tempo::Quaresma->value][5]);
    
    $this->Cache[Tempo::Pentecostes->value] = strtotime('+50 days', $this->Cache[Tempo::Pascoa->value][1]);
    $DiaSemana = date('N', $this->Cache[Tempo::Pentecostes->value]);
    if($DiaSemana === '1'):
      $this->Cache[Tempo::Pentecostes->value] = strtotime('-1 day', $this->Cache[Tempo::Pentecostes->value]);
    endif;
    $this->Cache[Tempo::Trindade->value] = strtotime('+1 week', $this->Cache[Tempo::Pentecostes->value]);

    //Tempo comum
    $ProximoNatal = mktime(0, 0, 0, 12, 25, date('Y', $Timestamp));
    $ProximoAdvento1 = strtotime('-3 weeks', $ProximoNatal);
    $DiaSemana = date('N', $ProximoAdvento1);
    if($DiaSemana < 7):
      $ProximoAdvento1 = strtotime('-' . $DiaSemana . ' day', $ProximoAdvento1);
    endif;
    $this->Cache[Tempo::Comum->value][34] = strtotime('-1 week', $ProximoAdvento1);
    $this->Cache[Tempo::Comum->value][33] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][34]);
    $this->Cache[Tempo::Comum->value][32] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][33]);
    $this->Cache[Tempo::Comum->value][31] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][32]);
    $this->Cache[Tempo::Comum->value][30] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][31]);
    $this->Cache[Tempo::Comum->value][29] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][30]);
    $this->Cache[Tempo::Comum->value][28] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][29]);
    $this->Cache[Tempo::Comum->value][27] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][28]);
    $this->Cache[Tempo::Comum->value][26] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][27]);
    $this->Cache[Tempo::Comum->value][25] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][26]);
    $this->Cache[Tempo::Comum->value][24] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][25]);
    $this->Cache[Tempo::Comum->value][23] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][24]);
    $this->Cache[Tempo::Comum->value][22] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][23]);
    $this->Cache[Tempo::Comum->value][21] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][22]);
    $this->Cache[Tempo::Comum->value][20] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][21]);
    $this->Cache[Tempo::Comum->value][19] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][20]);
    $this->Cache[Tempo::Comum->value][18] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][19]);
    $this->Cache[Tempo::Comum->value][17] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][18]);
    $this->Cache[Tempo::Comum->value][16] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][17]);
    $this->Cache[Tempo::Comum->value][15] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][16]);
    $this->Cache[Tempo::Comum->value][14] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][15]);
    $this->Cache[Tempo::Comum->value][13] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][14]);
    $this->Cache[Tempo::Comum->value][12] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][13]);
    $this->Cache[Tempo::Comum->value][11] = strtotime('-1 week', $this->Cache[Tempo::Comum->value][12]);
    $temp = strtotime('-1 week', $this->Cache[Tempo::Comum->value][11]);
    if($temp > $this->Cache[Tempo::Trindade->value]):
      $this->Cache[Tempo::Comum->value][10] = $temp;
      $temp = strtotime('-1 week', $this->Cache[Tempo::Comum->value][10]);
      if($temp > $this->Cache[Tempo::Trindade->value]):
        $this->Cache[Tempo::Comum->value][9] = $temp;
      endif;
    endif;

    ksort($this->Cache);
  }

  private function CalculaDatas():void{
    foreach($this->Cache as $tempo => $semanas):
      if(is_array($semanas)):
        foreach($semanas as $semana => $data):
          $this->Cache[self::Datas][date('Y-m-d', $data)] = [$tempo, $semana];
        endforeach;
      else:
        $this->Cache[self::Datas][date('Y-m-d', $semanas)] = $tempo;
      endif;
    endforeach;
    ksort($this->Cache);
  }

  public function __construct(
    int|null $Timestamp = null
  ){
    if($Timestamp === null):
      $Timestamp = time();
    endif;
    $this->CalculaAno($Timestamp);
    $this->CalculaDatas($Timestamp);
  }

  public function DatasGet(){
    return $this->Cache[self::Datas];
  }

  public function TemposGet(){
    $temp = $this->Cache;
    unset($temp[self::Datas]);
    return $temp;
  }

  /**
   * @return int|array
   */
  public function TempoGet(int $Timestamp){
    $DiaSemana = date('N', $Timestamp);
    if($DiaSemana < 7):
      $Timestamp = strtotime('-' . $DiaSemana . ' day', $Timestamp);
    endif;
    $datas = $this->DatasGet();
    return $datas[date('Y-m-d', $Timestamp)];
  }
}