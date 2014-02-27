{{INC_STATIC(top)}}
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
  </head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> 
  <script src="{{BASE_URL}}static/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function ()
      {
      $(".chs").click(function ()
        {  
        if( $(".chs").is(':checked') )
          {
          $('#disparar').removeAttr('disabled');
          }
        else
          {
          $('#disparar').attr('disabled', 'disabled');
          }
        });
    
    $(".control-label").tooltip();
  });
  
  </script>
 

  <script src="{{BASE_URL}}static/js/bootstrap.file-input.js"></script>
 
  <body>
      {{INC_STATIC(header)}}
      <legend>Configuração dos Avisos Padrões</legend>
      <form class="form-horizontal" method="post" action="{{BASE_URL}}postbear/configPost/_setAvisos" enctype="multipart/form-data">
       
        <div class="control-group">
          <label class="control-label" for="avisoNao" title="Aviso Padrão solicitando que a mensagem não seja respondida.">Aviso Não Responder</label>
          <div class="controls">
            <textarea class="span5" rows="3" name="avisoNao">{{avisoNao}}</textarea>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="avisoSim" title="Aviso Padrão solicitando resposta para a mensagem.">Aviso Responder</label>
          <div class="controls">
            <textarea class="span5" rows="3" name="avisoSim">{{avisoSim}}</textarea>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="avisoSim" title="Aviso institucional visível no rodapé de todas as mensagens enviadas.">Aviso de Rodapé</label>
          <div class="controls">
            <textarea class="span5" rows="3" name="avisoInstitucional">{{avisoInstitucional}}</textarea>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" id="disparar" class="btn btn-success">Salvar</button>
          <a href="{{BASE_URL}}postbear/dashboard/index"><button type="button" class="btn">Cancelar</button></a>
        </div>
      </form>
      <hr>
     </div> <!-- /container -->
  <div id="footer">
    {{INC_STATIC(footer)}}
  </div>
</html>
