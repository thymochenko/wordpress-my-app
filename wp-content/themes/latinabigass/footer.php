	</div>

    </div><!-- /.container -->
<footer>
<!--<div class="box"><img class="img-responsive" src="img/bigass.gif"></div>-->
          <p>&copy; 2015 Company, Inc. <br>
		  <a href="#">Home</a> | <a href="">Category</a> | <a href="http://localhost/index.php/category/blog/">Blog</a>
		  | <a href="#">Contact</a>
</footer>

</div><!-- /.container controll-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.32/jquery.form.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
		<script>
		var count = 0;//recebendo o valor 5 que você disse
		$('#searchform').click(function(){
			if(count == 0){
  			var myWindow = window.open("http://enter.redtubeplatinum.com/signup/signup.php?step=signup&nats=MTU5NjA6MTM6MTE,0,0,0,0&tpl=join50&cpop=yes&path=&nats=MTU5NjA6MTM6MTE,593,0,0,0", "banner", "width=650,height=500");
  			count++;
			}
		});


		var myVar;

		function myFunction() {
    	myVar = setTimeout(modal, 10000);
		}

		function modal() {
  		$('#bannerModal').modal('show');
		}

		myFunction();


		$('#sucess').hide();
		$('#error').hide();
		$('#preload').hide();

		jQuery.validator.addMethod('answercheck', function (value, element) {
						return this.optional(element) || /^\bcat\b$/.test(value);
		}, "type the correct answer -_-");

		$(function() {
				$('#contact').validate({
						rules: {
								name: {
										required: true,
										minlength: 2
								},
								email: {
										required: true,
										email: true
								}
						},
						messages: {
								name: {
										required: "come on, you have a name don't you",
										minlength: "your name must consist of at least 2 characters"
								},
								email: {
										required: "no email, no message"
								},
								msg: {
										required: "um...yea, you have to write something to send this form.",
										minlength: "thats all? really?"
								}
						},
						submitHandler: function(form) {
								$(form).ajaxSubmit({
										type:"POST",
										data: $(form).serialize(),
										url:"http://localhost/wp-content/themes/latinabigass/contactForm.php",
										beforeSend: function (){
											$("#preload").fadeIn();
										},
										success: function() {
													//  $('#contact').fadeTo( "slow", 0.15, function() {
														$(this).find(':input').attr('disabled', 'disabled');
														$('#sucess').fadeIn();
														$('#preload').hide();
												//});
										},
										error: function() {
												//$('#contact').fadeTo( "slow", 0.15, function() {
												    $('#error').fadeIn();
												//});
										}
								});
						}
				});
		});
		</script>

		<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
