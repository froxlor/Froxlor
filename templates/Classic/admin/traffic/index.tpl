$header
	<script type="text/javascript" src="templates/jquery.tablesorter.min.js"></script> 
        <script type="text/javascript">
                $.tablesorter.addParser( {
                        id: 'filesize',
                        is: function(s) {
                                return s.match( new RegExp( /[0-9]+(\.[0-9]+)?\ (KiB|Bi|GiB|MiB|TiB)/ ) );
                        },
                        format: function(s) {
                                var suf = s.match( new RegExp( /(KiB|Bi|GiB|MiB|TiB)/) )[1];
                                var num = parseFloat( s.match( new RegExp( /^[0-9]+(\.[0-9]+)?/ ) )[0] );
                                switch( suf ) {
                                        case 'Bi':
                                                return num;
                                        case 'KiB':
                                                return num * 1024;
                                        case 'MiB':
                                                return num * 1024 * 1024;
                                        case 'GiB':
                                                return num * 1024 * 1024 * 1024;
                                        case 'TiB':
                                                return num * 1024 * 1024 * 1024 * 1024;
                                }
                        },
                        type: 'numeric'
                });
        </script>
	{$stats_tables}
	<br />
	<br />
$footer
