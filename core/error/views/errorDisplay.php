{{INC_STATIC(top)}}
  </head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"  type="text/javascript"></script>
  <script src="{{BASE_URL}}static/js/bootstrap.min.js"  type="text/javascript"></script>
  <body>
      {{INC_STATIC(header)}}
      <legend>Ops... Isso não devia ter acontecido...</legend>
       
      <div class="alert alert-error">
          <h1>ERRO {{ID_ERROR}}</h1>
          <p class="lead">
            {{MSG_ERROR}}
          </p>
        </div>
      </div> <!-- /container -->
    <div id="footer">
      {{INC_STATIC(footer)}}
    </div>
</body>
</html>
