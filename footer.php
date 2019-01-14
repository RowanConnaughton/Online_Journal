 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
 
        <script type="text/javascript">

            //toggle forms
            $('.toggleForms').click(function(){

                $('#signUpForm').toggle();
                $('#logInForm').toggle();


            });

            //check for textarea update or input 
            $('#journal').bind('input propertychange', function() {


                //sent text area content to update php 
                $.ajax({
                        method: "POST",
                         url: "updateDatabase.php",
                         data: { content: $("#journal").val() }
                        })
  });
                        
             

            });
        
        </script>
 
  </body>
</html>