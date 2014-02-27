{{INC_STATIC(top)}}   
  </head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script src="{{BASE_URL}}static/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    $(".excluir").click(function () {
        if (!confirm('Certeza que deseja excluir esse email?')) {
            return false;
        }
    });
    $(".editar").tooltip();
    $(".excluir").tooltip();
});
  </script>
  <style>
  td.extra{
    width: 210px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: wrap;
    display: block;
  }
  </style>
  

  <body>
    {{INC_STATIC(header)}}
    <legend>{{msgInfo}}</legend>  
    <div class="form-actions">
      <a href="{{BASE_URL}}postbear/usuarios/grupos"><button class="btn btn-primary">{{acao}}</button></a>
      <a href="{{BASE_URL}}"><button class="btn btn-success">Finalizar</button></a>
    </div>
    <hr>
    {{msgRetorno}}
    </div> <!-- /container -->
  <div id="footer">
    {{INC_STATIC(footer)}}
  </div>
</body>
</html>
