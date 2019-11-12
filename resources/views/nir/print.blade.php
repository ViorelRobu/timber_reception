<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <style>
            body {
                font-family: arial;
                font-size: 15px;
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
                height: 200px;
            }
            .headings div {
                display: inline-block;
            }
            #furnizor {
                width: 50%;
                height: 200px;
            }
            #cumparator {
                padding-top: 53px;
                width: 50%;
                height: 200px;
            }
            .content {
                width: auto;
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
            .signatures_block {
                width: 100%;
            }
            .signature {
                width:32%;
                display: inline-block;
                padding-top: 100px;
            }

            .signature-image {
                height:100px;
                width: auto;
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
            </div>
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
        </div>
        <p></p>
        <hr>
        <div class="content">
            <p><strong>Nota de receptie {{ $nir->numar_nir }} din {{ $nir->data_nir }}</strong></p>
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
                    <td class="basic_details basic_data">{{ $nir->dvi }} din {{ $nir->data_dvi }}</td>
                </tr>
                @endif
                @if ($invoice != null)
                <tr>
                    <td class="basic_details basic_title">Factura: </td>
                    <td class="basic_details basic_data">{{ $invoice[0]->numar_factura }} din {{ $invoice[0]->data_factura }}</td>
                </tr>
                @endif
                <tr>
                    <td class="basic_details basic_title">Aviz: </td>
                    <td class="basic_details basic_data">{{ $nir->serie_aviz }} {{ $nir->numar_aviz }} din {{ $nir->data_nir }}</td>
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
                <tr>
                    <th><strong>Sortiment</strong></th>
                    <th><strong>Volum aviz (m&sup3;)</strong></th>
                    <th><strong>Volum receptionat (m&sup3;)</strong></th>
                </tr>
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
            </table>
            <br>
            <br>
            <br>
            <br>
        </div>
        <div class="reception">
            <p>COMISIA DE RECEPTIE</p>
            <div class="signatures_block">
                 @foreach ($reception_committee as $member)
                 <div class="signature">
                     {{ $member->member }}
                     <br>
                     @if ($member->img_url != null)
                        <img class="signature-image" src="storage/signatures/{{ $member->img_url }}" alt="signature">
                     @else
                        <div class="signature-image">
                            &nbsp;
                        </div>
                     @endif
                 </div>
                @endforeach
            </div>
        </div>
    </body>
</html>
