<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<style type="text/css">
	.banners{
		width: 100%;
		height:100%;
	}
	.banner{ 
		margin: 10px;
		text-align: center;
		font-size: x-large;
		font-family: "Times New Roman", Times, serif;
	}
	</style>
	<title>Banner</title>
</head>
<script type="text/javascript">
	$(document).ready(function(){
		var beritas = <?= json_encode($beritas) ?>;
		var i = 0;
		window.setInterval(function(){
		  	$('.banner').animate({'opacity': 0}, 1000, function () {
			    $(this).html(beritas[++i]);
			}).animate({'opacity': 1}, 1000, function(){
			    if (i==beritas.length-1) i = -1;
			});
		}, 5000);
	})
</script>
<body>
	<div class="banners">
			<div class="banner">
				<?= $beritas[0] ?>
			</div>
	</div>
</body>
</html>
