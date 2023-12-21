<?php
	function maxNetworkSize($mask) {
		return pow(2, (32 - $mask)) - 2;
	}
	
	function subnetSize($NeededSize) {
		for ($i = 31; $i >= 0; $i--) {
			if (maxNetworkSize($i) >= $NeededSize) {
				return $i;
			}
		}
	}
	
	function subnetInfos($ipv4, $mask) {
		$networkSize = maxNetworkSize($mask);
		$broadcastAddress = long2ip(ip2long($ipv4) + $networkSize + 1);
		return [
			'networkAddress' => $ipv4,
			'networkSize' => $networkSize,
			'broadcastAddress' => $broadcastAddress,
			'firstAddress' => long2ip(ip2long($ipv4) + 1),
			'lastAddress' => long2ip(ip2long($broadcastAddress) - 1)
		];
	}
	
	$subNetworksSize = $_GET;
	$ipv4 = $subNetworksSize['ipv4'];
	$mask = $subNetworksSize['mask'];
	unset($subNetworksSize['ipv4'], $subNetworksSize['mask'], $subNetworksSize['subnetworks']);
	
	arsort($subNetworksSize);
	
	echo "<h5><kbd>Adresse du réseau principale : <u>$ipv4/$mask</u></kbd></h5>";
	echo "<table><thead><tr><th scope='col'>Numéro du sous-réseau</th><th scope='col'>Taille</th><th scope='col'>Adresse</th><th scope='col'>Masque au format CIDR</th><th scope='col'>Plage d'adresses IP</th><th scope='col'>Adresse Broadcast</th></tr></thead><tbody>";

	foreach ($subNetworksSize as $key => $value) {
		$subNetworksInfos = subnetInfos($ipv4, subnetSize($value));
		preg_match('/\d+/', $key, $matches);
		$subNetworksData = [
			'networkName' => $matches[0],
			'networkSize' => $value,
			'networkAddress' => $subNetworksInfos['networkAddress'],
			'networkMask' => "/" . subnetSize($value),
			'networkAddresses' => $subNetworksInfos['firstAddress'] . " - " . $subNetworksInfos['lastAddress'],
			'networkBroadcastAddress' => $subNetworksInfos['broadcastAddress']
		];
		echo "<tr><td>" . implode("</td><td>", $subNetworksData) . "</td></tr>";
		$ipv4 = long2ip(ip2long($subNetworksInfos['broadcastAddress']) + 1);
	}

	echo "</tbody></table>";