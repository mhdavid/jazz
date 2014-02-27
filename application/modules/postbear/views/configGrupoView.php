

{{INC_STATIC(top)}}
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
   
  </head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script src="{{BASE_URL}}static/js/bootstrap.min.js"></script>
  <script src="{{BASE_URL}}static/js/bootstrap.file-input.js"></script>
  <script>
      $(document).ready(function ()
      {
        if( $("#autenticar").is(':checked') )
          {
          $('#ssl-0').removeAttr('disabled');
          $('#senhaEmail').removeAttr('disabled');
          }

      $("#permitir").click(function ()
        {  
        if( $("#permitir").is(':checked') )
          {
          $('#remetAlter_1').removeAttr('disabled');
          $('#remetAlter_2').removeAttr('disabled');
          $('#remetAlter_3').removeAttr('disabled');
          }
        else
          {
          $('#remetAlter_1').attr('disabled', 'disabled');
          $('#remetAlter_2').attr('disabled', 'disabled');
          $('#remetAlter_3').attr('disabled', 'disabled');
          
          }
        });
       $(".control-label").tooltip();
      });
  </script>

  <body>
    {{INC_STATIC(header)}}
      <legend>Configurações do Grupo de Usuário: <b>{{grupoUsuarios}}</b></legend>
      <form class="form-horizontal" method="post" action="{{BASE_URL}}postbear/usuarios/_setConfigGrupos/{{id_grupo}}" enctype="multipart/form-data">
      <fieldset>

       <!-- Text input-->
      <span class="label label-info">Permissão de Criação de Listas</span>
      <div class="control-group">
        <label class="control-label" for="smtpHost" title="Endereço ou IP do servidor de envio de e-mails">Tipos de Listas</label>
        <div class="controls">
          <label class="checkbox">
            <input name="tipoLista[]" id="privada" value="privada" type="checkbox" {{privada}}>&nbsp;<i class="fa fa-user"></i>&nbsp;&nbsp;Privada
          </label>
          <label class="checkbox">
            <input name="tipoLista[]" id="restrita" value="restrita" type="checkbox" {{restrita}}>&nbsp;<i class="fa fa-users"></i>&nbsp;&nbsp;Restrita
          </label>
          <label class="checkbox">
            <input name="tipoLista[]" id="publica" value="publica" type="checkbox" {{publica}}>&nbsp;<i class="fa fa-circle-o"></i>&nbsp;&nbsp;Pública
          </label>
          <label class="checkbox">
            <input name="tipoLista[]" id="global" value="global" type="checkbox" {{global}}>&nbsp;<i class="fa fa-globe"></i>&nbsp;&nbsp;Global
          </label>

        </div>
      </div>

      <span class="label label-info">Permissão de Uso de Layouts</span>
      <div class="control-group">
        <label class="control-label" for="smtpHost" title="Endereço ou IP do servidor de envio de e-mails">Layouts Disponíveis</label>
        <div class="controls">
          {{layouts}}
        </div>
      </div>


      <span class="label label-info">Multiplos Remententes</span>
      <div class="control-group">
      <label class="control-label" for="smtpHost" title="Endereço ou IP do servidor de envio de e-mails">Permitir</label>
        <div class="controls">
          <label class="checkbox">
          <input name="permitir" id="permitir" value="sim" type="checkbox" {{permissao}}>&nbsp;<i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Sim
          </label>
        </div>
      </div>

      <div class="control-group">
        
        <div class="controls">
          <input id="remetAlter_1" name="remetAlter_1" placeholder="Rementente Alternativo 1" class="input" required type="text" value="{{remetenteAlternativo1}}" {{habilitaMR}}>&nbsp;&nbsp;<i class="icon-info-sign"></i>
        </div>
      </div>

      <div class="control-group">
        
        <div class="controls">
          <input id="remetAlter_2" name="remetAlter_2" placeholder="Rementente Alternativo 2" class="input" required type="text" value="{{remetenteAlternativo2}}" {{habilitaMR}}>&nbsp;&nbsp;<i class="icon-info-sign"></i>
        </div>
      </div>

      <div class="control-group">
        
        <div class="controls">
          <input id="remetAlter_3" name="remetAlter_3" placeholder="Rementente Alternativo 3" class="input" required type="text" value="{{remetenteAlternativo3}}" {{habilitaMR}}>&nbsp;&nbsp;<i class="icon-info-sign"></i>
        </div>
      </div>

      <!-- Text input-->


      </fieldset>
      <button type="submit" class="btn btn-success">Salvar</button>
       <a href="{{BASE_URL}}postbear/usuarios/grupos"><button type="button" class="btn">Cancelar</button></a>
      </form>
      <hr>
    </div> <!-- /container -->
    <div id="footer">
      {{INC_STATIC(footer)}}
    </div>
  </body>
</html>
