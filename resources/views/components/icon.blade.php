@props(['name' => '', 'class' => '', 'style' => ''])
@php
$svg = '';
$paths = [];
switch ($name) {
    case 'layout-dashboard':
        $paths = ['M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z','M9 22V12h6v10'];
        break;
    case 'file-text':
        $paths = ['M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z','M16 2v6h6','M12 18h4','M8 14h8','M8 10h2'];
        break;
    case 'calendar-check':
        $paths = ['M8 2v4','M16 2v4','M3 10h18','M21 14a7 7 0 11-14 0 7 7 0 0114 0z','M12 16l1.5 1.5L16 14'];
        break;
    case 'users':
        $paths = ['M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2','M9 7a4 4 0 100-8 4 4 0 000 8z','M23 21v-2a4 4 0 00-3-3.87','M16 3.13a4 4 0 010 7.75'];
        break;
    case 'external-link':
        $paths = ['M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6','M15 3h6v6','M10 14L21 3'];
        break;
    case 'eye':
        $paths = ['M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z','M12 9a3 3 0 100 6 3 3 0 000-6z'];
        break;
    case 'eye-off':
        $paths = ['M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94','M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19','M1 1l22 22'];
        break;
    case 'chevron-down':
        $paths = ['M6 9l6 6 6-6'];
        break;
    case 'log-out':
        $paths = ['M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4','M16 17l5-5-5-5','M21 12H9'];
        break;
    case 'home':
        $paths = ['M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1'];
        break;
    case 'globe':
        $paths = ['M22 12a10 10 0 11-20 0 10 10 0 0120 0z','M2 12h20','M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z'];
        break;
    case 'menu':
        $paths = ['M4 6h16','M4 12h16','M4 18h16'];
        break;
    case 'x':
        $paths = ['M18 6L6 18','M6 6l12 12'];
        break;
    case 'check-circle':
        $paths = ['M22 11.08V12a10 10 0 11-5.93-9.14','M22 4L12 14.01 9 11.01'];
        break;
    case 'alert-circle':
        $paths = ['M12 22a10 10 0 100-20 10 10 0 000 20z','M12 8v4','M12 16h.01'];
        break;
    case 'plus':
        $paths = ['M12 5v14','M5 12h14'];
        break;
    case 'upload-cloud':
        $paths = ['M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4','M17 8l-5-5-5 5','M12 3v12'];
        break;
    case 'image':
        $paths = ['M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10z','M3 16l5-5a2 2 0 012.83 0L21 21','M16 11a3 3 0 100-6 3 3 0 000 6z'];
        break;
    case 'trash-2':
        $paths = ['M3 6h18','M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6','M10 11v6','M14 11v6','M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2'];
        break;
    case 'grip-vertical':
        $paths = ['M9 5v2','M9 11v2','M9 17v2','M15 5v2','M15 11v2','M15 17v2'];
        break;
    case 'arrow-up':
        $paths = ['M12 19V5','M5 12l7-7 7 7'];
        break;
    case 'arrow-down':
        $paths = ['M12 5v14','M19 12l-7 7-7-7'];
        break;
    case 'save':
        $paths = ['M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z','M17 21v-8H7v8','M7 3v5h8'];
        break;
    case 'help-circle':
        $paths = ['M12 22a10 10 0 100-20 10 10 0 000 20z','M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3','M12 17h.01'];
        break;
    case 'loader-circle':
        $paths = ['M21 12a9 9 0 11-6.22-8.56'];
        break;
    case 'check':
        $paths = ['M20 6L9 17l-5-5'];
        break;
    case 'trending-up':
        $paths = ['M23 6l-9.5 9.5-5-5L1 18'];
        break;
    case 'inbox':
        $paths = ['M22 12h-6l-2 3H9l-3-3H2','M2 12v6a2 2 0 002 2h16a2 2 0 002-2v-6'];
        break;
    case 'calendar':
        $paths = ['M8 2v4','M16 2v4','M3 10h18','M21 14V6a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2h7'];
        break;
    case 'layers':
        $paths = ['M12 2L2 7l10 5 10-5-10-5z','M2 17l10 5 10-5','M2 12l10 5 10-5'];
        break;
    case 'building-2':
        $paths = ['M6 22V4a2 2 0 012-2h8a2 2 0 012 2v18','M6 12H4a2 2 0 00-2 2v6a2 2 0 002 2h2','M18 9h2a2 2 0 012 2v9a2 2 0 01-2 2h-2','M10 6h4','M10 10h4','M10 14h4','M10 18h4'];
        break;
    case 'copy':
        $paths = ['M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H8a2 2 0 01-2-2V6a2 2 0 012-2h2','M12 2v4','M8 10h8','M8 14h8','M8 18h5'];
        break;
    case 'phone':
        $paths = ['M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z'];
        break;
}
@endphp
@if ($paths)
<svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:1em;height:1em;display:inline-block;vertical-align:middle;{{ $style }}">
    @foreach ($paths as $d)
    <path d="{{ $d }}"/>
    @endforeach
</svg>
@endif
