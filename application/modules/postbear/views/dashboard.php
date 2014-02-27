  {{INC_STATIC(top)}}
  </head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"  type="text/javascript"></script>
  <script src="{{BASE_URL}}static/js/bootstrap.min.js"  type="text/javascript"></script>
  <script>
    $(document).ready(function ()
      {
        $(".btn").tooltip();
      });
  </script>
  <body>
      {{INC_STATIC(header)}}
      <legend>Bem-vindo, O que você deseja fazer?</legend>
        <div class="form-actions">
          <div id="botoes" class="btn-group.btn-large">
              <a href="{{BASE_URL}}mensagens/compor/index"><button class="btn btn-large btn-primary" title="Clique aqui para compor uma nova mensagem" >Compor Mensagem</button></a>
              <a href="{{BASE_URL}}mensagens/enviadas/index"><button class="btn btn-large btn-primary"  title="Listar mensagens enviadas">Listar Mensagens</button></a>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span7">
              <span class="label label-info">Você Está Logado Como:</span>
              <br/><br/>
              <b>Nome:</b> {{usuario}}<br/>
              <b>Centro:</b> {{centro}}<br/>
              <b>Setor:</b> {{setor}}<br/>
              <b>Grupo:</b> {{grupo}}<br/>
              <b>E-Mail:</b> {{email}}<br/>
              <b>Tema:</b> {{tema}}
              <hr/>
              Última Alteração de Senha:<br/>
              {{ultimoupdate}}
              <br/>
              <!--Versão: {{versao}}-->
          </div>
          <div class="span5" id="last10">
              <span class="label label-info">Últimas 10 Mensagens Enviadas</span>
               <ul class="nav nav-list">
                {{listaMensagens}} 
              </ul>
          </div>
        </div>
      </div> <!-- /container -->
    <div id="footer">
      {{INC_STATIC(footer)}}
    </div>
  </body>
</html>
