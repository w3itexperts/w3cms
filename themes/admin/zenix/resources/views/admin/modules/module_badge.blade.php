@php
	$badgeTones   = ['tone-purple', 'tone-success', 'tone-pink', 'tone-warning', 'tone-primary', 'tone-teal', 'tone-info', 'tone-blue', 'tone-cyan', 'tone-orange'];
	$badgeTone    = $badgeTones[abs(crc32($name)) % count($badgeTones)];
	$badgeLetter  = strtoupper(mb_substr($name, 0, 1));
@endphp
<span class="im-module-icon {{ $badgeTone }}">{{ $badgeLetter }}</span>
