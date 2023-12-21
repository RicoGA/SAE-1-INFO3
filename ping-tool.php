<?php
	if ($_GET['ip']) {
		$ip = $_GET['ip'];
		if (filter_var($ip, FILTER_VALIDATE_IP) || filter_var(gethostbyname($ip), FILTER_VALIDATE_IP)) {
			$ping_result = shell_exec("ping -c 4 " . escapeshellarg($ip));
			if ($ping_result !== null) {
				echo "<h2>Résultat du ping pour $ip :</h2>";
				echo "<pre>$ping_result</pre>";
			} else {
				echo "<p><u><b>Impossible de pinguer $ip.</b></u></p>";
			}
		} else {
			echo "<p><u><b>L'adresse IP n'est pas valide ou n'est pas accessible.</b></u></p>";
		}
	}