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
      <legend>Configuração do Tema Visual</legend>
      <form class="form-horizontal" method="post" action="{{BASE_URL}}postbear/configPost/_setTemas" enctype="multipart/form-data">
       
        <div class="control-group">
          <label class="control-label" for="avisoNao" title="Aviso Padrão solicitando que a mensagem não seja respondida.">Temas Disponíveis</label>
          <div class="controls">
            <select name="tema" class="temas">
              {{temasDisponiveis}}
            </select>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" id="aplicar" class="btn btn-primary">Aplicar</button>
          <a href="{{BASE_URL}}postbear/dashboard/index"><button type="button" class="btn btn-success">Finalizar</button></a>
        </div>
      </form>
      <hr>
     </div> <!-- /container -->
  <div id="footer">
    {{INC_STATIC(footer)}}
  </div>
</html>
