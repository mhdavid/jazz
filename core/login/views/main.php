{{INC_STATIC(top)}}
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
        color: #999;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
    </style>
    <!-- <script type="text/javascript" src="{{BASE_URL}}static/js/sha512.js"></script>
    <!--<script type="text/javascript" src="{{BASE_URL}}static/js/forms.js"></script> -->
    
  </head>

  <body>

    <div class="container">
      <form class="form-signin" action="{{BASE_URL}}loginactionLdap" method="post" name="login_form">
        <img src="{{BASE_URL}}static/img/logo4.jpg" alt="PostBear 2.0">
          <input type="text" class="input-block-level" placeholder="Matrícula/CPF" name="matriculaCpf" value="" autofocus required />
        <input type="password" class="input-block-level" placeholder="Senha Expresso UDESC" name="password" value="" required />
        <!--<button class="btn btn-large btn-primary" onclick="formhash(this.form, this.form.password);">Logar</button>-->
        <button class="btn btn-large btn-primary">Logar</button>
      </form>
      <div class="form-signin info">
      {{msg_login}}   
      </div> 
   </div>
  </body>
</html>

  

