{{INC_STATIC(top)}}
  </head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script src="{{BASE_URL}}static/js/bootstrap.min.js"></script>

  <body>
    {{INC_STATIC(header)}}
    <form class="form-horizontal" method="post" action="{{BASE_URL}}postbear/usuarios/_registrar" enctype="multipart/form-data">
 
          <legend>Novo usuário</legend> 

  <div class="control-group">
    <label class="control-label" for="inputNome">Nome</label>
    <div class="controls">
      <input type="text" id="inputNome" name="inputNome" placeholder="Nome" readonly value="{{nome}}" class="span5">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputCpf">CPF</label>
    <div class="controls">
      <input type="text" id="inputCpf" name="inputCpf" placeholder="CPF" readonly value="{{cpf}}" class="span5">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputMatricula">Matrícula</label>
    <div class="controls">
      <input type="text" id="inputMatricula" name="inputMatricula" placeholder="Matrícula" readonly value="{{matricula}}" class="span5">
    </div>
  </div>
   <div class="control-group">
    <label class="control-label" for="inputCentro">Centro</label>
    <div class="controls">
      <input type="text" id="inputCentro" name="inputCentro" placeholder="Centro" readonly value="{{centro}}" class="span5">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputSetor">Setor</label>
    <div class="controls">
      <input type="text" id="inputSetor" name="inputSetor" placeholder="Setor" readonly value="{{setor}}" class="span5">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" id="inputEmail" name="inputEmail" placeholder="Email" readonly value="{{email}}" class="span5">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputGrupo">Grupo</label>
    <div class="controls">
     <select id="inputGrupo" name="inputGrupo">
      {{grupos}}
     </select>
    </div>
  </div>
  <div class="form-actions">
  <button type="submit" class="btn btn-success">Enviar</button>
  <!--<button type="submit" class="btn btn-info">Pré-visualizar</button>-->
  <a href="{{BASE_URL}}postbear/dashboard/index"><button type="button" class="btn">Cancelar</button></a>
</div>

</form>
</div> <!-- /container -->
  <div id="footer">
    {{INC_STATIC(footer)}}
  </div>
</body>
</html>
