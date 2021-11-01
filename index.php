<?php
function Site_debug(){ return ( strstr(basename($_SERVER['HTTP_HOST']), 'localhost') ) ? true : false; }
$root_dir = '../../z_js_loader_fafm/';
if ( isset($_GET['fase']) ){
   $t = trim($_GET['fase']);
   $fase = ( $t != '' && ctype_digit($t) ) ? $t : 1;
}else{
      $fase = 1;
}
$rights = ( $fase * 10);
$bt_normal = $bt_hard = '';
if ( $fase == 1 ){
   $bt_normal = '<span class="active">normal</span> ';
   $bt_hard = '<a href="?fase=2">hard</a>';
}else{
      $bt_hard = '<span class="active">hard</span> ';
      $bt_normal = '<a href="?fase=1">normal</a>';
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>BomBrain: Memory Color Game</title>
</head>
<body>
<div id="site">
     <div class="box rounded5 pad5 b_silver bg_white text_center shadow" id="conteudo">
          <h1>Memory Color Game</h1>
          <div id="game_menu">
               <span id="estatisticas">
                     Clicks:<span id="totalClicks">0</span> | Rights:<span id="Pontos">0</span>
               </span>
               <span>Mode:</span>
               <?php echo $bt_normal; ?>
               <?php echo $bt_hard; ?>
               <a id="ResetGame" href="#">New</a>
          </div>
          <div id="best_score"></div>
          <div id="Loader"><div class="ajax_loader_img_container img_clock" id="loadingGame"><span>loading...</span></div></div>
          <div id="memory_game" class="fase<?php echo $fase;?>"></div>
     </div>
     <div class="contador">www.BomBrain.com.br &copy; <?php echo $x; ?></div>
</div>
<script>
<?php
     // variaveis do jogo:
     echo '
     var _fase_ = '.$fase.';
     var _rights_ = '.$rights.';
     ';
?>
</script>
<script src="<?php echo $root_dir;?>loader.js"></script>
<script>_fLoad('default', '<?php echo $root_dir;?>'); _fLoadOut(['css.css', 'js.js']);</script>
</body>
</html>

