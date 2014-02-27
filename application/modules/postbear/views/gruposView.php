{{INC_STATIC(top)}}
  </head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script src="{{BASE_URL}}static/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    {{jquery}}
});
  
// HINT
  $(document).ready(function(){
    
    $(".listar").tooltip();
    $(".adicionar").tooltip();
    $(".editar").tooltip();
    $(".excluir").tooltip();
    $(".excluirGrupo").tooltip();
    $(".icon-envelope").tooltip();
    $(".icon-globe").tooltip();
    $(".icon-resize-small").tooltip();
    $(".icon-resize-full").tooltip();
    $(".icon-user").tooltip();
  });
  </script>
  <body>
    {{INC_STATIC(header)}}
    <legend>Grupos de Usuários</legend>
    <div class="form-actions">
      <a href="{{BASE_URL}}postbear/usuarios/_novoGrupo"><button class="btn btn-primary">Criar Novo Grupo</button></a>
      <a href="{{BASE_URL}}"><button class="btn btn-success">Finalizar</button></a>
    </div>
    <hr/>
    {{grupos}}
    
  </div> <!-- /container -->
    {{INC_STATIC(modalExcluir)}}
  <div id="footer">
    {{INC_STATIC(footer)}}
  </div>
</body>
</html>
