<html>
	<head>
		<title><?php echo $article_title ?></title>
	</head>
	<body>
	
		<?php foreach($result as $r): ?>
			<div>
				<h2><?php echo $r->name ?></h2><br/>
				<div><?php echo $r->email ?></div>
				<div><?php echo $r->content ?></div>
			</div>
		<?php endforeach; ?>
		<form method="post" action="">
			Name:<input type="text" id="name" name="name"></input>
			<br/>
			Email:<input type="text" name="email"></input>
			<br/>
			Website:<input type="text" name="website"></input>
			<br/>
			content:<textarea name="content" rows="10" cols="10"></textarea>
			<br/>
			Private:<input type="checkbox" name="private" value="1"></input>
			<br/>
			Captch:<img alt="" src='<?php echo ResponseRegistery::getInstance()->baseURL; ?>/captcha'/>
			<input name="captcha" type="text"></input>
			<br/>
			<input type="submit" value="Save Comment"></input>
		</form>
	</body>
</html>


