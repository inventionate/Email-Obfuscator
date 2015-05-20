<?php

/**
 * @param string $string
 * @return string
 */
function obfuscateEmail($string)
{
	$patterns = array(
			'|\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>|ism', // mailto anchors
			'|[_a-z0-9-]+(?:\.[_a-z0-9-]+)*@[a-z0-9-]+(?:\.[a-z0-9-]+)*(?:\.[a-z]{2,3})|i', // plain emails
	);

	foreach ($patterns as $pattern) {
		$string = preg_replace_callback($pattern, function ($parts) {
			// Filter out empty array elements and reset keys.
			$parts = array_values(array_filter(array_map('trim', $parts)));

			// ROT13 implementation for JS-enabled browsers
			$js = '<script type="text/javascript">Rot13.write(' . "'" . str_rot13($parts[0]) . "'" . ');</script>';

			// Reversed direction implementation for non-JS browsers
			if (stripos($parts[0], '<a') === 0) {
				// Mailto tag; if link content equals the email, just display the email, otherwise display a formatted string.
				$nojs = ($parts[1] == $parts[2]) ? $parts[1] : ($parts[2] . ' > ' . $parts[1] . ' <');
			}
			else {
				// Plain email; display the plain email.
				$nojs = $parts[0];
			}
			$nojs = '<noscript><span style="unicode-bidi:bidi-override;direction:rtl;">' . strrev($nojs) . '</span></noscript>';

			// Safeguard the obfuscation using a placeholder so it won't get picked up by the next iteration.
			return str_replace('@', '$%$!!$%$', $js . $nojs);
		}, $string);
	}

	return str_replace('$%$!!$%$', '@', $string);
}
