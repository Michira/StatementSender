<html>

<head>
<style type="text/css">
    body {
        font-family: Futura, Verdana, sans-serif;
        font-size: 12px;
        line-height:1.5em;
        font-weight: 400;
        width:100%;
        text-align: justify;
    }
    
    .th{
        background: #eeeeee;

    }
    .tg {
        border-collapse: collapse;
        border-spacing: 0;
        /*border-color: #ccc;*/
    }

    .tg td {
        font-family: Verdana, sans-serif;
        font-size: 14px;
        padding: 10px 5px;
        /*border-style: solid;*/
        /*border-width: 1px;*/
        overflow: hidden;
        word-break: normal;
        /*border-color: #ccc;*/
        /*color: #333;*/
        /*background-color: #fff;*/
    }

    .tg th {
        font-family: Verdana, sans-serif;
        font-size: 14px;
        font-weight: normal;
        padding: 10px 5px;
        /*border-style: solid;*/
        /*border-width: 1px;*/
        overflow: hidden;
        word-break: normal;
        /*border-color: #ccc;*/
        /*color: #333;*/
        /*background-color: #f0f0f0;*/
    }

    .tg .tg-z7id {
        font-size: 14px;
        font-family: Verdana, sans-serif;
        /*text-align: center;*/
        vertical-align: top
    }

    .tg .tg-rg0h {
        font-size: 14px;
        text-align: right;
        vertical-align: top
    }

    .logo {
        width: 190px;
        height: 100%;
        /*display: block;*/
        margin-bottom: 5%;
        margin-left: 33%;
    }

    .light {
        font-weight: 300 !important;
    }

    .signature {
        font-weight: 400;
        margin-top: 10%;
    }

    .hidden {
        display: none;
        margin-bottom: 0px;
    }

    .contacts {
        clear: both;
        /*margin-right: 280px;*/
        font-size: 12px;
        line-height:15px;
        /*float: left;*/
        text-align: left;
        color: #5c5c5c;
        margin-top: 500px;
    }

    .date {
        margin-top: 20px;
        float: left;
        font-weight: 400;
        color: #5c5c5c;
        font-size: 12px;
    }
    
    .jub-red {
        color: #ba0c2f;
    }

    .bg-red {
        background-color: #ba0c2f;
    }

    .c-white {
        color: #fff;
    }

    .no-border {
        border-bottom: solid 1px #FFF;
        border-left: solid 1px #FFF;
        border-right: solid 1px #ba0c2f;
        color: red;
    }

    /*.jlogo {*/
        /*text-align: center;*/
        /*padding: 0 0 2% 0;*/
    /*}*/

    .doctitle{
        padding: 10px;
    }

    .heading {
        float: left;
        margin-top: 30px;

    }

    .heading1 {
        font-size: 2.3em;
        margin-top: 10px;
        margin-left: 20px;

    }

    .tx-red {
        color:#ba0c2f; 
    }

    .bd-t {
        border-top: 4px solid #000;
    }

    .bd-b {
        border-bottom: 2px solid #000;
    }

    .pd {
        padding: 10px;
    }

    .ln-h-11 {
        line-height: 1.1em;
    }
    .tx-14 {
        font-size: 14px;
    }

    .page-break {
        page-break-after: always;
    }

    .header, .footer {
        position: fixed;
    }

    .header {
        top: 0;
    }

    .footer {
        bottom: 15;
        font-size: 10px;
    }


    table.table-definition {
        border-collapse: collapse;
        padding: 20px;        
    }

    table.table-definition, .table-definition th, .table-definition td {
      border: 1px solid black;
      padding: 10px 5px;
    }

</style>
</head>
<body>
    <p> Dear Client, <br>Please see your Cytonn statement below broken down per product.</p>
     @foreach($client_trans as $ctrans) 
     <h3>{{$ctrans['product']}}</h3>
     <table class="table-definition" width="100%">
             <tr>
                 <th>Trans ID</th>
                 <th>Trans Type</th>
                 <th>Trans Amount</th>
                 <th>Trans Date</th>
             </tr>
             @foreach($ctrans['transactions'] as $trans) 
             <tr>
                 <td>{{$trans->id}}</td>
                 <td>{{$trans->trans_type=='d' ? 'Deposit' : 'Withdrawal' }}</td>
                 <td>{{$trans->trans_amount}}</td>
                 <td>{{$trans->trans_date}}</td>
             </tr>
             @endforeach
     </table>
     <div class="page-break"></div>
     @endforeach


   


</body>
</html>

