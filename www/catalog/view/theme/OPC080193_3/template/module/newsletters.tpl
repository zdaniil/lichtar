<script>
		function subscribe()
		{
			var emailpattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var email = $('#txtemail').val();
			if(email != "")
			{
				if(!emailpattern.test(email))
				{
					$('.text-danger').remove();
					var str = '<span class="error">Invalid Email</span>';
					$('#txtemail').after('<div class="text-danger">Invalid Email</div>');

					return false;
				}
				else
				{
					$.ajax({
						url: 'index.php?route=module/newsletters/news',
						type: 'post',
						data: 'email=' + $('#txtemail').val(),
						dataType: 'json',
						
									
						success: function(json) {
						
						$('.text-danger').remove();
						$('#txtemail').after('<div class="text-danger">' + json.message + '</div>');
						
						}
						
					});
					return false;
				}
			}
			else
			{
				$('.text-danger').remove();
				$('#txtemail').after('<div class="text-danger">Email Is Require</div>');
				$(email).focus();

				return false;
			}
			

		}
	</script>
	
<div class="news-parralax">
<div class="parallex">
<div class="container">
<div class="parallex-cms"><?php echo $newscms; ?> </div>
<div class="newsletter-container">
<div class="newsletter_inner">
<div class="envelope"></div>
<div class="newshead"><?php echo $heading_title; ?></div>
<div class="sub_text"><?php echo $newstext; ?> </div>	
<div class="newsletter">
	<form method="post">
		<div class="form-group required"> 
            <div class="newsletter-box">
              <input type="email" name="txtemail" id="txtemail" value="" placeholder="<?php echo $entry_email; ?>" class="form-control input-lg"  /> 
    	      <button type="submit" class="btn btn-default btn-lg" onclick="return subscribe();"><?php echo $text_button; ?></button>   
            </div>
		</div>	
	</form>
</div>	        
</div>
</div>
</div>
</div>
</div>