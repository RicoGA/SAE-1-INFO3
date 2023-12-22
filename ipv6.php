<?php
	function compressedIPv6($ip) {
		return inet_ntop(inet_pton($ip));
	}
	
	function extendedIPv6($ip) {
		$ipv6Parts = explode(':', $ip);
		$extendedParts = array();
		
		foreach ($ipv6Parts as $part) {
			if (empty($part)) {
				for ($i = 1; $i <= 8 - count($ipv6Parts) + 1; $i++) {
					$extendedParts[] = '0000';
				}
			} else {
				$extendedParts[] = str_pad($part, 4, '0', STR_PAD_LEFT);
			}
		}
		
		$binaryType = '';
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			$binaryType = substr(inet_pton($ip), 0, 4);
		}
		
		return [
			'ipv6' => implode(':', $extendedParts),
			'binaryType' => bin2hex($binaryType)
		];
	}
	
	function IPv6type($ipv6) {
		if (substr($ipv6, 0, 4) === '0000') {
			return "adresse réservée";
		} elseif (strpos($ipv6, '2000') === 0) {
			return "adresse unicast routable sur Internet";
		} elseif (strpos($ipv6, 'fc00') === 0 || strpos($ipv6, 'fd00') === 0) {
			return "adresse locale unique";
		} elseif (strpos($ipv6, 'fe80') === 0) {
			return "adresse locale lien";
		} elseif (strpos($ipv6, 'ff00') === 0) {
			return "adresse multicast";
		} else {
			return "adresse unicast routable sur Internet";
		}
	}
	
	if ($_POST['ipv6']) {
		$ip = $_POST['ipv6'];
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			echo "<p>Adresse IPv6 compressée : " . compressedIPv6($ip) . "</p>";
			echo "<p>Adresse IPv6 étendue : " . extendedIPv6($ip)['ipv6'] . "</p>";
			echo "<p>Adresse IPv6 compressée (binaire) : " . extendedIPv6($ip)['binaryType'] . " → l'adresse est une " . IPv6type($ip) . "</p>";
		} else {
			echo "<p><u><b>L'adresse IP n'est pas valide.</b></u></p>";
		}
	}