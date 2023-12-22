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
	
	$subNetworksSize = $_POST;
	$ipv4 = $subNetworksSize['ipv4'];
	$mask = $subNetworksSize['mask'];
	unset($subNetworksSize['ipv4'], $subNetworksSize['mask'], $subNetworksSize['subnetworks']);
	
	if (!filter_var($ipv4, FILTER_VALIDATE_IP)) {
		echo "<p><u><b>L'adresse IP n'est pas valide.</b></u></p>";
		return;
	}
	
	if (!is_numeric($mask)) {
		echo "<p><u><b>Le masque n'est pas un nombre.</b></u></p>";
		return;
	}
	
	if (!is_array($subNetworksSize) || count(array_filter($subNetworksSize, 'is_numeric')) != count($subNetworksSize)) {
		echo "<p><u><b>subNetworksSize doit être un tableau de nombres.</b></u></p>";
		return;
	}
	
	arsort($subNetworksSize);
	
	echo "<h5><kbd>Adresse du réseau principal : <u>$ipv4/$mask</u></kbd></h5>";
	$mainNetworkSize = maxNetworkSize($mask);
	echo "<h5><kbd>Nombre d'adresses IP possibles sur le réseau principal : <u>$mainNetworkSize</u></kbd></h5>";
	
	$neededIPs = array_sum($subNetworksSize);
	$allocatedIPs = 0;
	
	foreach ($subNetworksSize as $key => $value) {
		$subnetMask = subnetSize($value);
		$allocatedIPs += maxNetworkSize($subnetMask);
	}
	
	$mainNetworkUsage = ($neededIPs / $mainNetworkSize) * 100;
	$subNetworkUsage = ($neededIPs / $allocatedIPs) * 100;
	
	echo "<h5><kbd>Nombre d'adresses IP nécessaires : <u>$neededIPs</u></kbd></h5>";
	echo "<h5><kbd>Nombre d'adresses IP disponibles dans les sous-réseaux alloués : <u>$allocatedIPs</u></kbd></h5>";
	echo "<h5><kbd>Environ <u>" . round($mainNetworkUsage, 2) . "%</u> de l'espace d'adressage du réseau principal est utilisé</u></kbd></h5>";
	echo "<h5><kbd>Environ <u>" . round($subNetworkUsage, 2) . "%</u> de l'espace d'adressage du réseau sous-réseau est utilisé</u></kbd></h5>";
	
	echo "<table><thead><tr><th scope='col'>Numéro du sous-réseau</th><th scope='col'>Taille</th><th scope='col'>Taille allouée</th><th scope='col'>Adresse</th><th scope='col'>Masque au format CIDR</th><th scope='col'>Adresse du masque</th><th scope='col'>Plage d'adresses IP</th><th scope='col'>Adresse Broadcast</th></tr></thead><tbody>";
	foreach ($subNetworksSize as $key => $value) {
		$subnetMask = subnetSize($value);
		$subNetworksInfos = subnetInfos($ipv4, $subnetMask);
		preg_match('/\d+/', $key, $matches);
		$subNetworksData = [
			'networkName' => $matches[0],
			'networkSize' => $value,
			'networkAllocatedIPs' => maxNetworkSize($subnetMask),
			'networkAddress' => $subNetworksInfos['networkAddress'],
			'networkMask' => "/" . $subnetMask,
			'networkMaskAddress' => long2ip(~((1 << (32 - $subnetMask)) - 1)),
			'networkAddresses' => $subNetworksInfos['firstAddress'] . " - " . $subNetworksInfos['lastAddress'],
			'networkBroadcastAddress' => $subNetworksInfos['broadcastAddress']
		];
		echo "<tr><td>" . implode("</td><td>", $subNetworksData) . "</td></tr>";
		$ipv4 = long2ip(ip2long($subNetworksInfos['broadcastAddress']) + 1);
	}
	
	echo "</tbody></table>";