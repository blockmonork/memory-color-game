var corPadrao = 'white';
var id_A = '';
var cor_A = '';
var id_B = '';
var cor_B = '';
var _click = 0;
var totalClicks = 0;
var pontos = 0;
var jaFeitos = [];
var processando = false;
function _reset()
{
	id_A = cor_A = id_B = cor_B = '';
	_click = totalClicks = pontos = 0;
	processando = false;
	jaFeitos = [];
	$('#totalClicks').html(totalClicks);
	$('#Pontos').html(pontos);
}
function end_game()
{
	id_A = id_B = cor_A = cor_B = '';
	var fator = (_rights_==10)?2:1;
	var fator2 = (_rights_==10)?1:2;
	var PTS = ((pontos - (totalClicks/_rights_))+fator)/fator2;
	var txt_pts = PTS.toFixed(1);
	var txt_fase = ( _fase_ == 1 ) ? 'normal' : 'hard';
	var t = '<h2>Total Score ('+txt_fase+')</h2>';
	t += '<h3>' + txt_pts + '</h3>';
	$('#memory_game').html(t);
	if ( !ws.get('bestScore') ){
		ws.set('bestScore', PTS);
		$('#best_score').html('Best Score:' + txt_pts);
	}else{
		var x = parseFloat( ws.get('bestScore') );
		if ( PTS > x ){
			ws.set('bestScore', PTS);
			$('#best_score').html('New Score:' + txt_pts);
		}
	}
}
function jaClicado(id)
{
	if ( jaFeitos.length == 0 ){
		return false;
	}else{
		for ( i = 0; i < jaFeitos.length; i++ ){
			if ( jaFeitos[i] == id ){
				return true;
			}
		}
		return false;
	}
}
function v_click(id)
{
	if ( !processando ){
		envia(id);
	}else{
		alert('Processing your last click!');
		return;
	}
}
function envia(id){
	processando = true;
	var temp = setTimeout(function(){
		if ( processa(id) ){
			processando = false;
		}
	}, 300);
}
function processa(id)
{
	var cor = $('#'+id).attr('data');
	if ( id_A == '' ){
		id_A = id
		cor_A = cor;
	}else{
		id_B = id;
		cor_B = cor;
	}
	if ( id_A == id_B ){
		alert('Selected already');
		processando = false;
		return false;
	}else{
		if ( jaClicado(id) ){
			processando = false;
			return false;
		}
	}
	totalClicks++;
	$('#totalClicks').html(totalClicks);	
	$('#'+id).css('background', cor);
	if ( cor_A != '' && cor_B != '' ){
		if ( cor_A == cor_B ){
			pontos++;
			$('#'+id_A).css('background', cor);
			$('#'+id_B).css('background', cor);
			$('#'+id_A).removeClass('item').addClass('item_done');
			$('#'+id_B).removeClass('item').addClass('item_done');
			jaFeitos.push(id_A);
			jaFeitos.push(id_B);
			$('#Pontos').html(pontos);
			cor_A = cor_B = id_A = id_B = '';
			if ( pontos == _rights_ ){
				end_game();
				return false;
			}
		}else{
			setTimeout(function(){
				if ( !jaClicado(id_A) ){
					$('#'+id_A).css('background', corPadrao);
				}
				if ( !jaClicado(id_B) ){
					$('#'+id_B).css('background', corPadrao);
				}
				cor_A = cor_B = id_A = id_B = '';
			}, 800);
		}
	}
	return true;
}
function game_debug(id)
{
	alert('debug cor: ' + $('#'+id).attr('data'));
}	
function _initGame()
{
	_reset();
	$('#Loader').show();
	$('#loadingGame').show();
	$('#memory_game').load('game.php?fase='+_fase_, function(){
		$('#loadingGame').hide();
		$('#Loader').hide();
		if ( ws.get('bestScore') ){
			$('#best_score').html('Best Score:'+ws.get('bestScore'));
		}
	});
}
$(document).ready(function(){
	$('body').gradient({
		direction:'45deg',
		colors:'white, #efefef',
	});
	_initGame();
	$('#ResetGame').click(function(e){
		e.preventDefault();
		_initGame();
	});
});