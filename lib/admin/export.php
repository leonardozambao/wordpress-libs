<?php
include_once('../../../../../wp-load.php');
global $Tema;
global $wpdb;

foreach($Tema->admin->list_table() as $tables){
	if($tables['pagina'] == $_GET['page']){
		$query = $wpdb->get_results($tables['query']);
		
		$contar = count($query);
		for($i=0;$i<1;$i++){   
			$html[$i] = "";
			$html[$i] .= "<table>";
			$html[$i] .= "<tr>";
			foreach($tables['lista_campos'] as $nome => $campo){
				$html[$i] .= "<td><b>".$nome."</b></td>";
			}
			$html[$i] .= "</tr>";
			$html[$i] .= "</table>";
		}
		 
		$i = 1;
		foreach($query as $dados){
			$colunas = unserialize($dados->dados);
			$html[$i] .= "<table>";
			$html[$i] .= "<tr>";
			foreach($tables['lista_campos'] as $nome => $campo){
				$html[$i] .= "<td>".utf8_decode($colunas[$campo])."</td>";
			}
			$html[$i] .= "</tr>";
			$html[$i] .= "</table>";
			$i++;
		}
		
		$data = date("YmdHis");
		
		$arquivo = 'Export '.$tables['label'].' '.get_bloginfo('name').' '.$data.'.xls';
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename={$arquivo}" );
		header ("Content-Description: PHP Generated Data" );
		
		for($i=0;$i<=$contar;$i++){  
			echo $html[$i];
		}
	}
}
?>