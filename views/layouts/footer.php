	  </div>
	</div>
  </body>
</html>

<script>

//Fade in the main titles of the login page
$('.titleFadeIn').fadeIn(2500, function(){
	$('.loginFade').fadeIn(2000, function(){
		$('.newProfileFade').fadeIn(2000);
	});
});

//Fade in messages when creating a new profile
$('.message1').fadeIn(2000, function(){
	$('.message1').fadeOut(3000, function(){
		$('.message2').fadeIn(2000, function(){
			$('.message2').fadeOut(3000, function(){
				$('.fadeTimer').fadeIn(2000);
			});
		});
	});
	
});

$('.fadeIn').fadeIn(2000);

</script>