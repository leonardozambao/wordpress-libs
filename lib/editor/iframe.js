(function() {

	tinymce.PluginManager.add('youtube',function( editor, url ) {
		
		// Add a button that opens a window
		editor.addButton( 'youtube', {
			tooltip: 'Adicionar Iframe',
			image : url+'/icones/iframe.png',
			icon: 'ytc',
			onclick: function() {
				// Open window
				editor.windowManager.open( {
					title: 'Adicionar Iframe',
					// width: 600,
					// height: 400,
					// autoScroll: true,
					// resizable: true,
					// classes: 'ytc-shortcode-popup',
					bodyType: 'tabpanel',
					buttons: [
						{
							text: 'Inserir Shortcode',
							onclick: 'submit',
							classes: 'widget btn primary',
							minWidth: 130
						},
						{
							text: 'Cancelar',
							//onclick: function() { MensagemAlerta();}
							onclick: 'close'
						}
					],
					body: [
					
						{
							title: 'Configurações',
							type: 'form',
							items: [
								{
									type: 'textbox',
									name: 'width',
									id: 'width',
									label: 'Width',
									value: '',
									tooltip: 'Difina uma largura para o Iframe'
									//onchange: function() { data.title = this.value(); }
								},
								{
									type: 'textbox',
									name: 'height',
									id: 'height',
									label: 'Height',
									value: '',
									tooltip: 'Difina uma altura para o Iframe'
								},
								{
									type: 'listbox',
									name: 'frameborder',
									id: 'frameborder',
									label: 'Borda do Iframe',
									tooltip: '',
									values : [
										{text: 'Sem borda', value: '0', selected: true},
										{text: 'Com borda', value: '1'},
									]
								},
								{
									type: 'textbox',
									name: 'src',
									id: 'src',
									label: 'URL do Iframe',
									value: '',
									tooltip: 'Difina a URL do Iframe'
								},
								{
									type: 'checkbox',
									name: 'allowfullscreen',
									id: 'allowfullscreen',
									label: 'Full Screen',
									tooltip: 'Habilitar Full Screen',
									checked: false
								},
							]
						}
						
					],

					onsubmit: function( e ) {
						// Insert content when the window form is submitted
						// Open shortcode
						var shortcode = '[iframe';
						
						// General Settings
						if ( e.data.width ) shortcode += ' width=' + e.data.width +'';
						if ( e.data.height ) shortcode += ' height=' + e.data.height +'';
						if ( e.data.frameborder ) shortcode += ' frameborder=' + e.data.frameborder +'';
						if ( e.data.src ) shortcode += ' src=' + e.data.src +'';
						if ( e.data.allowfullscreen ) shortcode += ' allowfullscreen=1';
						
						// Global
						//if ( e.data.class ) shortcode += ' class=' + e.data.class + '';

						// Close shortcode
						shortcode += ']';

						editor.insertContent( shortcode );
					} // onsubmit alert

				} );
			} // onclick alert

		} );

	} );

})();

function MensagemAlerta(){
	jQuery("#IDMensagemAlerta").val('Mensagem para o IDMensagemAlerta');
}