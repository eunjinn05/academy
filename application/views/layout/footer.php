
    <footer class="mt-auto text-white-50">
    </footer>

    <script src="https://code.jquery.com/jquery-latest.min.js" defer></script>
    <script src="//cdn.ckeditor.com/4.22.1/standard/ckeditor.js" defer></script>
    <script src="/assets/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js' defer></script>
    
    <?php if (file_exists("assets/js/src/layout/".$class_name.".js")) { ?>
      <script src="/assets/js/src/layout/<?php echo $class_name?>.js" defer></script>      
    <?php } ?>
  </div>

  </body>
</html>
