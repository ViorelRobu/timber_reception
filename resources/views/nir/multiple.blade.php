<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <style>
            /*  SECTIONS  */
            .section {
                clear: both;
                padding: 0px;
                margin: 0px;
            }

            /*  COLUMN SETUP  */
            .col {
                display: block;
                float:left;
                margin: 1% 0 1% 0%;
            }
            .col:first-child { margin-left: 0; }

            /*  GROUPING  */
            .group:before,
            .group:after { content:""; display:table; }
            .group:after { clear:both;}
            .group { zoom:1; /* For IE 6/7 */ }

            /*  GRID OF THREE  */
            .span_3_of_3 { width: 100%; }
            .span_2_of_3 { width: 66.66%; }
            .span_1_of_3 { width: 33.33%; }

            /*  GO FULL WIDTH BELOW 480 PIXELS */
            @media only screen and (max-width: 480px) {
                .col {  margin: 1% 0 1% 0%; }
                .span_3_of_3, .span_2_of_3, .span_1_of_3 { width: 100%; }
            }

            /* Custom CSS */

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
                padding-top: 10px;
            }

            .signature-image {
                height:100px;
                width: auto;
            }

            .page:last-of-type {
                page-break-after: auto;
            }
        </style>
        <title>NIR</title>
    </head>
    <body>
    @foreach ($nir as $nir)
        <div class="page" style="page-break-after:always">
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
                    <p>{{ $nir->name }}</p>
                    <p>{{ $nir->address }}</p>
                    <br>
                    <p>{{ $nir->j }}</p>
                    <p>{{ $nir->cui }}</p>
                    <p>{{ $nir->account_number }}</p>
                    <p>{{ $nir->bank }}</p>
                </div>
                <div id="furnizor">
                    <p><strong>Furnizor</strong></p>
                    <br>
                    <p>{{ $nir->supplier }}</p>
                    <p>{{ $nir->supplier_address }}</p>
                    <p>{{ $nir->supplier_country }}</p>
                    <br>
                    <p>{{ $nir->supplier_j }}</p>
                    <p>{{ $nir->supplier_cui }}</p>
                    <br>
                    <p>FIBU: {{ $nir->fibu }}</p>
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
                    @if ($nir->numar_factura)
                    <tr>
                        <td class="basic_details basic_title">Factura: </td>
                        <td class="basic_details basic_data">{{ $nir->numar_factura }} din {{ $nir->data_factura }}</td>
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
                        <td class="basic_details basic_data">{{ $nir->vehicle }} {{ $nir->numar_inmatriculare }}</td>
                    </tr>
                </table>
                <hr>
                <table id="nir_details">
                    <tr>
                        <th><strong>Sortiment</strong></th>
                        <th><strong>Volum aviz (m&sup3;)</strong></th>
                        <th><strong>Volum receptionat (m&sup3;)</strong></th>
                    </tr>
                    @for ($i = 0; $i < count($nir->details); $i++)
                        <tr>
                            <td>{{ $nir->details[$i]->article . ' ' . $nir->details[$i]->species }}, {{ $nir->details[$i]->moisture }}</td>
                            <td>{{ $nir->details[$i]->volum_aviz }}</td>
                            <td>{{ $nir->details[$i]->volum_receptionat }}</td>
                        </tr>
                    @endfor
                    <tr>
                        <td><strong>TOTAL</strong></td>
                        <td><strong>{{ $nir->totals[0]->volum_aviz }}</strong></td>
                        <td><strong>{{ $nir->totals[0]->volum_receptionat }}</strong></td>
                    </tr>
                </table>
                <br>
                <br>
                <br>
                <br>
            </div>
            <div class="reception">
                <p>COMISIA DE RECEPTIE</p>
                <div class="signatures_block section group">
                    @foreach ($reception_committee as $member)
                    <div class="col span_1_of_3 signature">
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
        </div>
    @endforeach
    </body>
</html>
