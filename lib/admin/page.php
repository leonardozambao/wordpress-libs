<?php
global $Tema;
$Tema->admin->save_options();
foreach($Tema->admin->list_pages() as $page){
	if($page['slug'] == $_GET['page']){
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br></div><h2><?php echo $page['nome']; ?></h2>
		<form action="" method="post">
			<table class="form-table">
				<?php $Tema->admin->add_options(); ?>
			</table>
			
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Salvar alterações" /></p>
		</form>
        <?php
		foreach($Tema->admin->list_table() as $tables){
			if($tables['pagina'] == $_GET['page']){
			?>
			<h2><?php echo $tables['label']; ?></h2><br/>
			<table class="widefat">
				<thead>
					<tr>
						<?php
						foreach($tables['lista_campos'] as $nome => $campo){
						?>
						<th><?php echo $nome; ?></th>
						<?php
						}
						?>
					</tr>
				</thead>
				<tbody id="referencia">
				<?php
				$listaTable = $wpdb->get_results($tables['query']);
				if($listaTable){
					foreach($listaTable as $dados){
						$colunas = unserialize($dados->dados);
						echo '<tr>';
						foreach($tables['lista_campos'] as $nome => $campo){
						?>
						<th><?php echo $colunas[$campo]; ?></th>
						<?php
						}
						echo '</tr>';
					}
				}else{
					echo"<tr><td>Nenhum cadastrado</td></tr>";
				}
				?>
				</tbody>
			</table>
			<?php if($tables['export']){ ?>
			<a href="<?php bloginfo('template_directory'); ?>/lib/admin/export.php?page=<?php echo $_GET['page'];?>" target="_blank" class="button button-primary" style="margin-top:10px;">Exportar registros</a>
			<?php } ?>
			<?php
			}
		}
		?>
	</div>
	<?php
	}
}
?>