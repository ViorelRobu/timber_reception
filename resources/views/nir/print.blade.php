<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <style>
            body {
                font-family: arial;
                font-size: 20px;
            }
            p {
                margin: 0;
            }
            .headings {
                width: 100%;
            }
            hr {
                width: 100%;
            }
            #furnizor {
                float: left;
                width: 50%;
            }
            #cumparator {
                float: right;
                width: 50%;
            }
            .content {
                width: 100%;
            }
        </style>
        <title>Hello, world!</title>
    </head>
    <body>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="headings">
            <div id="furnizor">
                <p><strong>Furnizor</strong></p>
                <br>
                <p>{{ $supplier[0]->name }}</p>
                <p>{{ $supplier[0]->address }}</p>
                <p>{{ $country }}</p>
                <br>
                <p>{{ $supplier[0]->j }}</p>
                <p>{{ $supplier[0]->cui }}</p>
                <br>
                <p>FIBU: {{ $supplier[0]->fibu }}</p>                
            </div>
            <div id="cumparator">
                <p><strong>Cumparator</strong></p>
                <br>
                <p>{{ $company[0]->name }}</p>
                <p>{{ $company[0]->address }}</p>
                <br>
                <p>{{ $company[0]->j }}</p>
                <p>{{ $company[0]->cui }}</p>
                <p>{{ $company[0]->account_number }}</p>
                <p>{{ $company[0]->bank }}</p>
                <br>
            </div>

        </div>
        <p></p>
        <hr>
        <div class="content">
            <p><strong>Nota de receptie {{ $nir->numar_nir }} din {{ $nir->data_nir->format('d.m.Y') }}</strong></p>
            <hr>
            @if ($nir->numar_we)
                <p>Numar WE: {{ $nir->numar_we }}</p>
            @endif
            @if ($nir->dvi)
                <p>DVI: {{ $nir->dvi }} din {{ $nir->data_dvi->format('d.m.Y') }}</p>
            @endif
            @if ($invoice)
                <p>Factura: {{ $invoice[0]->numar_factura }} din {{ $invoice[0]->data_factura->format('d.m.Y') }}</p>
            @endif
            <p>Aviz: {{ $nir->serie_aviz }} {{ $nir->numar_aviz }} din {{ $nir->data_nir->format('d.m.Y') }}</p>
            @if ($nir->specificatie)
                <p>Specificatie: {{ $nir->specificatie }}</p>
            @endif
            <p>Livrat cu {{ $vehicle }} {{ $nir->numar_inmatriculare }}</p>
            <hr>
        </div>
    </body>
</html>