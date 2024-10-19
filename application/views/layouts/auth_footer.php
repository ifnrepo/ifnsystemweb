    <!-- jquery latest version -->
	  <script src="<?= base_url(); ?>assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/tabler.min.js?1692870487" defer></script>
    <script src="<?= base_url(); ?>assets/js/demo.min.js?1692870487" defer></script>
    <script>
      $(document).ready(function(){
        $("#showpass").click(function(){
          if($("#password").attr('type')=='password'){
            $("#password").attr('type','input');
          }else{
            $("#password").attr('type','password');
          }
        })
        $(document).keydown(function (event) {
            if (event.keyCode == 123) { // Prevent F12
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
                return false;
            }
          });
        $(document).on("contextmenu", function (e) {        
          e.preventDefault();
        });
      })
    </script>
  </body>
</html>