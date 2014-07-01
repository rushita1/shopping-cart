<?php

	print_r($_POST);

	echo "<br><br>";

	print_r(json_decode($_POST['cart_data'],true));

	?>