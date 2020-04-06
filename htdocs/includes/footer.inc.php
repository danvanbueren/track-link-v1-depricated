<?php
require_once 'includes/functions.inc.php';
?>

    <footer class="footer">
      <h6 style="float: right;"><?php echo getBuildInfo('ref').' <b>('.strtoupper(getBuildInfo('type')).')</b>'; ?></h6>
      <p>&copy; TrackLink 2020</p>
      <h6>built by <a href="https://github.com/danvanbueren">@danvanbueren</a></h6>
      <?php
      echo "</br></br></br>".$connStatement;
      ?>
    </footer>
    </div>

    <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>

    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>