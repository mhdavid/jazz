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

          
      $("#autenticar").click(function ()
        {  
        if( $("#autenticar").is(':checked') )
          {
          $('#ssl-0').removeAttr('disabled');
          $('#senhaEmail').removeAttr('disabled');
          }
        else
          {
          $('#ssl-0').attr('disabled', 'disabled');
          $('#senhaEmail').attr('disabled', 'disabled');
          }
        });
       $(".control-label").tooltip();
      });
  </script>
  <body>
    {{INC_STATIC(header)}}
      <legend>Configurações do Servidor de E-mail</legend>
      <form class="form-horizontal" method="post" action="{{BASE_URL}}postbear/configPost/_setConfig" enctype="multipart/form-data">
      <fieldset>

       <!-- Text input-->
      <div class="control-group">
        <label class="control-label" for="smtpHost" title="Endereço ou IP do servidor de envio de e-mails">SMTP Host</label>
        <div class="controls">
          <input id="smtpHost" name="smtpHost" placeholder="IP ou endereço do SMTP Host" class="input-large" required type="text" value="{{host}}">
        </div>
      </div>

      <!-- Text input-->
      <div class="control-group">
        <label class="control-label" for="smtpPort" title="Porta SMTP utilizada pelo servidor de envio de e-mails">Porta SMTP</label>
        <div class="controls">
          <input id="smtpPort" name="smtpPort" placeholder="Porta SMTP" class="input-small" required type="text" value="{{porta}}">&nbsp;&nbsp;<i class="icon-info-sign"></i>&nbsp;&nbsp;Porta Padrão 25.
        </div>
      </div>

      <!-- Multiple Checkboxes -->
      <div class="control-group">
        <label class="control-label" for="ssl" title="Marque essa opção se o servidor necessita de autenticação para enviar e-mails">Autenticação</label>
        <div class="controls">
          <label class="checkbox" for="autenticar">
            <input name="autenticar" id="autenticar" value="Sim" type="checkbox" {{autenticar}}>SIM&nbsp;&nbsp;<i class="icon-info-sign"></i>&nbsp;&nbsp;Exige uma senha para autenticação do E-mail Origem.
          </label>
        </div>
      </div>

      <!-- Multiple Checkboxes -->
      <div class="control-group">
        <label class="control-label" for="ssl" title="Marque essa opção se o servidor SMTP faz uso do recurso SSL">Utilizar SSL</label>
        <div class="controls">
          <label class="checkbox" for="ssl-0">
            <input name="ssl" id="ssl-0" value="Sim" type="checkbox" disabled {{ssl}}>
            Sim
          </label>
        </div>
      </div>

      <!-- Text input-->
      <div class="control-group">
        <label class="control-label" for="remetenteOrigem" title="Defina qual nome será utilizado como remetente padrão das mensagens">Remetente Padrão</label>
        <div class="controls">
          <input id="emailOrigem" name="remetenteOrigem" placeholder="Remetente Padrão" class="input-large" required type="text" value="{{remetenteOrigem}}">
        </div>
      </div>

      <!-- Text input-->
      <div class="control-group">
        <label class="control-label" for="emailOrigem" title="Informe a conta padrão para o envio das mensagens">Email Origem</label>
        <div class="controls">
          <input id="emailOrigem" name="emailOrigem" placeholder="Email de Origem" class="input-large" required type="email" value="{{emailOrigem}}">
        </div>
      </div>

       <!-- Text input-->
      <div class="control-group">
        <label class="control-label" for="senhaEmail" title="Informe a senha da conta se necessário">Senha Email</label>
        <div class="controls">
          <input id="senhaEmail" name="senhaEmail" placeholder="Senha do Email de Origem" class="input-large" required type="password" disabled value="{{senhaEmail}}">
        </div>
      </div>
      
      
      </fieldset>
      <button type="submit" class="btn btn-success">Salvar</button>
       <a href="{{BASE_URL}}postbear/dashboard/index"><button type="button" class="btn">Cancelar</button></a>
      </form>
      <hr>
    </div> <!-- /container -->
    <div id="footer">
      {{INC_STATIC(footer)}}
    </div>
  </body>
</html>
