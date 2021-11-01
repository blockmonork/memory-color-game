<?php
define('GAME_DEBUG', FALSE);
if ( GAME_DEBUG ){
   sleep(2);
}
if ( isset($_GET['fase']) ){
   $fase = trim($_GET['fase']);
}else{
      $fase = 1;
}
$REPETE = 2;
if ( $fase == 1 ){
   $TOTAL_ITENS = 20;
   $cores = array('green', 'blue', 'yellow', 'navy', 'olive', 'brown', 'gray', 'purple', 'lime', 'teal');
}else{
      $TOTAL_ITENS = 40;
      $cores = array(
          'green', 'blue', 'yellow', 'navy', 'olive', 'brown', 'gray', 'purple', 'lime', 'teal',
          'fuchsia', 'aqua', 'indianred', 'lightcyan', 'burlywood', 'chocolate', 'coral', 'cornsilk', 'darkorange', 'goldenrod'
          );
}
$itens = array();

/*if ( GAME_DEBUG ){
   var_dump($TOTAL_ITENS);
   var_dump($REPETE);
   var_dump($cores);
   var_dump($fase);
   exit;
}*/

function cor_repetida($cor, $item)
{
         global $REPETE;
         if ( in_array($cor, $item) ){
            $vezes = 0;
            for ( $i = 0; $i < count($item); $i++ ){
                if ( $item[$i] == $cor ){ $vezes++; }
            }
            return ( $vezes < $REPETE ) ? false : true;
         }else{
               return false;
         }
}
for ( $item = 0; $item < $TOTAL_ITENS; $item++ ){
    $cor = $cores[rand(0,(count($cores)-1))];
    if ( !cor_repetida($cor, $itens) ){
       $itens[$item] = $cor;
    }else{
          $item--;
    }
}
$html = '';
for ( $i = 0; $i < count($itens); $i++ ){
    $t = $i+1;
    $txt = ( $t < 10 ) ? '0'.$t : $t;
    if ( GAME_DEBUG ){
       $background = ' style="background:'.$itens[$i].';" ';
       $onclick = ' game_debug('.$t.'); ';
    }else{
          $background = '';
          $onclick = ' v_click('.$t.'); ';
    }
    $html .= '<div class="item" id="'.$t.'" onclick="'. $onclick .'" '. $background .' data="'.$itens[$i].'"><span>'.$txt.'</span></div>';
}
echo utf8_encode($html);
exit;
?>
