<?php
//Protocol Corporation Ltda.
//https://github.com/ProtocolLive/ApiCatolica

/**
 * @version 2026.03.27.00
 */
enum Tempo:string{
  case Advento = 'adv';
  case Natal = 'ntl';
  case Epifania = 'epf';
  case Comum = 'tc';
  case Cinzas = 'czs';
  case Quaresma = 'qrm';
  case Ramos = 'rms';
  case Pascoa = 'psc';
  case Pentecostes = 'pnt';
  case Trindade = 'tnd';
}