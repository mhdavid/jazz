{{INC_STATIC(top)}}
  </head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script src="{{BASE_URL}}static/js/bootstrap.min.js"></script>
  <body>
      {{INC_STATIC(header)}}
      <legend>Buscar Usuário em Base LDAP</legend> 
      <form class="form-search" method="post" action="{{BASE_URL}}postbear/usuarios/_buscaLdap/{{id_grupo}}" enctype="multipart/form-data">
        <div class="input-append">
          <div class="input-append">
            <input type="text" id="inputNome" name="inputMatCPF" placeholder="Matrícula ou CPF" class="span2 search-query" required>
            <button type="submit" class="btn">Buscar</button>
          </div>
        </div>
        <hr/>
        <div class="alert alert-info">
          <strong><u>Buscar em Base LDAP:</u></strong><br/> Utilize a matrícula ou CPF do usuário para fazer a busca na base LDAP da UDESC
        </div>
      </form>
    </div> <!-- /container -->
    <div id="footer">
      {{INC_STATIC(footer)}}
    </div>
  </body>
</html>
