<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
</head>
<body>
    <h1>Sales Report</h1>
    <table border="1">
        <tr>
            <th>Product</th>
            <th>Sales</th>
            <th>Prediction</th>
        </tr>
        @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->product_name }}</td>
            <td>{{ $sale->total_sales }}</td>
            <td>{{ $sale->predicted_sales }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
