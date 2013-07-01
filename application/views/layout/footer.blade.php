  <footer id="globalfoot">
    <div class="container">

      <div class="row-fluid">
        <div class="span4 info">
          <h5>Gaia is a project crafted by the community</h5>
          
          <a href="{{ URL::base() }}/forum">Need help? Visit our forums</a>
          <!--<a href="" class="disabled">Our past releases</a>-->
        </div>

        <div class="span5 social">
          <h5>Follow us on facebook</h5>
          <div class="fb-like" data-href="https://www.facebook.com/gaianme" data-send="false" data-width="349" data-show-faces="true"></div>
        </div>

        <div class="span3">
          <h5><a href="http://mariusbauer.com">Curated by Marius Bauer</a></h5>
          <h5 class="craftedby">
            Crafted by <a href="http://gousta.me/" target="_blank">Stratos</a> & <a href="http://zerply.com/Clu" target="_blank">Leo</a>
          </h5>
        </div>
      </div>

    </div>
  </footer>

  <!-- JavaScripts -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.8.1.min.js"><\/script>')</script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.1.1/bootstrap.min.js"></script>
  {{ HTML::script('assets/js/vendor/combined.170912.js') }}

  {{ HTML::script('assets/js/main.js') }}

  <script>
  $(function() {
    $("#file").change(function() {
      $("#upload_form").submit();
      $("#input").hide();
      $("#loading").show();
    });
  });
  </script>

  <!-- Social plugins -->
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

  <div id="fb-root"></div>
  <script>
    (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>

  <!-- Analytics -->
  <script>
    var _gaq=[['_setAccount','UA-9724103-12'],['_setDomainName', 'gaian.me'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
</body>
</html>