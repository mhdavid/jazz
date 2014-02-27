{{INC_STATIC(top)}}
  </head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script src="{{BASE_URL}}static/js/bootstrap.min.js"></script>

  <script>
  $(document).ready(function(){
    $('#global').popover(options)
  };
  </script>


<script>
 $(document).ready(function() {
    $('.Contatos').click(function() {
        if(this.checked == true){
            $("#Contatos").each(function() {
                this.checked = true;
                $('#buscarLdap').removeAttr('disabled');
            });
        } else {
            $("#Contatos").each(function() {
               $('#buscarLdap').attr('disabled', 'disabled');
                this.checked = false;
            });
        }
    });
  });

 $(document).ready(function() {
    $('#Contatos').click(function() {
        if(this.checked == true){
            $(".Contatos").each(function() {
                this.checked = true;
                $('#buscarLdap').removeAttr('disabled');
            });
        } else {
            $(".Contatos").each(function() {
               $('#buscarLdap').attr('disabled', 'disabled');
                this.checked = false;
            });
        }
    });
  });

$(document).ready
  (function()
    {
    $('.Contatos').click(function checkBox() {
var files = '';
// Procura em todos os elementos com a classe cinput na página.
$(".Contatos:checked").each(function(){
//Verifica se input checkbox esta marcado
//if(this.checked) {
// Adiciona valor do checkbox
files = files + ' [' + this.value + '] ';
//}
if (files=='')
  {
     $("#Contatos").each(function() {
       this.checked = false;});
  }

});

})});
</script>

  <body>
    {{INC_STATIC(header)}}
      <legend>{{btn}} Grupo de Usuários <b>(Em Desenvolvimento)</b></legend>
      <form class="form-horizontal" method="post" action="{{BASE_URL}}postbear/usuarios/{{acao}}" enctype="multipart/form-data">
        <div class="control-group">
          <label class="control-label" for="inputTitle">Nome Grupo</label>
          <div class="controls">
            <input type="text" id="inputTitle" name="nome_grupo" value="{{nome_grupo}}" class="span5" required>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputTitle">Descrição</label>
          <div class="controls">
            <input type="text" id="inputTitle" name="desc_grupo" value="{{desc_grupo}}" class="span5" required>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputTitle">Permissões</label>
          <div class="controls">
            {{permissoes}}
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">{{btn}}</button>
          <a href="{{BASE_URL}}postbear/usuarios/grupos"><button type="button" class="btn">Cancelar</button></a>
        </div>
      </form>
           
    </div> <!-- /container -->
  <div id="footer">
    {{INC_STATIC(footer)}}
  </div>
  </body>
</html>
