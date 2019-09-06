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
            hr {
                width: 100%;
            }
            table, th, td {
                border: 1px solid black;
            }
            .headings {
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
            #nir_details {
                border-collapse: collapse;
                width: 100%;
                text-align: center;
            }
            .basic_details {
                border: 0px solid black;
            }
            .basic_data {
                padding-left: 20px;
            }
            .basic_title {
                font-style: italic;
            }
        </style>
        <title>NIR</title>
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
            <table class="basic_details">
                @if ($nir->numar_we)
                    <tr>
                        <td class="basic_details basic_title">Numar WE: </td>
                        <td class="basic_details basic_data">{{ $nir->numar_we }}</td>
                    </tr>
                @endif
                @if ($nir->dvi)
                <tr>
                    <td class="basic_details basic_title">DVI: </td>
                    <td class="basic_details basic_data">{{ $nir->dvi }} din {{ $nir->data_dvi->format('d.m.Y') }}</td>
                </tr>
                @endif
                @if ($invoice != null)
                <tr>
                    <td class="basic_details basic_title">Factura: </td>
                    <td class="basic_details basic_data">{{ $invoice[0]->numar_factura }} din {{ $invoice[0]->data_factura->format('d.m.Y') }}</td>
                </tr>
                @endif
                <tr>
                    <td class="basic_details basic_title">Aviz: </td>
                    <td class="basic_details basic_data">{{ $nir->serie_aviz }} {{ $nir->numar_aviz }} din {{ $nir->data_nir->format('d.m.Y') }}</td>
                </tr>
                @if ($nir->specificatie)
                <tr>
                    <td class="basic_details basic_title">Specificatie: </td>
                    <td class="basic_details basic_data">{{ $nir->specificatie }}</td>
                </tr>
                @endif
                <tr>
                    <td class="basic_details basic_title">Livrat cu: </td>
                    <td class="basic_details basic_data">{{ $vehicle }} {{ $nir->numar_inmatriculare }}</td>
                </tr>
            </table>
            <hr>
            <table id="nir_details">
                <thead>
                    <td><strong>Sortiment</strong></td>
                    <td><strong>Volum aviz (m&sup3;)</strong></td>
                    <td><strong>Volum receptionat (m&sup3;)</strong></td>
                </thead>
                <tbody>
                    @foreach ($nir_details as $detail)
                        <tr>
                            <td>{{ $detail->article . ' ' .$detail->species }}, {{ $detail->moisture }}</td>
                            <td>{{ $detail->volum_aviz }}</td>
                            <td>{{ $detail->volum_receptionat }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><strong>TOTAL</strong></td>
                        <td><strong>{{ $total_aviz }}</strong></td>
                        <td><strong>{{ $total_receptionat }}</strong></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <br>
            <br>
            <br>
        </div>
        <div class="reception">
            <p>COMISIA DE RECEPTIE</p>

        </div>
    </body>
</html>