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
            .bottom_border {
                border-bottom: 1px solid black;
            }
            .basic_data {
                padding-left: 20px;
                width: 90%;
                word-break: break-all;
                word-wrap: break-word;
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
            .total {
                font-weight: bold;
                text-align: right;
            }
            .user {
                position: fixed;
                bottom: 8px;
                right: -600%;
            }
            img {
                height: 150px;
            }
        </style>
        <title>Reclamatie calitate</title>
    </head>
    <body>
        <img src="img/logo.jpg" alt="logo">
        <div class="headings">
            <div id="cumparator">
                <p><strong>Cumparator</strong></p>
                <br>
                <p>{{ $company->name }}</p>
                <p>{{ $company->address }}</p>
                <br>
                <p>{{ $company->j }}</p>
                <p>{{ $company->cui }}</p>
                <p>{{ $company->account_number }}</p>
                <p>{{ $company->bank }}</p>
            </div>
            <div id="furnizor">
                <p><strong>Furnizor</strong></p>
                <br>
                <p>{{ $supplier->name }}</p>
                <p>{{ $supplier->address }}</p>
                <p>{{ $country->name }}</p>
                <br>
                <p>{{ $supplier->j }}</p>
                <p>{{ $supplier->cui }}</p>
                <br>
                <p>FIBU: {{ $supplier->fibu }}</p>
            </div>
        </div>
        <p></p>
        <hr>
        <div class="content">
            <p><strong>Reclamatie calitate nr {{ $claim->id }} din {{ date("d.m.Y", strtotime($claim->claim_date)) }}</strong></p>
            <hr>
            <table class="basic_details">
                <tr>
                    <td class="basic_details basic_title">Perioada livrare </td>
                    <td class="basic_details basic_data bottom_border">{{ $start }} - {{ $end }}</td>
                </tr>
                <tr>
                    <td class="basic_details basic_title">Facturi </td>
                    <td class="basic_details basic_data bottom_border">{{ $invoices }}</td>
                </tr>
                <tr>
                    <td class="basic_details basic_title">Defecte </td>
                    <td class="basic_details basic_data bottom_border">{{ $claim->defects }}</td>
                </tr>
                <tr>
                    <td class="basic_details basic_title">Observatii </td>
                    <td class="basic_details basic_data">{{ $claim->observations }}</td>
                </tr>
            </table>
            <hr>
                <p class="total">
                    Cantitatea reclamata: {{ $claim->claim_amount }}m&sup3;
                </p>
                <p class="total">
                    Valoare: {{ $claim->claim_value }} {{ $claim->claim_currency }}
                </p>
            <hr>
            <p class="user">Creata de {{ $user }}</p>
        </div>
    </body>
</html>
