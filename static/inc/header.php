    <div class="container-narrow">
      <a href="{{BASE_URL}}">
          <div id="logo2">
            <img src="{{BASE_URL}}static/img/logo_beta_version.png" alt="PostBear 2.0" />
          </div>
      </a>
      <br/>
      <div class="navbar">
          <div class="navbar-inner">
            <a class="brand" href="{{BASE_URL}}">Sigecom 3.0</a>
            <div class="masthead">
              <ul class="nav nav-pills">
                {{MENU}}
              <li><a href="#Saida" data-toggle="modal" tabindex="-1">Sair</a></li>
              </ul>
            </div>
          </div>
        </div>
      <div id="Saida" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Está de Saida ?</h3>
        </div>
        <div class="modal-body">
        <p>Deseja realmente sair {{APP_NAME}}?</p>
        </div>
        <div class="modal-footer">
        <a href="{{BASE_URL}}logout"><button class="btn btn-primary" aria-hidden="true">Sair</button></a>
        <button class="btn" data-dismiss="modal" >Cancelar</button>
        </div>
      </div>     
    


        <!-- <div id="head">
         -->